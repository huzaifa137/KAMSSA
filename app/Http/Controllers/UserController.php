<?php

namespace App\Http\Controllers;

use App\Models\password_reset_table;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use App\Models\House;
use App\Models\SchoolPassword;

class UserController extends Controller
{
    public function createNewPassword($id)
    {
        $generated_id = url('password/reset/' . $id);
        $resetEntry = DB::table('password_reset_tables')->where('token', $generated_id)->first();

        if ($resetEntry) {
            if ($resetEntry->link_status == 0) {
                if (now()->diffInMinutes($resetEntry->created_at) <= 30) {
                    return view('users.reset-password-2', compact(['generated_id']));
                } else {
                    return ('users.login')->with('fail', 'This reset password link has expired');
                }
            } else {
                return redirect()->route('users.login')->with('fail', 'This link has already been used, request for a new link');
            }
        } else {
            return redirect()->route('users.login')->with('fail', 'Invalid Link');
        }
    }

    public function createFirstPassword($id)
    {
        $generated_id = url('password/set-password/' . $id);
        $resetEntry = DB::table('password_reset_tables')->where('token', $generated_id)->first();
        $useremail = $resetEntry->email;

        if ($resetEntry) {
            if ($resetEntry->link_status == 0) {
                if (now()->diffInMinutes($resetEntry->created_at) <= 30) {
                    return view('users.set-first-pasword', compact(['generated_id', 'useremail']));
                } else {
                    return ('users.login')->with('fail', 'This reset password link has expired');
                }
            } else {
                return redirect()->route('users.login')->with('fail', 'This link has already been used, request for a new link');
            }
        } else {
            return redirect()->route('users.login')->with('fail', 'Invalid Link');
        }
    }

    public function generateForgotPasswordLink(Request $request)
    {
        $email = $request->email;
        $user_role = DB::table('users')->where('email', $email)->value('user_role');

        if ($user_role == 5) {
            // Teacher user-name
            $username = DB::table('teachers')->where('email', $email)->value('surname');
        } else {
            $username = DB::table('users')->where('email', $email)->value('username');
        }

        $user = User::where('email', $email)->first();

        if ($user == null) {
            return back()->withInput()->with('fail', 'The email provided is not registered in the system');
        } else {

            $token = Str::random(60);
            $resetUrl = url('password/reset', $token);

            $post = new password_reset_table();

            $post->email = $email;
            $post->token = $resetUrl;
            $post->created_at = now();

            $post->save();

            $data = [
                'email' => $email,
                'username' => $username,
                'resetUrl' => $resetUrl,
                'title' => 'Idaad & Thanawi Exam System : Reset Password Link',
            ];

            Mail::send('emails.reset_email', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['email'])->subject($data['title']);
            });

            return back()->with('success', 'Link has been sent to your email : ' . ' ' . $email);
        }
    }

    public function store_new_password(Request $request)
    {
        $request->validate(
            [
                'password' => ['required', 'string', 'min:6', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&#]/'],
            ],
            [
                'password.required' => 'The password field is required.',
                'password.string' => 'The password must be a string.',
                'password.min' => 'The password must be at least 6 characters.',
                'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
            ],
        );

        $password = $request->password;
        $confirm = $request->confirmPassword;
        $generated_id = $request->generated_id;

        if ($password == $confirm) {

            $record = DB::table('password_reset_tables')->where('token', $generated_id)->first();
            $record_id = $record->id;
            $user_email = $record->email;

            $new_password = Hash::make($password);

            DB::table('users')
                ->where('email', $user_email)
                ->update(['password' => $new_password]);

            $post = password_reset_table::find($record_id);
            $post->link_status = 1;
            $post->save();

            $user = DB::table('users')
                ->where('email', $user_email)
                ->first();

            if ($user->registration_status == 0) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['registration_status' => 1]);
            }

            return redirect()->route('users.login')->with('success', 'Password has been updated successfully');
        } else {
            return back()->with('fail', 'Passwords do not match');
        }
    }


    public function store_first_password(Request $request)
    {
        $request->validate(
            [
                'password' => ['required', 'string', 'min:6', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&#]/'],
            ],
            [
                'password.required' => 'The password field is required.',
                'password.string' => 'The password must be a string.',
                'password.min' => 'The password must be at least 6 characters.',
                'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
            ],
        );

        $password = $request->password;
        $confirm = $request->confirmPassword;
        $generated_id = $request->generated_id;

        if ($password == $confirm) {

            $record = DB::table('password_reset_tables')->where('token', $generated_id)->first();
            $record_id = $record->id;
            $user_email = $record->email;

            $new_password = Hash::make($password);

            DB::table('users')
                ->where('email', $user_email)
                ->update(['password' => $new_password]);

            $userId = DB::table('users')
                ->where('email', $user_email)->value('id');

            $post = password_reset_table::find($record_id);
            $post->link_status = 1;
            $post->save();

            DB::table('users')
                ->where('id', $userId)
                ->update(['registration_status' => 1]);

            $request->session()->put('LoggedStudent', $userId);

            return redirect()->route('users.login')->with('success', 'Password has been updated successfully');
        } else {
            return back()->with('fail', 'Passwords do not match');
        }
    }

    public function supplierOtpVerification(Request $request)
    {

        $otp_1 = $request->input('otp_1');
        $otp_2 = $request->input('otp_2');
        $otp_3 = $request->input('otp_3');
        $otp_4 = $request->input('otp_4');
        $otp_5 = $request->input('otp_5');

        $new_otp = $otp_1 . $otp_2 . $otp_3 . $otp_4 . $otp_5;
        $user_id = $request->input('hidden_otp');
        $userPassword = $request->input('userPassword');

        $temp_otp_stored = DB::table('users')->where('email', $user_id)->value('temp_otp');
        $supplier_username = DB::table('users')->where('email', $user_id)->value('username');
        $userId = DB::table('users')->where('email', $user_id)->value('id');
        $userRole = DB::table('users')->where('email', $user_id)->value('user_role');

        if ($new_otp == $temp_otp_stored) {

            if ($userRole != 1) {
                $request->session()->put('LoggedAdmin', $userId);
            } else {
                $request->session()->put('LoggedStudent', $userId);
            }

            DB::table('users')
                ->where('id', $userId)
                ->update(['registration_status' => 1]);

            $user = DB::table('users')->where('id', $userId)->first();

            $data = [
                'email' => $user->email,
                'username' => $user->username,
                'password' => session('userPassword'),
                'title' => 'UgandanProgrammer - User Account has been created successfully.',
            ];

            try {
                Mail::send('emails.user-account-created', $data, function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });
            } catch (Exception $e) {
                DB::table('users')->where('email', $user->email)->delete();
                return back()->with('error', 'Email Not, Check Internet or re-register');
            }

            $url = '/';
            $url2 = session()->get('url.intended');
            $url3 = '/student/dashboard';

            if ($userRole != 1) {
                if ($url2 != null) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login successful',
                        'redirect_url' => $url2,
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Login successful',
                    'redirect_url' => $url,
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Login successful',
                    'redirect_url' => $url3,
                ]);
            }
        } else {

            return response()->json([
                'status' => false,
                'title' => 'Invalid OTP',
                'message' => 'Entered OTP is invalid, please check your email for correct OTP code',
            ]);
        }
    }

    public function reload_captcha()
    {
        return response()->json(['captcha' => captcha_img('flat')]);
    }

    public function userLogout()
    {
        if (session()->has('LoggedAdmin')) {
            session()->flush();
            return redirect('/');
        } else {
            return redirect('/');
        }
    }

    public function adminLogout()
    {
        if (session()->has('LoggedAdmin')) {
            session()->flush();
            return redirect('/');
        } else {
            return redirect('/');
        }
    }

    public function studentLogout()
    {
        session()->flush();
        return redirect('/');
    }

    public function forgotPassword()
    {
        return view('users.forgot-password');
    }

    public function login(Request $request)
    {
        return view('users.login');
    }

    public function courseInformation(Request $request)
    {
        return view('users.login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function checkUser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|string',
                'password' => 'required|string',
                'role' => 'required|in:student,school,admin',
            ],
            [
                'username.required' => match ($request->role) {
                    'student' => 'Registration number is required.',
                    'school' => 'School center number is required.',
                    'admin' => 'Administrator ID is required.',
                    default => 'Username or email is required.',
                },
                'password.required' => 'Password is required.',
                'role.required' => 'Login role is required.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $loginValue = $request->username;
        $role = $request->role;
        $isEmail = filter_var($loginValue, FILTER_VALIDATE_EMAIL);

        // Role-specific validations
        if ($role === 'student' && $isEmail) {
            return response()->json([
                'errors' => [
                    'username' => ['Students must log in using their registration number.']
                ]
            ], 422);
        }

        if ($role === 'school') {
            return $this->authenticateSchool($request);
        }

        // Handle student and admin authentication (existing users table)
        $user = User::where(function ($query) use ($isEmail, $loginValue) {
            $isEmail
                ? $query->where('email', $loginValue)
                : $query->where('username', $loginValue);
        })->first();

        if (!$user) {
            return response()->json([
                'errors' => [
                    'username' => ['Account not found. Please check your credentials.']
                ]
            ], 422);
        }

        if ($user->user_role !== $role) {
            return response()->json([
                'errors' => [
                    'username' => [
                        "This account belongs to a {$user->user_role}. Please use the correct login section."
                    ]
                ]
            ], 422);
        }

        if (!$user->is_active) {
            return response()->json([
                'errors' => [
                    'username' => ['This account is currently disabled.']
                ]
            ], 422);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors' => [
                    'password' => ['Invalid credentials. Please check your login details.']
                ]
            ], 422);
        }

        $user->update([
            'last_login_at' => now(),
        ]);

        $request->session()->regenerate();

        // Set session based on role
        $this->setUserSession($request, $user);

        // Determine redirect URL based on role
        $redirectUrl = match ($user->user_role) {
            'student' => '/student/dashboard',
            'admin' => '/student/dashboard',
            // 'admin' => '/admin/dashboard',
            default => '/student/dashboard',
        };

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'redirect' => $redirectUrl,
        ]);
    }

    /**
     * Authenticate school using school_passwords table
     */
    private function authenticateSchool(Request $request)
    {
        // Find the school by center number (ID)
        $school = House::where('Number', $request->username)
            ->orWhere('House', $request->username)
            ->first();

        if (!$school) {
            return response()->json([
                'errors' => [
                    'username' => ['School not found. Please check your center number.']
                ]
            ], 422);
        }

        // Get the school password record
        $schoolPassword = SchoolPassword::where('school_id', $school->Number)->first();

        if (!$schoolPassword) {
            return response()->json([
                'errors' => [
                    'username' => ['No password has been set up for this school yet. Please contact administrator.']
                ]
            ], 422);
        }

        // Verify password
        if (!Hash::check($request->password, $schoolPassword->password_hashed)) {
            return response()->json([
                'errors' => [
                    'password' => ['Invalid password. Please check your credentials.']
                ]
            ], 422);
        }

        $request->session()->regenerate();

        // Set school session
        $request->session()->put('LoggedUserRole', 'school');
        $request->session()->put('LoggedSchool', $school->ID);
        $request->session()->put('LoggedSchoolCode', $school->Number);
        $request->session()->put('LoggedSchoolName', $school->House);
        $request->session()->put('LoggedSchoolNameAr', $school->House_AR ?? $school->House);

        // Optional: Store last login time
        $schoolPassword->update([
            'last_login_at' => now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'School login successful',
            'redirect' => '/school/dashboard', // You'll need to create this route
        ]);
    }

    /**
     * Set user session based on role
     */
    private function setUserSession(Request $request, $user)
    {
        $request->session()->put('LoggedUserRole', $user->user_role);

        switch ($user->user_role) {
            case 'student':
                $request->session()->put('LoggedStudent', $user->id);
                // $request->session()->put('LoggedStudentName', $user->name);
                break;
            case 'admin':
                $request->session()->put('LoggedStudent', $user->id);
                // $request->session()->put('LoggedAdmin', $user->id);
                // $request->session()->put('LoggedAdminName', $user->name);
                break;
        }
    }

    public function authUserSelectedSchool(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'selected_school_id' => 'required',
        ]);

        $school_id = $request->selected_school_id;
        $user = DB::table('users')->where('email', $request->email)->first();

        $statusMessages = [
            0 => 'Your account has been banned.',
            8 => 'Your account is locked. ',
            9 => 'Your account is suspended. .',
        ];

        if ($user->account_status != 10) {
            $message = $statusMessages[$user->account_status] ?? 'Your account is not active.';

            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        $url1 = '/student/dashboard';

        if ($user->user_role == 5) {

            $request->session()->put('LoggedStudent', $user->id);
            $request->session()->put('LoggedSchool', $school_id);

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'redirect_url' => $url1,
            ]);
        }
    }

    public function regenerateOTP(Request $request)
    {

        $user_id = $request->input('hidden_otp');
        $new_otp = rand(10000, 99999);
        $generatedOTP = $new_otp;

        $user_mail = DB::table('users')->where('email', $user_id)->value('email');
        $username = DB::table('users')->where('email', $user_id)->value('username');

        DB::table('users')
            ->where('email', $user_id)
            ->update(['temp_otp' => $new_otp]);

        $data = [
            'subject' => 'UP RESENT OTP LOGIN',
            'body' => 'Enter the Sent OTP to Login : ',
            'generatedOTP' => $generatedOTP,
            'username' => $username,
            'email' => $user_mail,
        ];

        if ($user_mail) {
            Mail::send('emails.otp', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['email'])->subject($data['subject']);
            });
        }

        return response()->json([
            'status' => true,
            'message' => 'New OTP code has been sent to your email' . ' ' . $user_mail,
        ]);
    }

    public function userProfile()
    {

        $user = DB::table('users')->where('id', session('LoggedAdmin'))->first();

        return view('users.user-profile', compact(['user']));
    }

    public function userRegister()
    {

        $user_supervisors = DB::table("users")
            ->select('firstname', 'lastname')
            ->get();

        return view('users.user-register', compact(['user_supervisors']));
    }

    public function homePage()
    {
        $allCourses = [];

        return view('home-page', compact(['allCourses']));
    }

    public function editUserInformation()
    {

        $info = DB::table('users')->where('id', Session('LoggedAdmin'))->first();

        return view('users.edit-user-information', compact(['info']));
    }

    public function editSpecificUser($userId)
    {

        $info = DB::table('users')->where('id', $userId)->first();

        return view('users.edit-user-information', compact(['info']));
    }

    public function userInformation(Request $request)
    {
        $users = User::all();
        $mc_code = DB::table('master_datas')
            ->join('master_codes', 'md_master_code_id', '=', 'master_codes.id')
            ->get();

        if ($request->ajax()) {
            return datatables()->of($users)
                ->addColumn('username', function ($user) {

                    if ($user->user_role == 5) {
                        return Helper::get_teacher_name($user->username);
                    }
                    return $user->username;
                })
                ->addColumn('user_role', function ($user) {
                    switch ($user->user_role) {
                        case 0:
                            return 'School Admin';
                        case 1:
                            return 'System Administrator';
                        case 5:
                            return 'Teacher';
                        default:
                            return 'Unknown';
                    }
                })
                ->addColumn('action', function ($user) {
                    $links = [];
                    $links[] = '<a class="dropdown-item" href="' . route('users.account-information', $user->id) . '"><i class="fa fa-fw fa-eye"></i> View</a>';
                    $links[] = '<a class="dropdown-item" href="' . route('users.edit-specific-user', $user->id) . '"><i class="fa fa-fw fa-edit"></i> Edit</a>';
                    $links[] = '<a class="dropdown-item delete-user" href="' . route('users.delete-user', $user->id) . '" data-name="' . $user->firstname . ' ' . $user->lastname . '"><i class="fa fa-fw fa-times"></i> Delete</a>';

                    return '<div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton' . $user->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $user->id . '">
                                    ' . implode('', $links) . '
                                </ul>
                            </div>';
                })

                ->make(true);
        }

        return view('users.user-information', [
            'mc_code' => $mc_code,
            'users' => $users,
            'LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first(),
        ]);
    }

    public function userAccountInformation($id)
    {

        $next = DB::table('users')->where('id', '>', $id)->orderBy('id', 'ASC')->value('id');
        $prev = DB::table('users')->where('id', '<', $id)->orderBy('id', 'DESC')->value('id');

        $user_profile_data = DB::table('users')->where('id', $id)->first();

        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        return view('users.user-account-information', $data, compact(['user_profile_data']))
            ->with('next', $next)
            ->with('prev', $prev);
    }

    public function storeUpdatedInformation(Request $request)
    {

        $id = $request->hidden_id;

        $reference = DB::table('users')->where('id', $id)->value('user_reference');

        $request->validate([

            'email' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required',
            'gender' => 'required',
            'user_role' => 'required',
            'phonenumber' => 'required',
            'title' => 'required',
        ]);

        $role_name = $request->user_role;

        $userRoleId = DB::table('user_roles')->where('user_name', $role_name)->value('user_id');

        $email = $request->email;
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $username = $request->username;
        $gender = $request->gender;
        $user_role = $request->user_role;
        $phonenumber = $request->phonenumber;
        $account_status = $request->account_status;
        $title = $request->title;
        $user_title = $request->user_title;

        $user_supervisior = $request->user_supervisor;
        $passport = $request->passport;
        $country = $request->country;
        $password = $request->password;

        $all_emails = DB::table('users')->pluck('email');
        $all_username = DB::table('users')->pluck('username');

        foreach ($all_emails as $specific_email) {

            if ($email == $specific_email) {
                $user_id = DB::table('users')->where('email', $email)->value('id');
                if ($user_id != $id) {
                    return back()->with('fail', 'The provided Email id is already registered to another user');
                }
            }
        }

        foreach ($all_username as $specific_username) {

            if ($username == $specific_username) {

                $user_id = DB::table('users')->where('username', $username)->value('id');

                if ($user_id != $id) {
                    return back()->with('fail', 'The provided username is already registered to another user');
                }
            }
        }

        DB::table('users')->where('id', $id)
            ->update([
                'email' => $email,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'username' => $username,
                'gender' => $gender,
                'user_role' => $user_role,
                'phonenumber' => $phonenumber,
                'account_status' => $account_status,
                'user_id' => $userRoleId,
                'Title' => $title,
                'user_supervisor' => $user_supervisior,
                'user_title' => $user_title,
                'passport_number' => $passport,
                'country' => $country,
            ]);

        $units = $request->requisitionunits;

        $currentTimestamp = time();
        $twoYearsFromNow = strtotime('+2 years', $currentTimestamp);

        return back()->with('success', 'User Information has been updated successfully');
    }

    public function editRecord($md_id)
    {

        $data = ['LoggedUserAdmin' => Admin::where('id', '=', session('LoggedAdmin'))->first()];

        $tb_record = DB::table('master_datas')
            ->where('md_id', $md_id)
            ->get();

        $md_master_code_id = DB::table('master_datas')->where('md_id', $md_id)->pluck('md_master_code_id');
        $md_master_code_id = $md_master_code_id[0];

        $selected = DB::select('select id, mc_name from master_codes');

        if (is_numeric($md_master_code_id)) {

            $master_code_name = DB::table('master_codes')->where('id', $md_master_code_id)->pluck('mc_name');
            $master_code_id = DB::table('master_codes')->where('id', $md_master_code_id)->pluck('mc_id');

            if (isset($master_code_name[0])) {

                $master_code_name = $master_code_name[0];
                $master_code_id = $master_code_id[0];

                return view('master-logic.edit-record', $data, compact(['tb_record', 'selected', 'master_code_name', 'master_code_id', 'md_id']));
            } else {
                $master_code_name = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_name');
                $master_code_id = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_id');

                $master_code_name = $master_code_name[0];
                $master_code_id = $master_code_id[0];

                return view('master-logic.edit-record', $data, compact(['tb_record', 'selected', 'master_code_name', 'master_code_id', 'md_id']));
            }
        } else {
            $master_code_name = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_name');
            $master_code_id = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_id');

            $master_code_name = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_name');
            $master_code_id = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_id');

            $master_code_name = $master_code_name[0];
            $master_code_id = $master_code_id[0];

            return view('master-logic.master-logic.edit-record', $data, compact(['tb_record', 'selected', 'master_code_name', 'master_code_id', 'md_id']));
        }
    }

    public function storeInternalUser(Request $request)
    {

        // ACCOUNT STATUSES
        // --------------------------------------
        // 1.Banned     ====> 0
        // 2.Locked     ====> 8
        // 3.Suspended  ====> 9
        // 4.Active     ====> 10

        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
            ],
        ], [
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
        ]);

        $user = new User;

        $user->username = $request->username;
        $user->phonenumber = $request->phonenumber;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->user_role = 1;
        $user->password = Hash::make($request->password);
        $user->save();

        $data = [
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'title' => 'UgandanProgrammer - User Account has been created successfully.',
        ];

        return back()->with('success', 'User account has been created successfully');
    }

    public function storeUpdatedInternalUser(Request $request)
    {

        // ACCOUNT STATUSES
        // --------------------------------------
        // 1.Banned     ====> 0
        // 2.Locked     ====> 8
        // 3.Suspended  ====> 9
        // 4.Active     ====> 10

        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
        ]);

        if ($request->password != null && $request->confirmPassword != null) {
            $request->validate(
                [
                    'password' => [
                        'required',
                        // 'string',
                        // 'min:6',
                        // 'regex:/[A-Z]/',
                        // 'regex:/[a-z]/',
                        // 'regex:/[0-9]/',
                        // 'regex:/[@$!%*?&#]/',
                    ],
                ],
                [
                    'password.required' => 'The password field is required.',
                    'password.string' => 'The password must be a string.',
                    'password.min' => 'The password must be at least 6 characters.',
                    'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
                ]
            );
        }

        $password = trim($request->password);

        if ($request->password != null) {

            User::updateOrCreate(
                ['id' => $request->user_id],
                [
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($password),
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'gender' => $request->gender,
                    'phonenumber' => $request->phonenumber,
                    'country' => $request->country,
                ]
            );

            return back()->with('success', 'User account has been updated successfully');
        } else {

            User::updateOrCreate(
                ['id' => $request->user_id],
                [
                    'username' => $request->username,
                    'email' => $request->email,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'gender' => $request->gender,
                    'phonenumber' => $request->phonenumber,
                    'country' => $request->country,
                ]
            );

            return back()->with('success', 'User account has been updated successfully');
        }
    }

    public function deleteUserAccount($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'user ' . $user->username . ' has been deleted successfully');
        }
        return redirect()->back()->with('fail', 'User not found.');
    }

    public function publicPortal()
    {
        return view('public-portal');
    }
}
