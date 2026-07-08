<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\User; // adjust to your contacts model
use Illuminate\Http\Request;

class HouseController extends Controller
{
    /**
     * Show the create form.
     */
    public function create()
    {
        $nextNumber = $this->generateNextNumber();
        $contacts   = User::orderBy('name')->get(); // adjust model/query as needed

        return view('houses.create', compact('nextNumber', 'contacts'));
    }

    /**
     * Store a new house.
     */
    public function store(Request $request)
    {
        $request->validate([
            'House'         => 'required|string|max:255|unique:houses,House',
            'Location'      => 'required|string|max:100',
            'ContactPerson' => 'nullable|integer',
        ]);

        // Build the auto-incremented number (IT-001, IT-002, …)
        $nextNumber    = $this->generateNextNumber();
        $numberString  = 'IT-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $house = House::create([
            'House'            => strtoupper(trim($request->House)),
            'House_AR'         => null,
            'Number'           => $numberString,
            'Location'         => $request->Location,
            'RegistrationDate' => now(),
            'Head'             => 0,
            'ContactPerson'    => $request->ContactPerson ?? 0,
        ]);

        // Calculate the next number AFTER saving, for the badge refresh
        $newNext = 'IT-' . str_pad($this->generateNextNumber(), 3, '0', STR_PAD_LEFT);

        return response()->json([
            'message'     => "School '{$house->House}' has been added successfully.",
            'house'       => $house,
            'next_number' => $newNext,
        ]);
    }

    /**
     * Get the next sequential number by reading the highest IT-XXX in the DB.
     * Returns an integer (e.g. 6 when the highest is IT-005).
     */
    private function generateNextNumber(): int
    {
        $last = House::where('Number', 'LIKE', 'IT-%')
            ->orderByRaw('CAST(SUBSTRING(Number, 4) AS UNSIGNED) DESC')
            ->value('Number');

        if (!$last) {
            return 1;
        }

        $lastInt = (int) ltrim(substr($last, 3), '0');
        return $lastInt + 1;
    }
}