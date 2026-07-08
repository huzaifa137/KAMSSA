<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicYear;
use Illuminate\Validation\Rule;

class AcademicYearController extends Controller
{
    public function index()
    {
        $years = AcademicYear::latest('id')->get();
        return view('academic-years.index', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year_en' => 'required|unique:academic_years',
            'year_ar' => 'required|unique:academic_years',
        ]);

        AcademicYear::create([
            'year_en' => $request->year_en,
            'year_ar' => $request->year_ar,
            'status' => $request->status
        ]);

        return back()->with('success', 'Academic year added successfully');
    }

    public function edit($id)
    {
        $year = AcademicYear::findOrFail($id);

        return response()->json($year);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'year_en' => [
                'required',
                Rule::unique('academic_years', 'year_en')->ignore($id),
            ],
            'year_ar' => [
                'required',
                Rule::unique('academic_years', 'year_ar')->ignore($id),
            ],
        ]);

        $year = AcademicYear::findOrFail($id);

        $year->update([
            'year_en' => $request->year_en,
            'year_ar' => $request->year_ar,
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Academic year updated successfully'
        ]);
    }

    public function destroy($id)
    {
        AcademicYear::findOrFail($id)->delete();

        return back()->with('success', 'Academic year deleted successfully');
    }
}