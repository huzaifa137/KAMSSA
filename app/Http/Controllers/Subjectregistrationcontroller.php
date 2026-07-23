<?php

namespace App\Http\Controllers;

use App\Exports\SubjectRegistrationTemplateExport;
use App\Imports\SubjectRegistrationImport;
use App\Models\ClassAllocation;
use App\Models\House;
use App\Models\MasterData;
use App\Models\StudentBasic;
use App\Models\StudentCombination;
use App\Models\StudentSubjectRegistration;
use App\Services\CombinationService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class SubjectRegistrationController extends Controller
{
    /** Only these categories have per-student optional subject combinations. */
    private $eligibleCategories = [
        'UCE' => 'UCE (O-LEVEL)',
        'UACE' => 'UACE (A-LEVEL)',
    ];

    public function __construct(private CombinationService $combinations)
    {
    }

    /**
     * Selection screen: pick year / category / school.
     */
    public function index()
    {
        $houses = House::all();
        $categories = $this->eligibleCategories;

        return view('itemGrading.subject-registration.select', compact('houses', 'categories'));
    }

    /**
     * Management grid for a chosen year/category/school: shows every
     * student, every available subject, and which ones are registered.
     */
    public function manage(Request $request)
    {
        $request->validate([
            'year' => 'required|digits:4',
            'category' => 'required|in:UCE,UACE',
            'school_number' => 'required|string',
        ]);

        $year = $request->year;
        $category = $request->category;
        $schoolNumber = $request->school_number;

        $subjects = $this->subjectsForCategory($category);

        $students = ClassAllocation::where('Student_ID', 'LIKE', "$schoolNumber-%")
            ->where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->select('Student_ID')
            ->distinct()
            ->orderBy('Student_ID')
            ->get();

        $names = StudentBasic::whereIn('Student_ID', $students->pluck('Student_ID'))
            ->pluck('Student_Name', 'Student_ID');

        $registrations = StudentSubjectRegistration::whereIn('student_id', $students->pluck('Student_ID'))
            ->where('year', $year)
            ->get()
            ->groupBy('student_id')
            ->map(fn($rows) => $rows->pluck('subject_id')->flip());

        // Auto-register compulsory subjects for anyone missing them, so the
        // grid (and marks entry later) never blocks on a forgotten
        // compulsory subject.
        $compulsorySubjectIds = $subjects->where('md_misc1', 'Compulsory')->pluck('md_id');
        foreach ($students as $student) {
            $already = $registrations->get($student->Student_ID, collect());
            foreach ($compulsorySubjectIds as $subjectId) {
                if (!$already->has($subjectId)) {
                    StudentSubjectRegistration::firstOrCreate(
                        ['student_id' => $student->Student_ID, 'subject_id' => $subjectId, 'year' => $year],
                        ['category' => $category, 'is_compulsory' => true, 'school_number' => $schoolNumber]
                    );
                }
            }
        }

        // Reload after auto-registering compulsories.
        $registrations = StudentSubjectRegistration::whereIn('student_id', $students->pluck('Student_ID'))
            ->where('year', $year)
            ->get()
            ->groupBy('student_id')
            ->map(fn($rows) => $rows->pluck('subject_id')->flip());

        $schoolName = Helper::schoolName($schoolNumber);

        // UACE uses a Combination picker instead of free-tick optional
        // subjects — load the Active combination list and each student's
        // current assignment (if any).
        $combinationsList = collect();
        $studentCombinations = collect();
        if ($category === 'UACE') {
            $combinationsList = $this->combinations->activeForCategory('UACE');
            $studentCombinations = StudentCombination::whereIn('student_id', $students->pluck('Student_ID'))
                ->where('year', $year)
                ->pluck('combination_id', 'student_id');
        }

        return view('itemGrading.subject-registration.manage', compact(
            'students',
            'names',
            'subjects',
            'registrations',
            'year',
            'category',
            'schoolNumber',
            'schoolName',
            'combinationsList',
            'studentCombinations'
        ));
    }

    /**
     * AJAX: assign (or change) a student's UACE combination. Syncs
     * student_subject_registrations to match automatically — see
     * CombinationService for the sync rules.
     */
    public function setCombination(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
            'combination_id' => 'nullable|integer|exists:combinations,id',
            'year' => 'required|digits:4',
            'category' => 'required|in:UACE',
            'school_number' => 'required|string',
        ]);

        if (!$request->combination_id) {
            $this->combinations->clearStudentCombination($request->student_id, $request->year);
            return response()->json(['success' => true, 'message' => 'Combination cleared.']);
        }

        $studentCombination = $this->combinations->setStudentCombination(
            $request->student_id,
            (int) $request->combination_id,
            $request->category,
            $request->year,
            $request->school_number
        );

        return response()->json([
            'success' => true,
            'combination_id' => $studentCombination->combination_id,
            'message' => 'Combination assigned.',
        ]);
    }

    /**
     * AJAX: toggle one student/subject registration on or off.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
            'subject_id' => 'required|integer',
            'year' => 'required|digits:4',
            'category' => 'required|in:UCE,UACE',
            'checked' => 'required|boolean',
        ]);

        $subject = MasterData::find($request->subject_id);

        if ($subject && $subject->md_misc1 === 'Compulsory' && !$request->checked) {
            return response()->json([
                'success' => false,
                'message' => 'This subject is compulsory and cannot be unregistered.',
            ], 422);
        }

        if ($request->checked) {
            StudentSubjectRegistration::updateOrCreate(
                [
                    'student_id' => $request->student_id,
                    'subject_id' => $request->subject_id,
                    'year' => $request->year,
                ],
                [
                    'category' => $request->category,
                    'is_compulsory' => false,
                    'school_number' => explode('-', $request->student_id)[0] . '-' . explode('-', $request->student_id)[1],
                ]
            );
        } else {
            StudentSubjectRegistration::where('student_id', $request->student_id)
                ->where('subject_id', $request->subject_id)
                ->where('year', $request->year)
                ->delete();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Download the fill-in Excel template for a year/category/school.
     */
    public function downloadTemplate(Request $request)
    {
        $request->validate([
            'year' => 'required|digits:4',
            'category' => 'required|in:UCE,UACE',
            'school_number' => 'required|string',
        ]);

        $filename = "subject-registration-{$request->category}-{$request->school_number}-{$request->year}.xlsx";

        return Excel::download(
            new SubjectRegistrationTemplateExport($request->category, $request->year, $request->school_number),
            $filename
        );
    }

    /**
     * Import a filled-in Excel template, registering each student's
     * compulsory + chosen optional subjects for that year.
     */
    public function import(Request $request)
    {
        $request->validate([
            'year' => 'required|digits:4',
            'category' => 'required|in:UCE,UACE',
            'school_number' => 'required|string',
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $import = new SubjectRegistrationImport($request->category, $request->year, $request->school_number);

        try {
            Excel::import($import, $request->file('file'));
        } catch (ValidationException $e) {
            return back()->withErrors(['import_errors' => $e->errors()])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['import_errors' => ['Could not read the file: ' . $e->getMessage()]])->withInput();
        }

        $summary = $import->getSummary();

        return redirect()
            ->route('subject.registration.manage', [
                'year' => $request->year,
                'category' => $request->category,
                'school_number' => $request->school_number,
            ])
            ->with('success', "Imported subject registrations for {$summary['students_processed']} student(s).")
            ->with('import_skipped', $summary['skipped']);
    }

    private function subjectsForCategory(string $category)
    {
        $masterCode = $category === 'UACE'
            ? config('constants.options.UACEPapers')
            : config('constants.options.UCEPapers');

        return MasterData::where('md_master_code_id', $masterCode)
            ->where(function ($q) {
                $q->whereNull('md_misc2')->orWhere('md_misc2', '!=', 'Inactive');
            })
            ->orderByRaw("md_misc1 = 'Compulsory' desc")
            ->orderBy('md_name')
            ->get();
    }
}