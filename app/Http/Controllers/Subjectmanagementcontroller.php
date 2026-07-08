<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\MasterData;
use App\Models\StudentSubjectRegistration;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * CRUD management for the UCE/UACE subject master list (stored in
 * master_datas, keyed by md_master_code_id = UCEPapers/UACEPapers).
 *
 * This is the "source of truth" screen that feeds:
 *   - Subject Registration (per-student optional subject selection)
 *   - Subject Registration Excel template/import
 *   - Marks entry subject columns (via student_subject_registrations)
 */
class SubjectManagementController extends Controller
{
    private $categories = [
        'UCE' => 'UCE (O-Level)',
        'UACE' => 'UACE (A-Level)',
    ];

    /**
     * List every UCE/UACE subject, grouped by category, with usage counts
     * so the view can warn before a destructive delete.
     */
    public function index()
    {
        $categories = $this->categories;
        $subjects = [];

        foreach ($categories as $code => $label) {
            $masterCodeId = $this->masterCodeFor($code);

            $rows = MasterData::where('md_master_code_id', $masterCodeId)
                ->orderByRaw("md_misc1 = 'Compulsory' desc")
                ->orderBy('md_name')
                ->get();

            $registrationCounts = StudentSubjectRegistration::whereIn('subject_id', $rows->pluck('md_id'))
                ->selectRaw('subject_id, count(*) as total')
                ->groupBy('subject_id')
                ->pluck('total', 'subject_id');

            $markCounts = Mark::whereIn('subject_id', $rows->pluck('md_id'))
                ->selectRaw('subject_id, count(*) as total')
                ->groupBy('subject_id')
                ->pluck('total', 'subject_id');

            $subjects[$code] = $rows->map(function ($row) use ($registrationCounts, $markCounts) {
                $row->registration_count = $registrationCounts[$row->md_id] ?? 0;
                $row->mark_count = $markCounts[$row->md_id] ?? 0;
                $row->is_active = $row->md_misc2 !== 'Inactive';
                return $row;
            });
        }

        return view('itemGrading.subject-management.index', compact('categories', 'subjects'));
    }

    /**
     * Create a new subject under UCE or UACE.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => ['required', Rule::in(array_keys($this->categories))],
            'code' => ['required', 'string', 'max:15', 'alpha_num'],
            'name' => ['required', 'string', 'max:150'],
            'status' => ['required', Rule::in(['Compulsory', 'Optional'])],
        ]);

        $masterCodeId = $this->masterCodeFor($validated['category']);
        $code = strtoupper($validated['code']);

        $exists = MasterData::where('md_master_code_id', $masterCodeId)
            ->where('md_code', $code)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['code' => "Subject code '{$code}' already exists under {$this->categories[$validated['category']]}."])
                ->withInput();
        }

        MasterData::create([
            'md_master_code_id' => $masterCodeId,
            'md_code' => $code,
            'md_name' => $validated['name'],
            'md_description' => $validated['status'] . ' subject',
            'md_date_added' => now()->toDateString(),
            'md_added_by' => auth()->user()->name ?? 'admin',
            'md_misc1' => $validated['status'],
            'md_misc2' => 'Active',
        ]);

        return back()->with('success', "Subject '{$validated['name']}' added to {$this->categories[$validated['category']]}.");
    }

    /**
     * Update a subject's code, name, or compulsory/optional status.
     * Category (which examination it belongs to) is intentionally
     * immutable here — create a new subject instead if it moved category.
     */
    public function update(Request $request, $id)
    {
        $subject = MasterData::findOrFail($id);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:15', 'alpha_num'],
            'name' => ['required', 'string', 'max:150'],
            'status' => ['required', Rule::in(['Compulsory', 'Optional'])],
        ]);

        $code = strtoupper($validated['code']);

        $duplicate = MasterData::where('md_master_code_id', $subject->md_master_code_id)
            ->where('md_code', $code)
            ->where('md_id', '!=', $subject->md_id)
            ->exists();

        if ($duplicate) {
            return back()->withErrors(['code' => "Subject code '{$code}' is already used by another subject in this category."])->withInput();
        }

        $subject->update([
            'md_code' => $code,
            'md_name' => $validated['name'],
            'md_misc1' => $validated['status'],
            'md_description' => $validated['status'] . ' subject',
        ]);

        return back()->with('success', "Subject '{$validated['name']}' updated.");
    }

    /**
     * Flip a subject between Active / Inactive without deleting it.
     * Inactive subjects disappear from new registrations, the Excel
     * template, and the import's accepted-subjects list, but any marks
     * or registrations already recorded against them are left untouched.
     */
    public function toggleStatus($id)
    {
        $subject = MasterData::findOrFail($id);

        $subject->md_misc2 = $subject->md_misc2 === 'Inactive' ? 'Active' : 'Inactive';
        $subject->save();

        return response()->json([
            'success' => true,
            'status' => $subject->md_misc2,
            'message' => "Subject marked {$subject->md_misc2}.",
        ]);
    }

    /**
     * Hard-delete a subject — only allowed when nothing references it yet
     * (no student registrations, no marks). Otherwise the admin is told to
     * deactivate it instead, so historic data stays intact.
     */
    public function destroy($id)
    {
        $subject = MasterData::findOrFail($id);

        $registered = StudentSubjectRegistration::where('subject_id', $id)->exists();
        $hasMarks = Mark::where('subject_id', $id)->exists();

        if ($registered || $hasMarks) {
            return response()->json([
                'success' => false,
                'message' => 'This subject already has student registrations or marks recorded against it. Deactivate it instead of deleting, to keep historic records intact.',
            ], 422);
        }

        $subject->delete();

        return response()->json(['success' => true, 'message' => 'Subject deleted.']);
    }

    private function masterCodeFor(string $category): int
    {
        return $category === 'UACE'
            ? config('constants.options.UACEPapers')
            : config('constants.options.UCEPapers');
    }
}