<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Exports\ClassStudentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\CreatedExam;
use App\Models\MasterData;
use App\Models\TermDate;
use App\Models\StudentResult;
use App\Models\StudentExamSummary;
use App\Imports\ClassResultsImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Mpdf\Mpdf;

class ExamController extends Controller
{

    public function schoolStudents()
    {
        // Admin
        $school_id = session('LoggedSchool');

        if (!$school_id) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Please select a school to proceed.');
        }

        $activeYear = AcademicYear::orderBy('id', 'desc')
            ->where('is_active', 1)
            ->value('name');

        $termDates = TermDate::where('school_id', $school_id)
            ->orderBy('term', 'asc')
            ->get();

        $SecondaryClasses = Helper::MasterRecordMerge(
            config('constants.options.O_LEVEL'),
            config('constants.options.A_LEVEL')
        );

        $schools = MasterData::where('md_master_code_id', config('constants.options.SCHOOL_TERMS'))->get();

        return view(
            'Exam.specific-school-students',
            compact('activeYear', 'termDates', 'SecondaryClasses')
        );
    }


    public function storeCreatedExam(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'exam_name' => 'required|string|max:255',
            'term' => 'required|integer',
            'class_ids' => 'required|array|min:1',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $exam = CreatedExam::create([
            'ce_exam_name' => $request->exam_name,
            'ce_term' => $request->term,
            'ce_class_ids' => json_encode($request->class_ids),
            'ce_exam_year' => Helper::active_year(),
            'ce_created_by' => session('LoggedStudent'),
            'ce_date_created' => now()->toISOString(),
        ]);

        return response()->json(['message' => 'Exam created successfully!']);
    }

    public function manageExams()
    {
        $activeYear = Helper::active_year();

        $exams = CreatedExam::where('ce_exam_year', $activeYear)
            ->orderBy('ce_term')
            ->orderBy('ce_date_created', 'desc')
            ->get()
            ->groupBy('ce_term');

        return view('Exam.manage-exams', compact('exams', 'activeYear'));
    }

    public function editExams()
    {

        return view('Exam.edit-exams');
    }

    public function uploadExams()
    {
        $activeYear = Helper::active_year();

        $exams = CreatedExam::where('ce_exam_year', $activeYear)
            ->where('ce_exam_status', 0)
            ->orderBy('ce_term')
            ->orderBy('ce_date_created', 'desc')
            ->get()
            ->groupBy('ce_term');

        return view('Exam.upload-exams', compact('exams', 'activeYear'));
    }

    public function downloadClassList($examId, $classId)
    {
        $exam = CreatedExam::findOrFail($examId);

        return Excel::download(
            new ClassStudentsExport($classId),
            Helper::item_md_name($classId) . '_Class_List.xlsx'
        );
    }


    public function uploadResults(Request $request)
    {

        $request->validate([
            'exam_id' => 'required|exists:created_exams,id',
            'class_id' => 'required',
            'results_file' => 'required|file|mimes:xlsx,xls',
        ]);


        Excel::import(
            new ClassResultsImport($request->class_id, $request->exam_id),
            $request->file('results_file')
        );

        CreatedExam::where('id', $request->exam_id)
            ->update(['ce_exam_status' => 1]);

        return back()->with('success', 'Results uploaded successfully.');
    }

    public function calculateExamResults()
    {

        $pendingComputations = StudentResult::select(
            'exam_id',
            'class_id',
            DB::raw('COUNT(DISTINCT student_id) as students'),
            DB::raw('MAX(compute_status) as compute_status')
        )
            ->where('school_id', session('LoggedSchool'))
            ->groupBy('exam_id', 'class_id')
            ->get();

        return view('Exam.compute-results', compact('pendingComputations'));
    }

    public function computeResults(Request $request)
    {
        $request->validate([
            'exam_id' => 'required',
            'class_id' => 'required',
        ]);

        $examId = $request->exam_id;
        $classId = $request->class_id;
        $schoolId = session('LoggedSchool');

        // 1️⃣ Prevent recompute
        $alreadyComputed = StudentResult::where('exam_id', $examId)
            ->where('class_id', $classId)
            ->where('school_id', $schoolId)
            ->where('compute_status', 2)
            ->exists();

        if ($alreadyComputed) {
            return back()->with('error', 'Results already computed.');
        }

        // 2️⃣ Expected subjects
        $expectedSubjects = StudentResult::where('exam_id', $examId)
            ->where('class_id', $classId)
            ->where('school_id', $schoolId)
            ->distinct('subject_id')
            ->count();

        // 3️⃣ Compute aggregates
        $computed = StudentResult::select(
            'student_id',
            'stream_id',
            DB::raw('SUM(marks) as total_marks'),
            DB::raw('COUNT(subject_id) as subject_count'),
            DB::raw('ROUND(SUM(marks) / COUNT(subject_id), 2) as average')
        )
            ->where('exam_id', $examId)
            ->where('class_id', $classId)
            ->where('school_id', $schoolId)
            ->groupBy('student_id', 'stream_id')
            ->havingRaw('COUNT(subject_id) = ?', [$expectedSubjects])
            ->orderByDesc(DB::raw('SUM(marks) / COUNT(subject_id)'))
            ->get();

        DB::transaction(function () use ($computed, $examId, $classId, $schoolId) {

            $rank = 1;

            foreach ($computed as $row) {

                $grade = Helper::gradeFromAverage($row->average);

                StudentExamSummary::updateOrCreate(
                    [
                        'student_id' => $row->student_id,
                        'exam_id' => $examId,
                        'class_id' => $classId,
                        'school_id' => $schoolId,
                    ],
                    [
                        'stream_id' => $row->stream_id,
                        'subjects_count' => $row->subject_count,
                        'total_marks' => $row->total_marks,
                        'average' => $row->average,
                        'rank' => $rank++,
                        'grade' => $grade,
                    ]
                );
            }

            // Mark results as computed
            StudentResult::where('exam_id', $examId)
                ->where('class_id', $classId)
                ->where('school_id', $schoolId)
                ->update(['compute_status' => 2]);
        });


        // 5️⃣ Redirect to download ranked list
        return redirect()->route('exams.download.ranked', [
            'exam' => $examId,
            'class' => $classId
        ])->with('success', 'Results computed successfully.');
    }


    public function downloadRankedResults($examId, $classId)
    {
        $schoolId = session('LoggedSchool');

        // Fetch computed ranking
        $rankedStudents = StudentExamSummary::where('exam_id', $examId)
            ->where('class_id', $classId)
            ->where('school_id', $schoolId)
            ->orderBy('rank', 'asc')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'rank' => $item->rank,
                    'student_name' => Helper::school_student_fullName($item->student_id),
                    'total_marks' => $item->total_marks,
                    'average' => $item->average,
                    'grade' => $item->grade,
                    'stream_name' => Helper::item_md_name($item->stream_id),
                ];
            });

        $className = Helper::item_md_name($classId);
        $examName = Helper::db_item_from_column('created_exams', $examId, 'ce_exam_name');
        $year = Helper::active_year();

        $pdf = PDF::loadView('Exam.ranked-results-pdf', compact('rankedStudents', 'className', 'examName', 'year'));

        return $pdf->download("class_ranking_{$className}_{$examName}.pdf");
    }

    // Report Generation / English Versions
    // public function downloadReportCard($examId, $classId)
    // {
    //     $schoolId = session('LoggedSchool');

    //     $students = StudentResult::where('exam_id', $examId)
    //         ->where('class_id', $classId)
    //         ->where('school_id', $schoolId)
    //         ->with('student')
    //         ->get()
    //         ->groupBy('student_id');

    //     $className = Helper::item_md_name($classId);
    //     $examName = Helper::db_item_from_column('created_exams', $examId, 'ce_exam_name');

    //     $pdf = Pdf::loadView('Exam.report-card-template', [
    //         'students' => $students,
    //         'className' => $className,
    //         'examName' => $examName,
    //         'schoolName' => 'Wisdom Islamic Primary School - Kinyogogo',
    //     ])
    //         ->setPaper('a4', 'portrait')
    //         // Reduced margins to '0' here because we will handle them in CSS 
    //         // for better precision with borders.
    //         ->setOption('margin-top', 0)
    //         ->setOption('margin-bottom', 0)
    //         ->setOption('margin-left', 0)
    //         ->setOption('margin-right', 0);

    //     return $pdf->download("ReportCard_{$className}_{$examName}.pdf");
    // }

    public function downloadReportCard($examId, $classId)
    {
        $schoolId = session('LoggedSchool');

        $students = StudentResult::where('exam_id', $examId)
            ->where('class_id', $classId)
            ->where('school_id', $schoolId)
            ->with('student')
            ->get()
            ->groupBy('student_id');

        $className = Helper::item_md_name($classId);
        $examName = Helper::db_item_from_column('created_exams', $examId, 'ce_exam_name');
        $schoolName = Helper::current_logged_school(Session('LoggedSchool'));

        $html = view('Exam.arabic-report-card-template', compact(
            'students',
            'className',
            'examName',
            'schoolName',

        ))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans'
        ]);

        // $mpdf->SetDirectionality('rtl'); // CRITICAL
        $mpdf->WriteHTML($html);

        return response($mpdf->Output("ReportCard_{$className}_{$examName}.pdf", 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="ReportCard.pdf"');
    }
}
