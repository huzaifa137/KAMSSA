<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentExamImport;
use App\Models\AnnualExamination;
use App\Models\Exam;
use App\Models\House;
use App\Models\MasterData;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Services\GradingService;
use Illuminate\Support\Facades\DB;

class GradingController extends Controller
{
    public function importMarks()
    {
        $students = Student::with('school')
            ->fromSub(function ($query) {
                $query->from('students')
                    ->select('*')
                    ->selectRaw(
                        'ROW_NUMBER() OVER (
                    PARTITION BY school_id
                    ORDER BY id
                ) as row_num'
                    );
            }, 'students')
            ->where('row_num', '<=', 1)
            ->orderBy('school_id')
            ->orderBy('id')
            ->get();

        $groupedStudents = $students->groupBy(function ($student) {
            return $student->school->name;
        });

        $ucePapers = MasterData::where(
            'md_master_code_id',
            config('constants.options.UCEPapers')
        )->get();

        $uacePapers = MasterData::where(
            'md_master_code_id',
            config('constants.options.UACEPapers')
        )->get();


        $plePapers = MasterData::where(
            'md_master_code_id',
            config('constants.options.PLEPapers')
        )->get();


        return view('Grading.import-marks', compact(
            'groupedStudents',
            'ucePapers',
            'uacePapers',
            'plePapers'
        ));
    }

    public function createExamination()
    {
        // Admin
        $activeYear = AcademicYear::orderBy('id', 'desc')
            ->where('is_active', 1)
            ->value('name');

        $schools = MasterData::where('md_master_code_id', config('constants.options.SCHOOL_TERMS'))->get();

        return view(
            'Grading.create-examination',
            compact('activeYear')
        );
    }

    public function storeCreatedExamination(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'ExaminationName' => 'required|string',
            'year' => 'required|integer',
            'marks_upload_enabled' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Map master-data IDs to examination names (UCE=24, UACE=25, PLE=23 per constants)
        $nameMap = [
            (string) config('constants.options.UACEPapers') => 'UACE',
            (string) config('constants.options.UCEPapers')  => 'UCE',
            // (string) config('constants.options.PLEPapers')  => 'PLE',
        ];
        $examination_name = $nameMap[$request->ExaminationName] ?? 'UCE';

        $existingExam = AnnualExamination::where('year', $request->year)
            ->where('examination_name', $examination_name)
            ->first();

        if ($existingExam) {
            return response()->json([
                'errors' => ['year' => ["An examination with name '{$examination_name}' for this year already exists."]]
            ], 422);
        }

        $activeExam = AnnualExamination::where('year', $request->year)
            ->where('examination_name', $examination_name)
            ->where('is_active', true)
            ->first();

        if ($activeExam) {
            return response()->json([
                'errors' => ['is_active' => ["There is an existing active examination '{$examination_name}' for this year. Please disable it first."]]
            ], 422);
        }

        $oldActiveExam = AnnualExamination::where('year', '!=', $request->year)
            ->where('examination_name', $examination_name)
            ->where('is_active', true)
            ->first();

        if ($oldActiveExam) {
            return response()->json([
                'errors' => ['is_active' => ["There is an existing old active examination '{$examination_name}' for the '{$oldActiveExam->year}'. Please disable this year '{$oldActiveExam->year}' first."]]
            ], 422);
        }

        AnnualExamination::create([
            'examination_name' => $examination_name,
            'examination_classification' => $examination_name,
            'year' => $request->year,
            'is_active' => (bool) $request->marks_upload_enabled,
        ]);

        return response()->json(['success' => true, 'message' => 'Examination created successfully.']);
    }

    public function toggleExamActive(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:annual_examinations,id',
            'is_active' => 'required|boolean',
        ]);

        $exam = AnnualExamination::findOrFail($request->exam_id);

        if ($request->is_active) {
            AnnualExamination::where('examination_name', $exam->examination_name)
                ->where('id', '!=', $exam->id)
                ->update(['is_active' => false]);
        }

        $exam->is_active = $request->is_active;
        $exam->save();

        return response()->json([
            'success' => true,
            'message' => $request->is_active
                ? "Exam '{$exam->examination_name}' activated."
                : "Exam '{$exam->examination_name}' deactivated."
        ]);
    }

    public function getExamYears()
    {
        $years = AnnualExamination::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return response()->json($years);
    }

    public function getExamsByYear($year)
    {
        $exams = AnnualExamination::where('year', $year)
            ->orderBy('examination_name', 'asc')
            ->get();

        return response()->json($exams);
    }

    public function getActiveExams()
    {
        $activeExams = AnnualExamination::where('is_active', true)
            ->orderBy('examination_name')
            ->get();

        return response()->json($activeExams);
    }

    public function importUceResults(Request $request)
    {
        return $this->handleExamImport($request, 'uce');
    }

    public function importUaceResults(Request $request)
    {
        return $this->handleExamImport($request, 'uace');
    }

    public function importPleResults(Request $request)
    {
        return $this->handleExamImport($request, 'ple');
    }

    private function handleExamImport(Request $request, $examType)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $activeYear = Helper::active_year();
        if ($activeYear == 'No Active year Set') {
            return back()->with('error', 'No Active Academic Year Set.');
        }

        if ($examType === 'uace') {
            $uploadingYear = Helper::activeUploadingUaceYear();
        } elseif ($examType === 'ple') {
            $uploadingYear = Helper::activeUploadingPleYear();
        } else {
            $uploadingYear = Helper::activeUploadingUceYear();
        }

        if ($uploadingYear === 'Upload Year Not Set') {
            return back()->with('error', ucfirst($examType) . ' upload is not currently active.');
        }

        if ($uploadingYear !== $activeYear) {
            return back()->with(
                'error',
                ucfirst($examType) . " upload is active for {$uploadingYear}, but academic year is {$activeYear}."
            );
        }

        if ($examType === 'uace') {
            $subjects = MasterData::where('md_master_code_id', config('constants.options.UACEPapers'))->get();
        } elseif ($examType === 'ple') {
            $subjects = MasterData::where('md_master_code_id', config('constants.options.PLEPapers'))->get();
        } else {
            $subjects = MasterData::where('md_master_code_id', config('constants.options.UCEPapers'))->get();
        }

        if ($subjects->isEmpty()) {
            return back()->with('error', 'No subjects found for this exam type.');
        }

        DB::beginTransaction();

        try {

            // 🔎 Check existing exam
            $existingExam = Exam::where('school_id', $request->school_id)
                ->where('exam_type', $examType)
                ->where('academic_year', $activeYear)
                ->first();

            if ($existingExam) {
                $existingExam->delete();
            }

            // ✅ Create fresh exam
            $exam = Exam::create([
                'school_id' => $request->school_id,
                'exam_type' => $examType,
                'academic_year' => $activeYear
            ]);

            Excel::import(new StudentExamImport($exam, $subjects), $request->file('file'));

            DB::commit();

            return back()->with('success', ucfirst($examType) . ' results uploaded successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function showExamResults($examId, GradingService $gradingService)
    {

        $results = $gradingService->calculateExamResults($examId);

        $results = $results->map(function ($result) {

            $student = $result->student;

            $result->student_name = $student->firstname . ' ' . $student->lastname;
            $result->admission_number = $student->admission_number;
            $result->gender = $student->gender;
            $result->stream = $student->stream;
            $result->school_name = $student->school->name ?? 'N/A';

            return $result;
        });

        return view('Grading.grade-summary', compact('results'));
    }

    public function gradingDashboard(Request $request, GradingService $gradingService)
    {
        // Filters
        $examType = $request->exam_type;
        $academicYear = $request->academic_year;
        $schoolId = $request->school_id;

        $query = Exam::query();

        if ($examType) {
            $query->where('exam_type', $examType);
        }

        if ($academicYear) {
            $query->where('academic_year', $academicYear);
        }

        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }

        $exams = $query->get();

        $results = collect();

        foreach ($exams as $exam) {
            $examResults = $gradingService->calculateExamResults($exam->id);
            $results = $results->merge($examResults);
        }

        // National ranking across merged results
        $results = $results->sortByDesc('total_marks')->values();

        $rank = 1;
        $previousMarks = null;

        foreach ($results as $index => $student) {

            if ($previousMarks !== null && $student->total_marks < $previousMarks) {
                $rank = $index + 1;
            }

            $results[$index]->national_rank = $rank;

            $previousMarks = $student->total_marks;
        }


        // Subject statistics
        $subjectStats = null;
        if ($examType && $academicYear) {
            $subjectStats = $gradingService->subjectStatistics($examType, $academicYear);
        }

        $schools = House::all();
        $years = Exam::select('academic_year')->distinct()->pluck('academic_year');

        return view('Grading.dashboard', compact(
            'results',
            'schools',
            'years',
            'subjectStats'
        ));
    }
}