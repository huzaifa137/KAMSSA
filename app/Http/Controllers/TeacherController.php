<?php
namespace App\Http\Controllers;

use DB;
use Mail;
use App\Models\Role;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Str;
use App\Models\password_reset_table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class TeacherController extends Controller
{
    public function addTeachers()
    {
        $school_id = Session('LoggedSchool');

        return view('Teacher.add-teachers', compact('school_id'));
    }

    public function storeTeacher(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'surname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'othername' => 'nullable|string|max:255',
            'initials' => 'nullable|string|max:255',
            'phonenumber' => 'required|string|max:20',
            'registration_number' => 'nullable|string|max:50',
            'gender' => 'nullable|in:male,female',
            'national_id' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'employee_number' => 'nullable|string|max:50',
            'group_teacher' => 'nullable|integer',
            'email' => 'required',
        ]);

        $userExistsInSchool = DB::table('teachers')
            ->where('email', $request->email)
            ->where('school_id', $request->school_id)
            ->first();

        if ($userExistsInSchool) {
            return response()->json([
                'message' => 'This teacher is already registered under this school.'
            ], 422);
        }

        $userExists = DB::table('users')->where('email', $request->email)->first();

        if ($userExists && !$request->has('confirm_existing')) {
            return response()->json([
                'exists' => true,
                'message' => 'A user with this email already exists in another school. Do you want to continue ?'
            ]);
        }

        $teacher = Teacher::create($validated);

        if (!$userExists) {

            // TEACHER USER ROLE STATUS ===> 5
            // --------------------------------------

            $password = $teacher->password;

            $user = new User;

            $user->username = $teacher->id;
            $user->email = $teacher->email;
            $user->user_role = 5;
            $user->password = $password;
            $user->save();


            $token = Str::random(60);
            $resetUrl = url('password/set-password', $token);

            $post = new password_reset_table();

            $post->email = $teacher->email;
            $post->token = $resetUrl;
            $post->created_at = now();

            $post->save();

            $data = [
                'email' => $teacher->email,
                'username' => $teacher->surname,
                'resetUrl' => $resetUrl,
                'title' => 'Idaad & Thanawi Exam System SET PASSWORD',
            ];

            Mail::send('emails.set_password', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['email'])->subject($data['title']);
            });
        }

        return response()->json(['message' => 'Teacher added successfully']);
    }

    public function allTeachers()
    {
        $teachers = Teacher::orderBy('surname')->get();

        return view('Teacher.teachers-in-school', compact('teachers'));
    }

    public function teacherProfile($id)
    {
        $teacher = Teacher::with('school')->findOrFail($id);
        $school_id = $teacher->school_id;

        return view('Teacher.teacher-profile', compact('teacher', 'school_id'));
    }

    public function updateteacherProfile($id)
    {


        $user = DB::table('users')->where('id', $id)->first();
        // $roles = Role::all();
        $userModel = User::find($id);
        // $userRoles = $userModel ? $userModel->roles->pluck('id')->toArray() : [];

        $teacher = DB::table('users')
            ->where('id', $id)
            ->first();

        return view('Users.update-user-info', compact('teacher'));
    }

    public function storeUpdatedTeacherProfile(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'surname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:20',
            'othername' => 'nullable|string|max:255',
            'initials' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:50',
            'gender' => 'nullable|in:male,female',
            'national_id' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'employee_number' => 'nullable|string|max:50',
            'group_teacher' => 'nullable|integer|between:1,5',
            'teacher_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = Teacher::where('id', $teacher->id)->first();

        if ($request->hasFile('teacher_profile')) {

            if ($profile && $profile->teacher_profile) {
                Storage::disk('public')->delete($profile->teacher_profile);
            }

            $logoFile = $request->file('teacher_profile');
            $logoPath = $logoFile->store('teacherProfiles', 'public');
            $validated['teacher_profile'] = $logoPath;
        } else if ($profile) {
            $validated['teacher_profile'] = $profile->teacher_profile;
        } else {
            $validated['teacher_profile'] = null;
        }

        $teacher->update($validated);

        return response()->json(['message' => 'Teacher updated successfully']);
    }

    public function schoolTeachers()
    {
        $teachers = Teacher::with('school')
            ->where('school_id', Session('LoggedSchool'))
            ->orderBy('surname')
            ->get();

        $school_id = Session('LoggedSchool');

        return view('Teacher.teachers-in-school', compact('teachers', 'school_id'));
    }

    public function individualSchoolTeachers($schoolId)
    {
        $teachers = Teacher::with('school')
            ->where('school_id', $schoolId)
            ->orderBy('id')
            ->get();

        $school_id = $schoolId;

        return view('Teacher.teachers-in-school', compact('teachers', 'school_id'));
    }

    public function destroyTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return response()->json(['message' => 'Teacher deleted successfully.']);
    }

}
