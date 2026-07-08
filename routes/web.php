<?php

use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserRightsAndPreviledges;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ItebController;
use App\Http\Controllers\SubjectRegistrationController;
use App\Http\Controllers\StudentBulkImportController;
use App\Http\Controllers\SchoolsController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\PasslipAndCertificatesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradingSettingsController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\SchoolRecognitionCertificateController;
use App\Http\Controllers\SystemConfigurationController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\SubjectManagementController;
use App\Models\House;
use App\Models\SchoolPassword;
use Illuminate\Support\Facades\Hash;



Route::get('/generate-school-passwords', function () {

    function generateSecurePassword($length = 5)
    {
        $numbers = '0123456789';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        }

        return $password;
    }

    $schools = House::all();
    $createdPasswords = [];

    foreach ($schools as $school) {

        $plainPassword = generateSecurePassword();

        $schoolPassword = SchoolPassword::updateOrCreate(
            ['school_id' => $school->Number], // using Number like your logic
            [
                'password_plain' => $plainPassword,
                'password_hashed' => Hash::make($plainPassword),
            ]
        );

        $createdPasswords[] = [
            'school_id' => $school->Number,
            'password_plain' => $plainPassword
        ];
    }

    dd('Passwords generated for all schools successfully');


});

Route::get('/logout', function () {
    if (session()->has('LoggedAdmin')) {
        session()->flush();
    }

    return redirect('/');
})->name('logout');

Route::get('/coming-soon', function () {
    return view('coming-soon');
})->name('coming.soon');

Route::controller(UserController::class)->group(function () {
    Route::group(['prefix' => '/users'], function () {
        Route::get('/user-logout', 'userLogout')->name('user-logout');
        Route::post('/admin-logout', 'adminLogout')->name('admin-logout');

        Route::get('/student-logout', 'studentLogout')->name('student-logout');

        Route::group(['middleware' => ['AdminAuth']], function () {
            Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
            Route::get('/login', 'login')->name('users.login');
            Route::get('/', 'login')->name('admin.dashboard');
            Route::post('auth-user-check', 'checkUser')->name('auth-user-check');
            Route::get('/users-profile', 'userProfile')->name('users-profile');
            Route::get('/users-register', 'userRegister');
            Route::get('/users-information', 'userInformation')->name('users.user-information');
            Route::get('user-account-information/{id}', [UserController::class, 'userAccountInformation'])->name('users.account-information');
            Route::get('/home-page', 'homePage')->name('home.page');
            Route::get('/public-portal', 'publicPortal')->name('public.portal');
            Route::get('/register', 'register')->name('users.register');
            Route::get('/edit-user-information', 'editUserInformation');
            Route::get('/edit-specific-user/{userid}', 'editSpecificUser')->name('users.edit-specific-user');
            Route::get('/terms-and-conditions', 'user_terms_and_conditions')->name('users.terms-and-conditions');
            Route::get('/users/delete-user/{id}', 'deleteUserAccount')->name('users.delete-user');
        });

        Route::post('auth-user-selected-school', 'authUserSelectedSchool')->name('auth-user-selected-school');
        Route::post('store-internal-user', 'storeInternalUser')->name('store-internal-user');
        Route::post('update-internal-user', 'storeUpdatedInternalUser')->name('update.internal-user');
        Route::post('save-role', 'saveUserRole')->name('save-role');
        Route::post('store-role-update', 'storeRoleUpdate')->name('store-role-update');
        Route::post('store-updated-information', 'storeUpdatedInformation')->name('store-updated-information');
    });

    Route::group(['middleware' => ['AdminAuth']], function () {
        Route::get('/', 'dashboard')->name('dashboard');
    });

    Route::get('password/reset/{id}', 'createNewPassword')->name('password/reset');
    Route::get('password/set-password/{id}', 'createFirstPassword')->name('password.FirstPassword');
    Route::post('auth.save', 'save')->name('auth.save');
    Route::post('regenerate-otp', 'regenerateOTP')->name('regenerate-otp');
    Route::post('user-generate-forgot-password-link', 'generateForgotPasswordLink')->name('user-generate-forgot-password-link');
    Route::post('user-store-new-password', 'store_new_password')->name('user-store-new-password');
    Route::post('user-store-first-password', 'store_first_password')->name('user-store-first-password');
    Route::post('supplier-user-otp-verification', 'supplierOtpVerification')->name('supplier-user-otp-verification');
    Route::get('reload-captcha', 'reload_captcha')->name('reload-captcha');
});

Route::controller(MasterDataController::class)->group(function () {
    Route::group(['prefix' => 'master-data'], function () {
        Route::get('master-code-to-data', 'masterCodeToData')->name('master-code-to-data');

        Route::get('/load-data', 'loadData')->name('load.data');
        Route::get('master-table', 'master_table')->name('master-table');
        Route::get('master-code', 'master_code')->name('master-code');
        Route::get('requisition-documents', 'requisitionDocuments');
        Route::get('travel-requisition-documents', 'travelRequisitionDocuments');
        Route::get('supplier-prequalification-criteria', 'supplierPrequalificationEvaluationCriteria');
        Route::post('store-prequalification-criteria', 'storePrequalificationCriteria')->name('store-prequalification-criteria');

        Route::get('edit-record/{id}', 'editRecord');
        Route::get('add-record', 'addRecord')->name('add-record');
        Route::get('add-code', 'addMasterCode')->name('add-code');
        Route::get('edit-code/{id}', 'editMasterCode');
        Route::get('master-code-list/{id}', 'masterCodeList')->name('master-code-list');
        Route::get('master-code-list', 'masterCodeList');
        Route::get('edit-supplier-document/{id}', 'editSupplierDocument');
        Route::post('/store-requisition-document', 'storeRequisitionDocument')->name('master-data/store-requisition-document');
    });

    Route::post('store-travel-requisition-document', 'storeTravelRequisitionDocument')->name('store-travel-requisition-document');
    Route::post('update-supplier-document', 'updateSupplierDocument')->name('update-supplier-document');
    Route::post('update-master-record', 'updateMasterrecord')->name('update-master-record');
    Route::post('update-master-code', 'updateMasterCode')->name('update-master-code');
    Route::post('send-master-code', 'sendMasterCode')->name('send-master-code');
    Route::post('add-new-record', 'addNewRecord')->name('add-new-record');

    Route::get('delete-supplier-document/{id}', 'deleteSupplierDocument');
    Route::get('delete-record/{id}', 'deleteRecord');
    Route::get('delete-code/{id}', 'deleteCode');
});

Route::controller(StudentController::class)->group(function () {
    Route::group(['prefix' => '/users'], function () {
        Route::group(['middleware' => ['AdminAuth']], function () {
            Route::get('/register', 'register')->name('users.register');
            Route::get('/terms-and-conditions', 'user_terms_and_conditions')->name('users.terms-and-conditions');
            Route::get('/user-otp', function () {
                $userId = session('userId');
                $userEmail = session('userEmail');
                $userPassword = session('userPassword');

                if (!$userId || !$userEmail) {
                    return redirect()->route('users.login')->with('fail', 'You must be logged in');
                }

                return view('users.otp', compact(['userId', 'userEmail', 'userPassword']));
            });
        });

        Route::post('user-account-creation', 'userAccountCreation')->name('user-account-creation');
        Route::post('contact-message-information', 'contactMessageInformation')->name('contact-message-information');
    });
    Route::get('/clear-session', 'flushSession');
});

Route::controller(StudentController::class)->group(function () {
    Route::group(['middleware' => ['StudentAuth']], function () {
        Route::group(['prefix' => '/student'], function () {
            Route::get('/dashboard', 'studentDashboard')->name('student.dashboard');
            Route::get('/profile', 'studentProfile')->name('student.profile');
            Route::get('/edit-student-profile', 'editStudentProfile');
        });
    });

    Route::get('/select-current-school', 'selectCurrentSchool')->name('select.current.school');
});

Route::controller(SchoolController::class)->group(function () {
    Route::get('create-school', 'createSchool')->name('school.create-school');
    Route::get('term-dates/{schoolId}', 'termDates')->name('school.term-dates');
    Route::get('all-schools', 'allSchools')->name('school.allSchools');
    Route::get('/edit-school/{id}/', 'editSchool')->name('edit.school');
    Route::get('/school-profile', 'schoolProfile')->name('profile.school');
    Route::get('/school-individual-profile/{id}', 'schoolIndividualProfile')->name('profile.individual.school');
    Route::get('/school-options/{id}/', 'schoolOptions')->name('school.options');

    Route::delete('/school/{schoolId}', 'deleteSchool')->name('school.delete');

    Route::post('/create/new/schools/', 'createNewSchool')->name('create.new-school');
    Route::post('/update-school', 'updateSchool')->name('update.school');
    Route::post('/store-school-profile', 'storeSchoolProfile')->name('schools.store.profile');
    Route::post('/school/configure', 'configureSchoolOptions')->name('school.configure');
    Route::post('/schools/{id}/change-status', 'changeStatus');

    Route::get('admin-user', 'adminUser')->name('admin.user');
    Route::get('student-user', 'studentUser')->name('student.user');

    Route::get('/add-academic-year', 'addAcademicYear')->name('add-academic-year');
    Route::post('/academic-years', 'storeYear')->name('academic-years.store');

    Route::patch('/academic-years/{id}/activate', 'activate')->name('academic-years.activate');
    Route::patch('/academic-years/{id}/deactivate', 'deactivate')->name('academic-years.deactivate');

    Route::delete('/academic-years/{id}', 'destroy')->name('academic-years.destroy');
    Route::put('/academic-years/{id}', 'updateYear')->name('academic-years.update');

    Route::delete('/academic-years/{id}', 'destroyTerm')->name('academic-years.destroy');
    Route::post('/store-term-dates', 'storeTermDate')->name('term-dates.store');
});

Route::controller(TeacherController::class)->group(function () {
    Route::get('add-teachers', 'addTeachers')->name('school.add-teachers');
    Route::get('/teachers', 'allTeachers')->name('teachers.all');
    Route::get('/school-teachers', 'schoolTeachers')->name('school.teachers');
    Route::get('/individual-school-teachers/{id}', 'individualSchoolTeachers')->name('individual.school.teachers');
    Route::get('/teacher-profile/{id}', 'teacherProfile')->name('teacher.profile');
    Route::get('/update-teacher-profile/{id}', 'updateteacherProfile')->name('update.teacher.profile');

    Route::post('/store-teachers', 'storeTeacher')->name('teachers.store');
    Route::post('/teachers/update/{teacher}', 'storeUpdatedTeacherProfile')->name('teachers.update');

    Route::delete('/teachers/{id}', 'destroyTeacher')->name('teachers.destroy');
});

Route::controller(UserRightsAndPreviledges::class)->group(function () {
    Route::group(['middleware' => ['StudentAuth']], function () {
        Route::group(['prefix' => '/user-rights-and-previledges'], function () {
            Route::get('/setup', 'setup')->name('all.roles.setup');
            Route::get('/all-roles', 'allRoles')->name('all.users.roles');
            Route::get('/all-permissions', 'allPermissions')->name('all.users.permissions');
            Route::get('/assign-permissions', 'assignPermissions')->name('assign.users.permissions');

            Route::get('add-users', 'addUsers')->name('add-users');
        });

        // routes/web.php

        Route::post('/roles/add-user', 'addUserToRole')->name('roles.add-user');
        Route::post('/roles/remove-user', 'deleteUserFromRole')->name('roles.removeUser');

        Route::get('/users/{id}/details', 'getUserDetails');
        Route::get('/roles/{id}', 'editRole');
        Route::put('/roles/{id}', 'updateRole');

        Route::post('/store-role', 'storeRole')->name('store.role');
        Route::post('/store-permission-role', 'storePermissionRole')->name('store.permission.role');
        Route::post('/permissions/store-multiple', 'storeMultiplePermissions')->name('store.multiple.permissions');

        Route::delete('/roles/{id}', 'deleteRole');
        Route::delete('/permissions/delete', 'destroyGroup')->name('permissions.delete');
        Route::delete('/user/{userId}', 'deleteUser')->name('user.delete');

        Route::post('/assign-permissions/{roleId}', 'storeRolePermissions')->name('storeRolePermissions');
        Route::post('/remove-permissions/{roleId}/remove', 'removePermission');
        Route::post('/assign-user-to-role', 'assignUserToRole')->name('assignUserToRole');
        Route::post('/remove-user-from-role', 'removeUserFromRole')->name('removeUserFromRole');

        Route::post('/store-new-user', 'storeNewUser')->name('users.store.new.user');
        Route::post('/update-user-information', 'updateUserInformation')->name('users.update.information');
        Route::post('/users/{id}/change-status', 'changeStatus');
    });

    Route::controller(StudentController::class)
        ->prefix('students')
        ->group(function () {
            Route::group(['middleware' => ['StudentAuth']], function () {
                Route::get('students-dashboard', 'studentPortal')->name('all.students.dashboard');
                Route::get('update-profile', action: 'updateProfiles')->name('students.update.profile');
                Route::get('/search', 'searchStudent')->name('students.individual.search');
                // Route::get('/all-students', 'allStudents')->name('students.all.students');
                Route::get('/all-students', 'allStudentsInformation')->name('students.all.students');
                Route::get('/search/ajax', 'searchAjax')->name('students.search.ajax');

                Route::get('/export/{schoolId}/{type}', 'exportStudents')->name('students.export');

                Route::get('/students/{student}/edit', 'edit')->name('students.edit');

                Route::get('/Information/{id}', 'showStudentInformation');

                Route::get('/add-new-student', 'addNewStudent')->name('students.add.new.student');

                Route::post('/students/store', 'storeStudent')->name('students.store');

                Route::get('/transfer-form', 'moveStudentForm')->name('students.transfer');


                Route::get('/streams/by-class', 'getStreamsByClass')->name('streams.by.class');
                Route::get('/students/search', 'searchStudentsByClassStream')->name('students.search');
                Route::post('/students/move', 'moveStudent')->name('students.move');

                Route::get('generate-id', 'generateStudentID')->name('students.generate-id');
                Route::post('/update/{id}', 'updateStudentInformation')->name('students.update.info');
            });
        });
});

Route::controller(ExamController::class)->group(function () {
    Route::group(['middleware' => ['StudentAuth']], function () {
        Route::get('/specific-school-students', 'schoolStudents')->name('all.specific.students');
        Route::get('/manage-exams', 'manageExams')->name('manage.exams');
        Route::get('/edit-exams', 'editExams')->name('edit.exams');
        Route::get('/upload-exams', 'uploadExams')->name('upload.exams');
        Route::get('/exams/{exam}/class/{class}/download', 'downloadClassList')->name('exams.download.classlist');
        Route::get('/generate-exams-results', 'calculateExamResults')->name('generate.exams.results');
        Route::get('/exams/{exam}/{class}/ranking', 'downloadRankedResults')->name('exams.download.ranked');
        Route::get('/exams/download/reportcard/{exam}/{class}', 'downloadReportCard')->name('exams.download.reportcard');

        Route::post('/store-created-exam', 'storeCreatedExam');
        Route::post('/exams/upload-results', 'uploadResults')->name('exams.upload.results');
        Route::post('/exams/compute-results', 'computeResults')->name('exams.compute.results');
    });
});

Route::controller(GradingController::class)->group(function () {
    Route::group(['middleware' => ['StudentAuth']], function () {
        Route::post('/store-created-examination', 'storeCreatedExamination');
        Route::get('/import-marks', 'importMarks')->name('import.marks');
        Route::get('/create-examination', 'createExamination')->name('create.examination');

        Route::get('/exam-years', 'getExamYears');
        Route::get('/exams-by-year/{year}', 'getExamsByYear');
        Route::get('/active-exams', 'getActiveExams');

        Route::get('/import-marks', 'importMarks')->name('import.marks');
        Route::get('/exam/results/{examId}', 'showExamResults')->name('exam.results');

        Route::get('/grading/dashboard', 'gradingDashboard')->name('grading.dashboard');

        Route::post('/toggle-exam-active', 'toggleExamActive')->name('toggle.exam.active');
        Route::post('/import/thanawi-results', 'importThanawiResults')->name('import.thanawi');
        Route::post('/import/idaad-results', 'importIdaadResults')->name('import.idaad');
        Route::post('/import/ple-results', 'importPleResults')->name('import.ple');
    });
});

Route::controller(ItebController::class)->group(function () {

    Route::group(['middleware' => ['StudentAuth']], function () {

        Route::get('/search-iteb-students', 'searchItebStudents')->name('search.iteb.students');
        Route::get('/enter-marks', 'enterMarks')->name('enter.marks');

        Route::get('/class-allocation', 'enterMarks');
        Route::get('/class-allocation/filter', 'filter')->name('class.allocation.filter');

        Route::post('/iteb/save-marks', 'saveMarks')->name('iteb.save.marks');
        Route::post('/iteb/get-marks', 'getMarksForSubject')->name('iteb.get.marks');
        Route::post('iteb/get-subject-marks', 'getSubjectMarks')->name('iteb.get.subject.marks');

        Route::get('/iteb/grading-summary', 'gradingSummary')->name('iteb.grading.summary');
        Route::post('/iteb/process-grading', 'processGrading')->name('iteb.process.grading');
        Route::post('/iteb/save-grading-results', 'saveGradingResults')->name('iteb.save.grading');
        Route::get('/iteb/export-grading', 'exportGrading')->name('iteb.export.grading');

        Route::get('/iteb/analytics/dashboard', 'analyticsDashboard')->name('iteb.analytics.dashboard');
        Route::post('/iteb/analytics/school-ranking', 'getSchoolRanking')->name('iteb.analytics.school.ranking');
        Route::post('/iteb/analytics/student-ranking', 'getStudentRanking')->name('iteb.analytics.student.ranking');
        Route::post('/iteb/analytics/subject-analysis', 'getSubjectAnalysis')->name('iteb.analytics.subject.analysis');
        Route::post('/iteb/analytics/year-comparison', 'getYearComparison')->name('iteb.analytics.year.comparison');
        Route::post('/iteb/analytics/export-report', 'exportAnalyticsReport')->name('iteb.analytics.export');
        Route::get('/iteb/analytics/download/{format}', 'downloadReport')->name('iteb.analytics.download');

        Route::match(['get', 'post'], '/iteb/exam-statistics', 'examStatistics')->name('iteb.exam.statistics');

    });

    Route::get('/about', 'about')->name('about.us');
    Route::get('/contact', 'contact')->name('contact.us');

    Route::post('iteb/exam-statistics/download', 'downloadExamStatistics')->name('iteb.exam.statistics.download');
    Route::post('iteb/exam-statistics/download-excel', 'downloadExamStatisticsExcel')->name('iteb.exam.statistics.download.excel');
    Route::post('iteb/exam-statistics/download-pdf', 'downloadExamStatisticsPdf')->name('iteb.exam.statistics.download.pdf');
    Route::post('exam-statistics/download/students', 'downloadStudentsReport')->name('iteb.exam.statistics.download.students');
    Route::post('exam-statistics/download/schools', 'downloadSchoolsReport')->name('iteb.exam.statistics.download.schools');

});

Route::controller(SubjectRegistrationController::class)->group(function () {
    Route::group(['middleware' => ['StudentAuth']], function () {
        Route::get('/subject-registration', 'index')->name('subject.registration.index');
        Route::get('/subject-registration/manage', 'manage')->name('subject.registration.manage');
        Route::post('/subject-registration/toggle', 'toggle')->name('subject.registration.toggle');
        Route::get('/subject-registration/template', 'downloadTemplate')->name('subject.registration.template');
        Route::post('/subject-registration/import', 'import')->name('subject.registration.import');
    });
});

Route::controller(StudentBulkImportController::class)->group(function () {
    Route::group(['middleware' => ['StudentAuth']], function () {
        Route::get('/student-bulk-import', 'index')->name('student.bulk.import.index');
        Route::get('/student-bulk-import/manage', 'manage')->name('student.bulk.import.manage');
        Route::get('/student-bulk-import/template', 'downloadTemplate')->name('student.bulk.import.template');
        Route::post('/student-bulk-import/import', 'import')->name('student.bulk.import.import');
        Route::delete('/student-bulk-import/student/{studentId}', 'destroyStudent')
            ->where('studentId', '.*')
            ->name('student.bulk.import.destroy.student');
        Route::delete('/student-bulk-import/clear', 'destroyAll')->name('student.bulk.import.destroy.all');
    });
});

Route::controller(SubjectManagementController::class)->group(function () {
    Route::group(['middleware' => ['StudentAuth']], function () {
        Route::get('/subject-management', 'index')->name('subject.management.index');
        Route::post('/subject-management', 'store')->name('subject.management.store');
        Route::put('/subject-management/{id}', 'update')->name('subject.management.update');
        Route::delete('/subject-management/{id}', 'destroy')->name('subject.management.destroy');
        Route::post('/subject-management/{id}/toggle-status', 'toggleStatus')->name('subject.management.toggle.status');
    });
});



Route::group(['middleware' => ['StudentAuth']], function () {

    Route::prefix('school-passwords')
        ->controller(ItebController::class)
        ->group(function () {

            Route::get('/setup', 'schoolPasswordsSetup')->name('school.passwords.setup');
            Route::post('/fetch', 'fetchPassword')->name('school.passwords.fetch');
            Route::post('/generate', 'generatePassword')->name('school.passwords.generate');
            Route::post('/save', 'savePassword')->name('school.passwords.save');

        });
});


Route::get('/template', function () {

    return view('template');
});

Route::get('/certificate', function () {

    return view('Certificates.certificate');
});

Route::group(['middleware' => ['StudentAuth']], function () {

    Route::prefix('passlip')
        ->controller(PasslipAndCertificatesController::class)
        ->group(function () {

            Route::get('/generate-passlips', 'generatePasslip')->name('passlip.generate');
            Route::post('/fetch-school-records', 'fetchSchoolRecords')->name('fetch.school.records');

            Route::get('/certificate/{student_id}', 'downloadertificate')->name('certificate.view');

            Route::get('passlip/download/{student_id}', 'downloadPasslip')->name('passlip.download');
            Route::post('/student-photo-upload', 'uploadStudentPhoto')->name('student.photo.upload');

        });
});

Route::controller(SchoolsController::class)->group(function () {
    Route::group(['middleware' => ['SchoolAuth']], function () {

        Route::group(['prefix' => '/school'], function () {

            Route::get('/dashboard', 'schoolDashboard')->name('school.dashboard');
            Route::get('/grading-summary', 'schoolGradingSummary')->name('school.grading.summary');
            Route::post('/process-grading', 'processGrading')->name('school.process.grading');
            Route::post('iteb/grading/results/pdf', 'generateResultsPDF')->name('iteb.grading.results.pdf');

            Route::get('/register-student', 'schoolStudentRegistration')->name('school.register.student');
            Route::post('/store-registration', 'storeSchoolRegistration')->name('school.store.registration');
            Route::get('/generate-student-id', 'generateSchoolStudentID')->name('school.generate.student.id');
            Route::get('/recent-registrations', 'getRecentRegistrations')->name('school.recent.registrations');
            Route::post('/school/delete-registration', 'deleteRegistration')->name('school.delete.registration');

            Route::get('/school/get-registration', 'getRegistration')->name('school.get.registration');
            Route::post('/school/update-registration', 'updateRegistration')->name('school.update.registration');

            Route::post('/school/registration/upload-photo', 'uploadRegistrationPhoto')->name('school.upload.registration.photo');
            Route::post('/school/registration/remove-photo', 'removeRegistrationPhoto')->name('school.remove.registration.photo');

            Route::get('/school/step3/students', 'step3Students')->name('school.step3.students');
            Route::post('/school/step3/submit', 'step3Submit')->name('school.step3.submit');

        });
    });


    Route::group(['middleware' => ['StudentAuth']], function () {
        Route::group(['prefix' => '/school'], function () {

            Route::get('/admin/student-approvals', 'adminStudentApprovals')->name('admin.student.approvals');
            Route::get('/admin/student-approvals/{schoolPrefix}', 'adminSchoolApprovalDetail')->name('admin.student.approvals.detail');
            Route::post('/admin/student-approvals/update-status', 'adminUpdateApprovalStatus')->name('admin.update.approval.status');

        });
    });
    Route::post('/school-passwords/export-all-pdf', 'exportAllPasswordsPDF')->name('school.passwords.export-all-pdf');
});

Route::controller(AcademicYearController::class)->group(function () {

    Route::get('/academic-years', 'index')->name('academic.years');
    Route::post('/academic-years/store', 'store')->name('academic.years.store');
    Route::get('/academic-years/edit/{id}', 'edit')->name('academic.years.edit');
    Route::post('/academic-years/update/{id}', 'update')->name('academic.years.update');
    Route::delete('/academic-years/delete/{id}', 'destroy')->name('academic.years.delete');

});

/*
|--------------------------------------------------------------------------
| SYSTEM CONFIGURATION MODULE
|--------------------------------------------------------------------------
| Everything a new client needs to re-brand this system (name, acronym,
| logo, contact info) and re-configure its Examination Categories /
| Examination Levels (e.g. Idaad & Thanawi, PLE, UCE & UACE) without
| touching any code. Admin-only, same as the rest of the admin area.
*/
// Route::group(['middleware' => ['AdminAuth']], function () {
// });

Route::controller(SystemConfigurationController::class)
    ->prefix('system-configuration')
    ->group(function () {

        Route::get('/', 'index')->name('system-configuration.index');

        // System identity / branding
        Route::post('/settings', 'updateSettings')->name('system-configuration.settings.update');

        // Examination Categories
        Route::post('/categories', 'storeCategory')->name('system-configuration.categories.store');
        Route::put('/categories/{category}', 'updateCategory')->name('system-configuration.categories.update');
        Route::delete('/categories/{category}', 'destroyCategory')->name('system-configuration.categories.destroy');

        // Examination Levels
        Route::post('/levels', 'storeLevel')->name('system-configuration.levels.store');
        Route::put('/levels/{level}', 'updateLevel')->name('system-configuration.levels.update');
        Route::delete('/levels/{level}', 'destroyLevel')->name('system-configuration.levels.destroy');
    });


Route::prefix('admin')->controller(SchoolsController::class)->group(function () {

    Route::get('/student-approvals', 'adminStudentApprovals');
    Route::get('/student-approvals/{schoolPrefix}', 'adminSchoolApprovalDetail');
    Route::post('/student-approvals/update-status', 'adminUpdateApprovalStatus');

    // SLOT MANAGEMENT
    Route::get('/school-slots/search', 'adminSearchSchoolsForSlots')->name('admin.school.slots.search');
    Route::post('/school-slots/assign', 'adminAssignSlots')->name('admin.school.slots.assign');
    Route::post('/school-slots/toggle', 'adminToggleSchoolRegistration')->name('admin.school.slots.toggle');
    Route::get('/school-slots/history', 'adminSlotHistory')->name('admin.school.slots.history');

    // REGISTRATION PERIOD
    Route::post('/registration-period', 'adminSaveRegistrationPeriod')->name('admin.registration.period.save');
    Route::put('/registration-period/{id}', 'adminUpdateRegistrationPeriod')->name('admin.registration.period.update');
    Route::delete('/registration-period/{id}', 'adminDeleteRegistrationPeriod')->name('admin.registration.period.delete');

    Route::post('/admin/student-registrations/toggle-lock', 'adminToggleStudentLock')->name('admin.student.toggle.lock');
});


Route::prefix('school-recognition')
    ->controller(SchoolRecognitionCertificateController::class)
    ->name('school.recognition.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/issue', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/view/{id}', 'show')->name('show');
        Route::post('/revoke/{id}', 'revoke')->name('revoke');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
        Route::post('/{id}/reactivate', 'reactivate')->name('reactivate');
    });

Route::get(
    '/school/recognition-certificate',
    [SchoolRecognitionCertificateController::class, 'schoolView']
)
    ->name('school.recognition.view')
    ->middleware('SchoolAuth');


Route::controller(GradingSettingsController::class)->group(function () {
    Route::group(['middleware' => ['StudentAuth']], function () {
        Route::get('/grading-settings', 'index')->name('grading.settings');
        Route::get('/grading-settings/category/{category}', 'getByCategory')->name('grading.settings.category');
        Route::post('/grading-settings', 'store')->name('grading.settings.store');
        Route::put('/grading-settings/{id}', 'update')->name('grading.settings.update');
        Route::delete('/grading-settings/{id}', 'destroy')->name('grading.settings.destroy');
        Route::post('/grading-settings/reset/{category}', 'resetDefaults')->name('grading.settings.reset');
    });
});


Route::get('houses/create', [HouseController::class, 'create'])->name('houses.create');
Route::post('houses/store', [HouseController::class, 'store'])->name('houses.store');