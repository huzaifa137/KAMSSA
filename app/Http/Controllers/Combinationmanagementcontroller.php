<?php

namespace App\Http\Controllers;

use App\Models\Combination;
use App\Models\MasterData;
use App\Models\StudentCombination;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * CRUD management for UACE combinations (e.g. PCM, HEG) and which
 * principal subjects belong to each. This is the "source of truth" screen
 * that feeds:
 *   - Subject Registration's per-student Combination dropdown (UACE)
 *   - The UACE Excel template/import
 *   - Reports (passlip / analysed report "Combination" field)
 *
 * Combinations only apply to categories that use them — currently UACE.
 */
class CombinationManagementController extends Controller
{
    private $categories = [
        'UACE' => 'UACE (A-LEVEL)',
    ];

    public function index()
    {
        $categories = $this->categories;
        $combinations = [];

        foreach ($categories as $code => $label) {
            $rows = Combination::with('subjects')
                ->where('category', $code)
                ->orderBy('code')
                ->get();

            $studentCounts = StudentCombination::whereIn('combination_id', $rows->pluck('id'))
                ->selectRaw('combination_id, count(*) as total')
                ->groupBy('combination_id')
                ->pluck('total', 'combination_id');

            $combinations[$code] = $rows->map(function ($row) use ($studentCounts) {
                $row->student_count = $studentCounts[$row->id] ?? 0;
                return $row;
            });
        }

        // Subjects available to attach, per category (all Optional subjects —
        // compulsory ones like General Paper are auto-registered separately
        // and never belong to a combination).
        $availableSubjects = [];
        foreach ($categories as $code => $label) {
            $availableSubjects[$code] = MasterData::where('md_master_code_id', $this->masterCodeFor($code))
                ->where('md_misc1', 'Optional')
                ->where(function ($q) {
                    $q->whereNull('md_misc2')->orWhere('md_misc2', '!=', 'Inactive');
                })
                ->orderBy('md_name')
                ->get();
        }

        return view('itemGrading.combination-management.index', compact('categories', 'combinations', 'availableSubjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => ['required', Rule::in(array_keys($this->categories))],
            'code' => ['required', 'string', 'max:10', 'alpha_num'],
            'name' => ['required', 'string', 'max:150'],
            'subject_ids' => ['required', 'array', 'min:1'],
            'subject_ids.*' => ['integer', 'exists:master_datas,md_id'],
        ]);

        $code = strtoupper($validated['code']);

        $exists = Combination::where('category', $validated['category'])
            ->where('code', $code)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['code' => "Combination code '{$code}' already exists under {$this->categories[$validated['category']]}."])
                ->withInput();
        }

        $combination = Combination::create([
            'category' => $validated['category'],
            'code' => $code,
            'name' => $validated['name'],
            'status' => 'Active',
        ]);

        $combination->subjects()->sync($validated['subject_ids']);

        return back()->with('success', "Combination '{$code}' created.");
    }

    public function update(Request $request, $id)
    {
        $combination = Combination::findOrFail($id);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:10', 'alpha_num'],
            'name' => ['required', 'string', 'max:150'],
            'subject_ids' => ['required', 'array', 'min:1'],
            'subject_ids.*' => ['integer', 'exists:master_datas,md_id'],
        ]);

        $code = strtoupper($validated['code']);

        $duplicate = Combination::where('category', $combination->category)
            ->where('code', $code)
            ->where('id', '!=', $combination->id)
            ->exists();

        if ($duplicate) {
            return back()->withErrors(['code' => "Combination code '{$code}' is already used by another combination."])->withInput();
        }

        $combination->update([
            'code' => $code,
            'name' => $validated['name'],
        ]);

        $combination->subjects()->sync($validated['subject_ids']);

        return back()->with('success', "Combination '{$code}' updated.");
    }

    /**
     * Flip a combination between Active / Inactive. Inactive combinations
     * disappear from the Subject Registration dropdown, the Excel
     * template's validation list, and the import's accepted-codes list —
     * but students already assigned to it, and their subject
     * registrations, are left untouched.
     */
    public function toggleStatus($id)
    {
        $combination = Combination::findOrFail($id);

        $combination->status = $combination->status === 'Inactive' ? 'Active' : 'Inactive';
        $combination->save();

        return response()->json([
            'success' => true,
            'status' => $combination->status,
            'message' => "Combination marked {$combination->status}.",
        ]);
    }

    /**
     * Hard-delete a combination — only allowed when no student has ever
     * been assigned to it. Otherwise, deactivate instead so historic
     * passlips/reports still resolve the combination name correctly.
     */
    public function destroy($id)
    {
        $combination = Combination::findOrFail($id);

        $inUse = StudentCombination::where('combination_id', $id)->exists();

        if ($inUse) {
            return response()->json([
                'success' => false,
                'message' => 'This combination already has students assigned to it. Deactivate it instead of deleting, to keep historic records intact.',
            ], 422);
        }

        $combination->subjects()->detach();
        $combination->delete();

        return response()->json(['success' => true, 'message' => 'Combination deleted.']);
    }

    private function masterCodeFor(string $category): int
    {
        return $category === 'UACE'
            ? config('constants.options.UACEPapers')
            : config('constants.options.UCEPapers');
    }
}