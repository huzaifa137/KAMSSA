<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\SchoolPassword;
use App\Models\User; // adjust to your contacts model
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    /**
     * Show the create form.
     */
    public function create()
    {
        $nextNumber = $this->generateNextNumber();
        $contacts = User::orderBy('name')->get(); // adjust model/query as needed

        return view('houses.create', compact('nextNumber', 'contacts'));
    }

    /**
     * Store a new house.
     */
    public function store(Request $request)
    {
        $request->validate([
            'House' => 'required|string|max:255',
            'Location' => 'required|string|max:100',
            'Category' => 'required|string|in:Answer Sheets,No Answer Sheets',
            'AdministratorNames' => 'required|string|max:255',
            'AdministratorTelephones' => 'required|string|max:20',
            'Title' => 'required|string|max:255',
        ]);

        // Build the auto-incremented number (IT-001, IT-002, …)
        $nextNumber = $this->generateNextNumber();
        $numberString = 'IT-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Default password
        $defaultPassword = '123456789';
        $hashedPassword = Hash::make($defaultPassword);

        $house = House::create([
            'House' => strtoupper(trim($request->House)),
            'Number' => $numberString,
            'Location' => $request->Location,
            'district' => $request->Location, // Store in both columns for backward compatibility
            'RegistrationDate' => now(),
            'Head' => 0,
            'ContactPerson' => 0,
            'administrator_names' => $request->AdministratorNames,
            'administrator_telephones' => $request->AdministratorTelephones,
            'title' => $request->Title,
            'category' => $request->Category,
            'school_status' => 1, // Default status
        ]);

        // Create school password entry
        SchoolPassword::create([
            'school_id' => $numberString,
            'phonenumber' => $request->AdministratorTelephones,
            'password_plain' => $defaultPassword,
            'password_hashed' => $hashedPassword,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Calculate the next number AFTER saving, for the badge refresh
        $newNext = 'IT-' . str_pad($this->generateNextNumber(), 3, '0', STR_PAD_LEFT);

        return response()->json([
            'message' => "School '{$house->House}' has been added successfully.",
            'house' => $house,
            'next_number' => $newNext,
            'password' => $defaultPassword, // Optional: Include in response if needed
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