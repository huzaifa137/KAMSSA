<?php

namespace App\Http\Controllers;

use App\Models\GradingSetting;
use Illuminate\Http\Request;

class GradingSettingsController extends Controller
{
    private $categories = [
        'TH' => 'Thanawi',
        'ID' => 'Idaad',
        'PLE' => 'Primary (PLE)',
        'UCE' => 'UCE (O-Level)',
        'UACE' => 'UACE (A-Level)',
    ];

    public function index()
    {
        $categories = $this->categories;
        $activeCategory = 'TH';

        $marksGrades = GradingSetting::getGrades($activeCategory, 'Marks');
        $pointsGrades = GradingSetting::getGrades($activeCategory, 'Points');

        return view('GradingSettings.index', compact('categories', 'activeCategory', 'marksGrades', 'pointsGrades'));
    }

    public function getByCategory($category)
    {
        if (!array_key_exists($category, $this->categories)) {
            return response()->json(['error' => 'Invalid category'], 422);
        }

        $marksGrades = GradingSetting::getGrades($category, 'Marks');
        $pointsGrades = GradingSetting::getGrades($category, 'Points');

        return response()->json([
            'marks' => $marksGrades,
            'points' => $pointsGrades,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'grade' => 'required|string|max:30',
            'from_mark' => 'required|numeric|min:0|max:100',
            'to_mark' => 'required|numeric|min:0|max:100|gte:from_mark',
            'comment' => 'nullable|string|max:100',
            'weight' => 'required|numeric',
        ]);

        $setting = GradingSetting::findOrFail($id);
        $setting->update($request->only(['grade', 'from_mark', 'to_mark', 'comment', 'weight']));

        return response()->json(['success' => true, 'message' => 'Grade updated successfully.']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:TH,ID,PLE,UCE,UACE',
            'grade' => 'required|string|max:30',
            'from_mark' => 'required|numeric|min:0|max:100',
            'to_mark' => 'required|numeric|min:0|max:100|gte:from_mark',
            'comment' => 'nullable|string|max:100',
            'type' => 'required|in:Marks,Points',
            'weight' => 'required|numeric',
        ]);

        $existing = GradingSetting::where('category', $request->category)
            ->where('grade', $request->grade)
            ->where('type', $request->type)
            ->first();

        if ($existing) {
            return response()->json(['error' => 'A grade with this name already exists for this category and type.'], 422);
        }

        $maxOrder = GradingSetting::where('category', $request->category)
            ->where('type', $request->type)
            ->max('sort_order') ?? 0;

        GradingSetting::create(array_merge(
            $request->only(['category', 'grade', 'from_mark', 'to_mark', 'comment', 'type', 'weight']),
            ['sort_order' => $maxOrder + 1]
        ));

        return response()->json(['success' => true, 'message' => 'Grade created successfully.']);
    }

    public function destroy($id)
    {
        GradingSetting::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Grade deleted successfully.']);
    }

    public function resetDefaults($category)
    {
        if (!array_key_exists($category, $this->categories)) {
            return response()->json(['error' => 'Invalid category'], 422);
        }

        // Delete existing
        GradingSetting::where('category', $category)->delete();

        $now = now();
        $defaults = $this->getDefaults($category);

        foreach ($defaults as $row) {
            GradingSetting::create(array_merge($row, ['category' => $category]));
        }

        return response()->json(['success' => true, 'message' => "Grading for {$this->categories[$category]} reset to defaults."]);
    }

    private function getDefaults($category)
    {
        $marksDefaults = [
            'TH' => [
                ['grade' => 'D1', 'from_mark' => 80, 'to_mark' => 100, 'comment' => 'Distinction 1', 'type' => 'Marks', 'weight' => 1, 'sort_order' => 1],
                ['grade' => 'D2', 'from_mark' => 70, 'to_mark' => 79.99, 'comment' => 'Distinction 2', 'type' => 'Marks', 'weight' => 2, 'sort_order' => 2],
                ['grade' => 'C3', 'from_mark' => 60, 'to_mark' => 69.99, 'comment' => 'Credit 3', 'type' => 'Marks', 'weight' => 3, 'sort_order' => 3],
                ['grade' => 'C4', 'from_mark' => 50, 'to_mark' => 59.99, 'comment' => 'Credit 4', 'type' => 'Marks', 'weight' => 4, 'sort_order' => 4],
                ['grade' => 'P5', 'from_mark' => 40, 'to_mark' => 49.99, 'comment' => 'Pass 5', 'type' => 'Marks', 'weight' => 5, 'sort_order' => 5],
                ['grade' => 'P6', 'from_mark' => 35, 'to_mark' => 39.99, 'comment' => 'Pass 6', 'type' => 'Marks', 'weight' => 6, 'sort_order' => 6],
                ['grade' => 'F7', 'from_mark' => 0, 'to_mark' => 34.99, 'comment' => 'Fail', 'type' => 'Marks', 'weight' => 7, 'sort_order' => 7],
                ['grade' => 'MUMTAZ', 'from_mark' => 80, 'to_mark' => 100, 'comment' => 'مُمتاز', 'type' => 'Points', 'weight' => 1, 'sort_order' => 1],
                ['grade' => 'FIRST CLASS', 'from_mark' => 65, 'to_mark' => 79.99, 'comment' => 'الأول', 'type' => 'Points', 'weight' => 2, 'sort_order' => 2],
                ['grade' => 'SECOND CLASS', 'from_mark' => 50, 'to_mark' => 64.99, 'comment' => 'الثاني', 'type' => 'Points', 'weight' => 3, 'sort_order' => 3],
                ['grade' => 'THIRD CLASS', 'from_mark' => 35, 'to_mark' => 49.99, 'comment' => 'الثالث', 'type' => 'Points', 'weight' => 4, 'sort_order' => 4],
                ['grade' => 'FAIL', 'from_mark' => 0, 'to_mark' => 34.99, 'comment' => 'راسب', 'type' => 'Points', 'weight' => 5, 'sort_order' => 5],
            ],
            'ID' => [
                ['grade' => 'D1', 'from_mark' => 80, 'to_mark' => 100, 'comment' => 'Distinction 1', 'type' => 'Marks', 'weight' => 1, 'sort_order' => 1],
                ['grade' => 'D2', 'from_mark' => 70, 'to_mark' => 79.99, 'comment' => 'Distinction 2', 'type' => 'Marks', 'weight' => 2, 'sort_order' => 2],
                ['grade' => 'C3', 'from_mark' => 60, 'to_mark' => 69.99, 'comment' => 'Credit 3', 'type' => 'Marks', 'weight' => 3, 'sort_order' => 3],
                ['grade' => 'C4', 'from_mark' => 50, 'to_mark' => 59.99, 'comment' => 'Credit 4', 'type' => 'Marks', 'weight' => 4, 'sort_order' => 4],
                ['grade' => 'P5', 'from_mark' => 40, 'to_mark' => 49.99, 'comment' => 'Pass 5', 'type' => 'Marks', 'weight' => 5, 'sort_order' => 5],
                ['grade' => 'P6', 'from_mark' => 35, 'to_mark' => 39.99, 'comment' => 'Pass 6', 'type' => 'Marks', 'weight' => 6, 'sort_order' => 6],
                ['grade' => 'F7', 'from_mark' => 0, 'to_mark' => 34.99, 'comment' => 'Fail', 'type' => 'Marks', 'weight' => 7, 'sort_order' => 7],
                ['grade' => 'MUMTAZ', 'from_mark' => 80, 'to_mark' => 100, 'comment' => 'مُمتاز', 'type' => 'Points', 'weight' => 1, 'sort_order' => 1],
                ['grade' => 'FIRST CLASS', 'from_mark' => 65, 'to_mark' => 79.99, 'comment' => 'الأول', 'type' => 'Points', 'weight' => 2, 'sort_order' => 2],
                ['grade' => 'SECOND CLASS', 'from_mark' => 50, 'to_mark' => 64.99, 'comment' => 'الثاني', 'type' => 'Points', 'weight' => 3, 'sort_order' => 3],
                ['grade' => 'THIRD CLASS', 'from_mark' => 35, 'to_mark' => 49.99, 'comment' => 'الثالث', 'type' => 'Points', 'weight' => 4, 'sort_order' => 4],
                ['grade' => 'FAIL', 'from_mark' => 0, 'to_mark' => 34.99, 'comment' => 'راسب', 'type' => 'Points', 'weight' => 5, 'sort_order' => 5],
            ],
            'PLE' => [
                ['grade' => 'D1', 'from_mark' => 80, 'to_mark' => 100, 'comment' => 'Distinction 1', 'type' => 'Marks', 'weight' => 1, 'sort_order' => 1],
                ['grade' => 'D2', 'from_mark' => 65, 'to_mark' => 79.99, 'comment' => 'Distinction 2', 'type' => 'Marks', 'weight' => 2, 'sort_order' => 2],
                ['grade' => 'C3', 'from_mark' => 55, 'to_mark' => 64.99, 'comment' => 'Credit 3', 'type' => 'Marks', 'weight' => 3, 'sort_order' => 3],
                ['grade' => 'C4', 'from_mark' => 45, 'to_mark' => 54.99, 'comment' => 'Credit 4', 'type' => 'Marks', 'weight' => 4, 'sort_order' => 4],
                ['grade' => 'P5', 'from_mark' => 35, 'to_mark' => 44.99, 'comment' => 'Pass 5', 'type' => 'Marks', 'weight' => 5, 'sort_order' => 5],
                ['grade' => 'P6', 'from_mark' => 25, 'to_mark' => 34.99, 'comment' => 'Pass 6', 'type' => 'Marks', 'weight' => 6, 'sort_order' => 6],
                ['grade' => 'F7', 'from_mark' => 0, 'to_mark' => 24.99, 'comment' => 'Fail', 'type' => 'Marks', 'weight' => 7, 'sort_order' => 7],
                ['grade' => 'FIRST CLASS', 'from_mark' => 80, 'to_mark' => 100, 'comment' => 'First Class', 'type' => 'Points', 'weight' => 1, 'sort_order' => 1],
                ['grade' => 'SECOND CLASS', 'from_mark' => 60, 'to_mark' => 79.99, 'comment' => 'Second Class', 'type' => 'Points', 'weight' => 2, 'sort_order' => 2],
                ['grade' => 'THIRD CLASS', 'from_mark' => 40, 'to_mark' => 59.99, 'comment' => 'Third Class', 'type' => 'Points', 'weight' => 3, 'sort_order' => 3],
                ['grade' => 'PASS', 'from_mark' => 25, 'to_mark' => 39.99, 'comment' => 'Pass', 'type' => 'Points', 'weight' => 4, 'sort_order' => 4],
                ['grade' => 'FAIL', 'from_mark' => 0, 'to_mark' => 24.99, 'comment' => 'Fail', 'type' => 'Points', 'weight' => 5, 'sort_order' => 5],
            ],
            // Uganda Certificate of Education (UNEB O-Level)
            'UCE' => [
                ['grade' => 'D1', 'from_mark' => 90, 'to_mark' => 100, 'comment' => 'Distinction 1', 'type' => 'Marks', 'weight' => 1, 'sort_order' => 1],
                ['grade' => 'D2', 'from_mark' => 80, 'to_mark' => 89.99, 'comment' => 'Distinction 2', 'type' => 'Marks', 'weight' => 2, 'sort_order' => 2],
                ['grade' => 'C3', 'from_mark' => 70, 'to_mark' => 79.99, 'comment' => 'Credit 3', 'type' => 'Marks', 'weight' => 3, 'sort_order' => 3],
                ['grade' => 'C4', 'from_mark' => 60, 'to_mark' => 69.99, 'comment' => 'Credit 4', 'type' => 'Marks', 'weight' => 4, 'sort_order' => 4],
                ['grade' => 'C5', 'from_mark' => 50, 'to_mark' => 59.99, 'comment' => 'Credit 5', 'type' => 'Marks', 'weight' => 5, 'sort_order' => 5],
                ['grade' => 'C6', 'from_mark' => 40, 'to_mark' => 49.99, 'comment' => 'Credit 6', 'type' => 'Marks', 'weight' => 6, 'sort_order' => 6],
                ['grade' => 'P7', 'from_mark' => 30, 'to_mark' => 39.99, 'comment' => 'Pass 7', 'type' => 'Marks', 'weight' => 7, 'sort_order' => 7],
                ['grade' => 'P8', 'from_mark' => 20, 'to_mark' => 29.99, 'comment' => 'Pass 8', 'type' => 'Marks', 'weight' => 8, 'sort_order' => 8],
                ['grade' => 'F9', 'from_mark' => 0, 'to_mark' => 19.99, 'comment' => 'Fail 9', 'type' => 'Marks', 'weight' => 9, 'sort_order' => 9],
                ['grade' => 'DIVISION I', 'from_mark' => 80, 'to_mark' => 100, 'comment' => 'Division One', 'type' => 'Points', 'weight' => 1, 'sort_order' => 1],
                ['grade' => 'DIVISION II', 'from_mark' => 60, 'to_mark' => 79.99, 'comment' => 'Division Two', 'type' => 'Points', 'weight' => 2, 'sort_order' => 2],
                ['grade' => 'DIVISION III', 'from_mark' => 45, 'to_mark' => 59.99, 'comment' => 'Division Three', 'type' => 'Points', 'weight' => 3, 'sort_order' => 3],
                ['grade' => 'DIVISION IV', 'from_mark' => 30, 'to_mark' => 44.99, 'comment' => 'Division Four', 'type' => 'Points', 'weight' => 4, 'sort_order' => 4],
                ['grade' => 'UNGRADED', 'from_mark' => 0, 'to_mark' => 29.99, 'comment' => 'Ungraded (U)', 'type' => 'Points', 'weight' => 5, 'sort_order' => 5],
            ],
            // Uganda Advanced Certificate of Education (UNEB A-Level)
            'UACE' => [
                ['grade' => 'A', 'from_mark' => 80, 'to_mark' => 100, 'comment' => 'Distinction (6 pts)', 'type' => 'Marks', 'weight' => 1, 'sort_order' => 1],
                ['grade' => 'B', 'from_mark' => 70, 'to_mark' => 79.99, 'comment' => 'Very Good (5 pts)', 'type' => 'Marks', 'weight' => 2, 'sort_order' => 2],
                ['grade' => 'C', 'from_mark' => 60, 'to_mark' => 69.99, 'comment' => 'Good (4 pts)', 'type' => 'Marks', 'weight' => 3, 'sort_order' => 3],
                ['grade' => 'D', 'from_mark' => 50, 'to_mark' => 59.99, 'comment' => 'Fairly Good (3 pts)', 'type' => 'Marks', 'weight' => 4, 'sort_order' => 4],
                ['grade' => 'E', 'from_mark' => 40, 'to_mark' => 49.99, 'comment' => 'Satisfactory (2 pts)', 'type' => 'Marks', 'weight' => 5, 'sort_order' => 5],
                ['grade' => 'O', 'from_mark' => 30, 'to_mark' => 39.99, 'comment' => 'Subsidiary Pass (1 pt)', 'type' => 'Marks', 'weight' => 6, 'sort_order' => 6],
                ['grade' => 'F', 'from_mark' => 0, 'to_mark' => 29.99, 'comment' => 'Fail (0 pts)', 'type' => 'Marks', 'weight' => 7, 'sort_order' => 7],
                ['grade' => 'FIRST CLASS', 'from_mark' => 80, 'to_mark' => 100, 'comment' => 'First Class', 'type' => 'Points', 'weight' => 1, 'sort_order' => 1],
                ['grade' => 'SECOND CLASS UPPER', 'from_mark' => 65, 'to_mark' => 79.99, 'comment' => 'Second Class (Upper)', 'type' => 'Points', 'weight' => 2, 'sort_order' => 2],
                ['grade' => 'SECOND CLASS LOWER', 'from_mark' => 50, 'to_mark' => 64.99, 'comment' => 'Second Class (Lower)', 'type' => 'Points', 'weight' => 3, 'sort_order' => 3],
                ['grade' => 'PASS', 'from_mark' => 35, 'to_mark' => 49.99, 'comment' => 'Pass', 'type' => 'Points', 'weight' => 4, 'sort_order' => 4],
                ['grade' => 'FAIL', 'from_mark' => 0, 'to_mark' => 34.99, 'comment' => 'Fail', 'type' => 'Points', 'weight' => 5, 'sort_order' => 5],
            ],
        ];

        return $marksDefaults[$category] ?? [];
    }
}