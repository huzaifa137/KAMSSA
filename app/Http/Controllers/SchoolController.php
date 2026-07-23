<?php
namespace App\Http\Controllers;

use DB;
use App\Models\AcademicYear;
use App\Models\DynamicFormValue;
use App\Models\MasterData;
use App\Models\TermDate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\House;
use App\Models\SchoolPassword;
use Illuminate\Support\Facades\Storage;
use Session;

class SchoolController extends Controller
{

    public function adminUser(Request $request)
    {
        session()->flush();
        $request->session()->put('LoggedAdmin', 1);

        $request->session()->put('LoggedSchool', 457);

        return view('dashboard');
    }

    public function studentUser(Request $request)
    {
        session()->flush();
        $request->session()->put('LoggedStudent', 1);
        $request->session()->put('LoggedAdmin', 1);
        $request->session()->put('LoggedSchool', 2);

        return view('student.dashboard');
    }

    public function createSchool()
    {
        $year = date('Y');

        $lastSchool = House::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastSchool) {
            $lastNumber = (int) substr($lastSchool->registration_code, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $formattedNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        $registrationCode = "SCH-{$year}-{$formattedNumber}";

        return view('School.create-school', compact('registrationCode'));
    }


    public function allSchools()
    {

        $schools = House::orderBy('id', 'Desc')->paginate(30);

        return view('School.all-schools', compact('schools'));
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,8,9,10,1'
        ]);

        $school = House::findOrFail($id);
        $school->school_status = $request->status;
        $school->save();

        if (\Illuminate\Support\Facades\Schema::hasTable('teachers')) {
            $teacherIds = DB::table('teachers')
                ->where('school_id', $id)
                ->pluck('id');

            foreach ($teacherIds as $teacherId) {

                $username = (string) $teacherId;

                $user = DB::table('users')->where('username', $username)->first();

                if ($user) {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['account_status' => $request->status]);
                }
            }
        }

        return response()->json([
            'message' => 'School and teacher statuses updated successfully.'
        ]);
    }



    public function termDates($school_Id)
    {
        $school_id = $school_Id;
        $academicYears = AcademicYear::orderBy('id', 'desc')->where('is_active', 1)->get();
        $termDates = TermDate::where('school_id', $school_id)->orderBy('term', 'asc')->get();

        return view('School.term-dates', compact('school_id', 'academicYears', 'termDates'));
    }

    public function createNewSchool(Request $request)
    {
        $validated = $request->validate([
            'school_type' => 'required|string|max:255',
            'email' => 'required|email',
            'gender' => 'required|string|max:50',
            'regional_level' => 'required|string|max:100',
            'school_ownership' => 'required|string|max:100',
            'boarding_status' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'school_product' => 'required',
            'phone' => 'required|string|max:20',
            'population' => 'required|string',
        ]);

        $registrationCode = $this->generateSchoolCode();

        $validated['Number'] = $registrationCode;
        $validated['House'] = $validated['name'];
        unset($validated['name']);
        $validated['added_by'] = Session('LoggedStudent');
        $validated['date_added'] = now();

        House::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'School created successfully.',
            'registration_code' => $registrationCode
        ]);
    }

    private function generateSchoolCode()
    {
        $year = date('Y');

        $lastSchool = House::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastSchool) {
            $lastNumber = (int) substr($lastSchool->registration_code, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $formattedNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        return "SCH-{$year}-{$formattedNumber}";
    }

    public function editSchool($id)
    {
        $school = House::findOrFail($id);
        $school_id = $id;

        return view('School.edit-school', compact(['school', 'school_id']));
    }

    public function update(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:houses,ID',
            'House' => 'required|string|max:255',
            'Location' => 'required|string|max:100',
            'Category' => 'required|string|in:Answer Sheets,No Answer Sheets',
            'AdministratorNames' => 'required|string|max:255',
            'AdministratorTelephones' => 'required|string|max:20',
            'Title' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'school_type' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'regional_level' => 'nullable|string|max:255',
            'school_ownership' => 'nullable|string|max:255',
            'boarding_status' => 'nullable|string|max:255',
            'school_product' => 'nullable|string|max:255',
            'population' => 'nullable|string|max:255',
            'motto' => 'nullable|string|max:255',
            'vision' => 'nullable|string|max:255',
        ]);

        $school = House::findOrFail($request->school_id);

        $school->update([
            'House' => strtoupper(trim($request->House)),
            'Location' => $request->Location,
            'district' => $request->Location,
            'category' => $request->Category,
            'administrator_names' => $request->AdministratorNames,
            'administrator_telephones' => $request->AdministratorTelephones,
            'title' => $request->Title,
            'email' => $request->email,
            'phone' => $request->phone,
            'school_type' => $request->school_type,
            'gender' => $request->gender,
            'regional_level' => $request->regional_level,
            'school_ownership' => $request->school_ownership,
            'boarding_status' => $request->boarding_status,
            'school_product' => $request->school_product,
            'population' => $request->population,
            'motto' => $request->motto,
            'vision' => $request->vision,
        ]);

        // Update school password entry if it exists
        $schoolPassword = SchoolPassword::where('school_id', $school->Number)->first();
        if ($schoolPassword) {
            $schoolPassword->update([
                'phonenumber' => $request->AdministratorTelephones,
                'updated_at' => now(),
            ]);
        } else {
            // Create if it doesn't exist (fallback)
            SchoolPassword::create([
                'school_id' => $school->Number,
                'phonenumber' => $request->AdministratorTelephones,
                'password_plain' => '123456789',
                'password_hashed' => Hash::make('123456789'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'message' => "School '{$school->House}' has been updated successfully.",
            'school' => $school,
        ]);
    }

    public function deleteSchool($schoolId)
    {
        try {
            $school = House::findOrFail($schoolId);
            $school->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Delete failed'], 500);
        }
    }

    public function schoolIndividualProfile($id)
    {
        $school = House::findOrFail($id);
        $profile = null;
        return view('School.school-profile', compact('school', 'profile'));
    }

    public function schoolProfile()
    {
        if (Session::has('LoggedSchool') && Session::get('LoggedSchool') !== null) {

            $school = House::findOrFail(Session('LoggedSchool'));
            $profile = null;
            return view('School.school-profile', compact('school', 'profile'));

        } else {
            return redirect()->route('student.dashboard')->with('error', 'No School has been selected');
        }
    }

    public function schoolOptions($id)
    {
        $school = House::findOrFail($id);
        $profile = null;

        $genderMasterDataCollection = MasterData::where('md_master_code_id', config('constants.options.SCHOOL_OPTIONALS'))->get();

        $allDynamicFields = collect();
        $masterDataDetails = collect();

        if ($genderMasterDataCollection->isNotEmpty()) {
            foreach ($genderMasterDataCollection as $masterData) {
                $masterDataId = $masterData->md_id;

                $dynamicFieldsForThisMasterData = DynamicFormValue::where('master_data_id', $masterDataId)->get();

                $allDynamicFields = $allDynamicFields->merge($dynamicFieldsForThisMasterData);

                $masterDataDetails->push([
                    'name' => $masterData->md_name,
                    'description' => $masterData->md_description ?? 'N/A',
                ]);
            }
        }

        return view('School.school-options', compact(
            'school',
            'profile',
            'masterDataDetails',
            'allDynamicFields'
        ));
    }

    public function storeSchoolProfile(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|integer|exists:houses,ID',
            'school_type' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'required|string|max:50',
            'boarding_status' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'registration_code' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'population' => 'required|string',
            'motto' => 'nullable|string|max:255',
            'vision' => 'nullable|string|max:255',
            'admission_prefix' => 'nullable|string|max:50',
            'admission_start' => 'nullable|string|max:50',
            'admission_suffix' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $school = House::findOrFail($validated['school_id']);

        if ($request->hasFile('logo')) {
            if ($school->logo) {
                Storage::disk('public')->delete($school->logo);
            }

            $logoFile = $request->file('logo');
            $validated['logo'] = $logoFile->store('logos', 'public');
        } else {
            unset($validated['logo']);
        }

        // 'name'/'registration_code' map to House/Number — Number (the
        // school code) is left untouched here, same as updateSchool().
        $validated['House'] = $validated['name'];
        unset($validated['name'], $validated['registration_code'], $validated['school_id']);

        $school->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'School profile updated successfully.',
        ]);
    }

    public function configureSchoolOptions(Request $request)
    {
        dd($request->all());
    }

    public function addAcademicYear()
    {

        $academicYears = AcademicYear::orderBy('id', 'desc')->get();

        return view('AcademicYear.add-year', compact(['academicYears']));
    }

    public function storeYear(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:academic_years,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ]);

        $academicYear = AcademicYear::create($validated);

        return response()->json([
            'message' => 'Academic Year created successfully.',
            'data' => $academicYear,
        ], 201);
    }

    public function activate($id)
    {
        AcademicYear::query()->update(['is_active' => false]); // Deactivate all
        $year = AcademicYear::findOrFail($id);
        $year->update(['is_active' => true]);

        return response()->json(['message' => 'Academic year activated.']);
    }

    public function deactivate($id)
    {
        $year = AcademicYear::findOrFail($id);
        $year->update(['is_active' => false]);

        return response()->json(['message' => 'Academic year deactivated.']);
    }

    public function destroy($id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        if ($academicYear->is_active) {
            return response()->json(['error' => 'Cannot delete an active academic year.'], 403);
        }

        $academicYear->delete();

        return response()->json(['message' => 'Academic year deleted successfully.']);
    }

    public function updateYear(Request $request, $id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:academic_years,name,' . $id,
            'is_active' => 'required|boolean',
        ]);

        if ($request->is_active == 1) {
            AcademicYear::query()->update(['is_active' => false]);
            $year = AcademicYear::findOrFail($id);
            $year->update(['is_active' => true]);
        }

        $academicYear->update($validated);

        return response()->json([
            'message' => 'Academic Year updated successfully.',
            'data' => $academicYear,
        ]);
    }

    public function storeTermDate(Request $request)
    {

        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'term' => 'required|string|max:255',
            'start_date' => 'required|date',
            'school_id' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'week_starts_on' => 'required|in:1,2',
        ]);

        $exists = TermDate::where('school_id', $validated['school_id'])
            ->where('term', $validated['term'])
            ->where('academic_year_id', $validated['academic_year_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'This term already exists for the selected school.',
            ], 409);
        }

        $termDate = TermDate::create($validated);

        return response()->json([
            'message' => 'Term date added successfully.',
            'data' => $termDate,
        ], 201);
    }

    public function destroyTerm($id)
    {
        $academicTerm = TermDate::findOrFail($id);
        $academicTerm->delete();

        return response()->json(['message' => 'Term deleted successfully.']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'school_id' => 'required|string',
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:4',
        ]);

        $schoolNumber = DB::table('houses')->where('ID', $request->school_id)->value('number');

        $schoolPasswordRecord = DB::table('school_passwords')->where('school_id', $schoolNumber)->first();

        if (!$schoolPasswordRecord) {
            return response()->json([
                'success' => false,
                'message' => 'School password record not found.'
            ], 404);
        }

        if ($schoolPasswordRecord->password_plain !== $request->current_password) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.'
            ], 400);
        }

        DB::table('school_passwords')
            ->where('school_id', $schoolNumber)
            ->update([
                'password_plain' => $request->new_password,
                'password_hashed' => Hash::make($request->new_password),
                'updated_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.'
        ]);
    }
}