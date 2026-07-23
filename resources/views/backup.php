<script type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- $teacher->password = Hash::make($request->password);
$teacher->must_change_password = false;
$teacher->save(); -->

<!-- Remove-Item public/storage       -->
<!-- php artisan storage:link         -->
                                      
<!-- symlinks above are not working, by pass with this (claude AI) -->
rm public/storage && ln -s /home/u453625278/domains/smasa-academics.com/public_html/storage/app/public public/storage
rm public/storage && ln -s /home/u453625278/domains/smasa-academics.com/public_html/storage/app/public public/storage

<!-- To make it even easier, you can save it as an alias in your shell. Add this to your ~/.bashrc: -->
echo "alias storage:relink='rm public/storage && ln -s /home/u453625278/domains/smasa-academics.com/public_html/storage/app/public public/storage'" >> ~/.bashrc && source ~/.bashrc
<!-- Then anytime you need to relink, just run: -->
storage:relink
<!-- Note: The alias only works when you're inside your public_html directory since the rm public/storage path is relative. -->


use App\Http\Controllers\Helper;

<!-- USE FULL QUERIES IN THIS PROJECT -->

<!-- (FETCHING STUDENT ID FOR THE NEW STUDENT BEING ADDED TO THE STUDENT_BASIC TABLE TO BE USED IN THE CLASS ALLOCATION TABLE) -->
 
SELECT id, Student_ID, House
FROM students_basic
WHERE Student_ID LIKE 'IT-001-ID-%-2025'
ORDER BY id;


<button type="button" class="btn btn-lg btn-primary btn-block px-4" onclick="confirmSubmission(this)">
    <i class="fe fe-check"></i> Send
</button>

Now, i have this code for analytics, but its on a smaller level, but first go through it and see it, i want to get
number of schools registered in that year, split into 2 columns Idaad (0) Level and Thanawi (A) Level with total numbers
as in 57 and 26, and then Number of students registered in that year, as in remember Idaad we said in their Student_IDs
they have ID, like IT-074-ID-251-2025 and Thanawi IT-001-TH-010-2025 , then Students Passed:, the Students Failed
altogether from schools, Then another table Pass and Fail Percentage in Idaad and Thanawi, Then Ten Best Students, Then
Ten Best Students Thanawi Specific, (Its own table alone), then Then Ten Best Students Idaad Specific, (Its own table
alone), Best done subjects , these all should include percentages and a so on ,Ten Best Subjects(A Level), Ten Best
Subjects (O level ), Worst done Subjects(5) in A Level,Worst done Subjects(5) in O Level,Then General Performance in
Idaad (O Level) showing School Name, then followed with 1st class, 2nd , 3rd and so on, so this

<script type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

<script>
    function confirmSubmission(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to proceed with the submission?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                button.disabled = true;
                button.innerHTML = '<i class="fe fe-loader"></i> Sending...'; // Optionally change button text
                // Submit the form
                document.querySelector("form").submit(); // Adjust to target your form
            }
        });
    }
</script>

// SESSEIONS

@if (Session::get('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif

@if (Session::get('fail'))
<div class="alert alert-danger">
    {{ Session::get('fail') }}
</div>
@endif

Remove-Item storage\framework\views\*.php -Force

class="btn text-white" style="background-color: #5351e4;"

error: function(data) {
$('body').html(data.responseText);
}


 $.ajax({
                            url: '/store-created-examination',
                            method: 'POST',
                            data: formData,
                            success: function(response) {
                                Swal.fire('Success', 'Exam created successfully!',
                                    'success');

                                // Optional: Reset form
                                $('#create-exam-form')[0].reset();
                                $('#marksUploadEnabled').val('0');
                                $('#yearToggle').prop('checked', false);
                                $('#yearToggle').trigger('change');
                            },
                            error: function(xhr, status, error) {
                                // Check if it's a validation error response
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    let errorMessage = '';
                                    $.each(xhr.responseJSON.errors, function(key,
                                        value) {
                                        errorMessage += value + '\n';
                                    });
                                    Swal.fire('Error', errorMessage, 'error');
                                }
                                // Check if it's a dd() dump from Laravel
                                else if (xhr.responseText && xhr.responseText.includes(
                                        'html')) {
                                    $('body').html(xhr.responseText);
                                } else {
                                    Swal.fire('Error', 'An error occurred: ' + error,
                                        'error');
                                }
                            },
                            complete: function() {
                                submitBtn.prop('disabled', false);
                                submitBtn.html(
                                    '<i class="bi bi-plus-circle me-2"></i> Create Exam'
                                );
                            }
                        });
                        

document.addEventListener("DOMContentLoaded", function() {
const form = document.getElementById("quizForm");
form.addEventListener("submit", function(e) {
e.preventDefault();

Swal.fire({
title: 'Are you sure?',
text: "You are about to create this quiz.",
icon: 'question',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#aaa',
confirmButtonText: 'Yes, save it!'
}).then((result) => {
if (result.isConfirmed) {
form.submit();
}
});
});
});

$(document).ready(function() {
const form = $('#quizForm');
const submitBtn = form.find('button[type="submit"]');

form.on('submit', function(e) {
e.preventDefault();

Swal.fire({
title: 'Are you sure?',
text: "You are about to create this quiz.",
icon: 'question',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#aaa',
confirmButtonText: 'Yes, save it!'
}).then((result) => {
if (result.isConfirmed) {
// Button UI
submitBtn.prop('disabled', true);
submitBtn.html('Creating quiz... <i class="fas fa-spinner fa-spin"></i>');

// Submit with AJAX
$.ajax({
url: form.attr('action'),
method: form.attr('method'),
data: form.serialize(),
success: function(response) {
// Redirect or success SweetAlert
Swal.fire({
title: 'Success!',
text: 'Quiz created successfully!',
icon: 'success'
}).then(() => {
window.location.href =
"{{ route('quizzes.create.quiz') }}";
});
},
error: function(data) {
// Show raw error HTML for debugging (as you requested)
$('body').html(data.responseText);
}
});
}
});
});
});


@if (session('error'))
Swal.fire({
icon: 'error',
title: 'Oops!',
text: '{{ session('error') }}',
});
@endif

<!-- Confirm on Form submission -->

<button class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Save</button>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if (session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('myForm').addEventListener('submit', function (event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>


<!-- DELETE BUTTONS SWAL IMPLEMENTATION -->


<a href="{{ url('delete-record/' . $item->md_id) }}" class="btn btn-sm btn-danger delete-record-btn">
    Delete
</a>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if (session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif
</script>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-record-btn').forEach(function (btn) {
            btn.addEventListener('click', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Please confirm before you delete this record!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = this.href;
                    }
                });
            });
        });
    });

</script>


<!-- EDIT BUTTON INFORMATION -->


<a href="{{ url('master-data/edit-record/' . $item->md_id) }}" class="btn btn-sm btn-primary edit-record-btn"
    data-url="{{ url('master-data/edit-record/' . $item->md_id) }}">
    Edit
</a>

<script>
    // Select all edit buttons

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.edit-record-btn').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default anchor behavior

                let url = this.getAttribute('data-url'); // Get URL from data attribute

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to edit this record!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, edit it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url; // Redirect to URL if confirmed
                    }
                });
            });
        });
    });


    document.getElementById('register-user-btn').addEventListener('click', function (event) {
        event.preventDefault();

        var button = this;

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to register a new user?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, register!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {

                button.disabled = true;
                button.innerHTML = 'Creating user account...<i class="fas fa-spinner fa-spin"></i>';
                document.querySelector("form").submit();
            }
        });
    });

</script>


$('#otp_verification').html(
'<span class="text-white">Verifying...</span><i class="fe fe-loader"></i> ');
$('#otp_verification').css('cursor', 'default');
$('#otp_verification').prop('disabled', true);


@if ($procurement->isEmpty())
<div class="col-sm-12 col-md-12">
    <div class="alert alert-warning mt-3" role="alert">
        No prequalification periods found
    </div>
</div>
@else
@endif


@if (empty($time_data))

@else
@endif

<!-- selecting master data individual meaning  -->

<p>{{ Controller::rgf('master_datas', $user_profile_data->year, 'md_id', 'md_name') }}

    <!-- selecting master data drop down meaning  -->
<p>{{ Controller::rgf('master_datas', $user_profile_data->year, 'md_id', 'md_name') }}

    <td><?php
    echo Controller::DropMasterData(config('constants.options.PROCUREMENT_CATEGORY'), $procurement_record->category_of_procurement, 'category_of_procurement', 2);
    ?></td>


<div class="col-sm-6 col-md-6">
    <div class="form-group">
        <label class="form-label">Category</label>
        <td><?php
        echo Helper::DropMasterData(config('constants.options.COURSE_CATEGORIES'), $course->category_id, 'category', 2);
        ?></td>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<br>
<script type="text/javascript"></script>

<script>
    function handleSubmit(form) {
        const uploadButton = document.getElementById('uploadButton');
        const loader = document.getElementById('loader');

        uploadButton.disabled = true;
        loader.style.display = 'inline-block';

        uploadButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Uploading...';

        return true;
    }
</script>


.border {
border: 1px solid #ddd;
border-radius: 8px;
padding: 20px;
box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.25);
background-color: #ffffff;
}

<!-- php artisan schedule:work -->

echo '
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">';



<?php

$ActiveUser = $procurement_officer = config('constants.options.HeadOfProcurementUserId');
$userRoleId = DB::table('admins')->where('id', Session('LoggedAdmin'))->value('user_id');

?>


<div class="alert alert-warning" role="alert">
    Head of Procurement required to process this section
</div>

closing Modal bootstrap Information

<!-- NEW BOOTSTRAP IMPLEMENTATION CLOSING MODAL -->

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>


$finanical_year = Controller::rgf('master_datas', $year, 'md_id', 'md_code');
$Record_Approval = procurement_approval::first();

if ($Record_Approval) {
$procurement = DB::table('procurements')->join('master_datas', 'procurements.currency', '=',
'master_datas.md_id')->select('procurements.*', 'master_datas.created_at as master_created_at',
'master_datas.md_name')->where('procurements.year', $year)->where('procurements.is_item_planned', 0)->paginate(30);

$data = ['LoggedUserAdmin' => Admin::where('id', '=', session('LoggedAdmin'))->first()];

return view('procurement-plan.ProcurementRecords', $data, compact(['procurement', 'year']))->with('finanical_year',
$finanical_year);
} else {
$procurement = DB::table('procurements')->join('master_datas', 'procurements.currency', '=',
'master_datas.md_id')->select('procurements.*', 'master_datas.created_at as master_created_at',
'master_datas.md_name')->where('procurements.year', $year)->where('procurements.is_item_planned', 0)->paginate(30);

$data = ['LoggedUserAdmin' => Admin::where('id', '=', session('LoggedAdmin'))->first()];

return view('procurement-plan.ProcurementRecords', $data, compact(['procurement', 'year']))->with('finanical_year',
$finanical_year);
}



<!-- MODAL CLOSING -->

<!-- Replace data-dismiss="modal" with data-bs-dismiss="modal" throughout the code. -->

<!-- CKEDITOR BEING IMPELEMENTED IN THE SYSTEM -->

<section>
    <div class="tab-pane">
        <div class="col-md-12">
            <div class="editor-container">
                <textarea name="content" id="t_description"></textarea>
            </div>

            <script>
                ClassicEditor
                    .create(document.querySelector('#t_description'))
                    .then(editor => {
                        window.t_description = editor;
                    })
                    .catch(error => {
                        console.error('There was a problem initializing CKEditor:', error);
                    });
            </script>
        </div>
    </div>
</section>


<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

$linkToProceed = DB::table('master_datas')
->where('md_master_code_id', config('constants.options.APP_CONFIG'))
->where('md_code', operator: 'Supplier Portal')
->value('md_name');

'pendingRequests' => $linkToProceed .'/support-team/pending-issues',

var content = t_description.getData().trim();


$user_comments = DB::table('procurement_comments')->where('ppc_year', $year)->where('ppc_division', $division)->get();

$currencyIds = DB::table('procurements')->where('year', $year)->where('requisition_division',
$division)->distinct()->pluck('currency');

if ($currencyIds->count() === 1) {
$currencyIds = [$currencyIds->first()];
}

$currencies = collect($currencyIds)
->map(function ($currencyId) {
return Controller::MasterRecord(config('constants.options.CURRENCY_METHOD'), $currencyId);
})
->filter()
->toArray();

$finalCurrency = count($currencies) === 1 ? $currencies[0] : $currencies;


<br>Currency:
<b>{{ is_array($finalCurrency) ? implode(', ', $finalCurrency) : $finalCurrency }}</b>



$procurement_officer = config('constants.options.PROCUREMENT_OFFICER');


return redirect()->route('student.dashboard')->with('error', 'You do not have permission to access that feature!');


<tr class="bg-dark text-white">
    <td colspan="8"><strong>Contract Reference: {{ $draftRecord->fc_contract_ref }} | Contract
            Title: {{ $draftRecord->fc_contract_title }} | Contract Subject:
            {{ $draftRecord->fc_contract_subject }} | Start Date: {{ $draftRecord->fc_start_date }} |
            End Date: {{ $draftRecord->fc_end_date }}</strong></td>

    <!-- LABELS PILL-->

    @keyframes pop {
    0% {
    transform: scale(1);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 0 15px rgba(255, 0, 0, 0.5);
    }

    50% {
    transform: scale(1.1);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 0 25px rgba(255, 0, 0, 0.8);
    }

    100% {
    transform: scale(1);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 0 15px rgba(255, 0, 0, 0.5);
    }
    }

    $('#student_username').removeClass('is-invalid').removeClass('is-valid');


    <!-- BADGE  -->

    <span class="badge badge-danger position-absolute rounded-circle px-3 py-2" style="top: 10px; right: 10px; font-size: 16px; width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;
                                       box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); animation: pop 1.2s infinite;">
        121
    </span>


    WORKFLOW REQUIRED COLUMNS
    ----------------------------------------
    aman_counter =====> 1 // intials
    aman_added_by
    aman_status =====> 1 // intials
    aman_date_added
    aman_type
    aman_reference

    WORKFLOW STATUSES AND VALUES
    -----------------------------------------

    aman_counter =====> 1 // {1,1 for initiating approva}
    aman_status =====> 1 //

    aman_status =====> 1 // {1,2... approving the counter increases accordingly in approvals}
    aman_counter =====> 1,2,3.... //

    aman_status =====> 10 // {10,2... status value is 10 for fully approved approvals}
    aman_counter =====> 1,2,3.... //

    WORKFLOW BLADES AND CONTROLLERS CODE REQUIRED
    -----------------------------------------
    1.Contrller containing Approval View for new Approvers and Removing (MasterApprovalOrder)

    public function aaTestApprovals()
    {

    $data = ['LoggedUserAdmin' => Admin::where('id', '=', session('LoggedAdmin'))->first()];

    return view('master-approval-order.aa-test-approvals', $data);
    }

    2.Contrller containing Logic to approve / delete / request more information (MaAideMemoireApprovalTest)
    3.Table which contains all recent approvals (master_approvals)
    4.Table which contains all approvals orders (master_approval_orders)


    WORKFLOW BLADE TO CHECK OF SOMEONE IF AMONGST THE APPROVERS CODE TO BE USED
    -----------------------------------------
    ($list->taf_counter == 2 && in_array(Helper::user_id(), $approvers))
    {

    }

    WORKFLOW APPROVAL CODE TO BE USED
    -----------------------------------------

    <div class="row">
        <div class="col-md-12">
            <?php

            $masterApproval = new MaAideMemoireApprovalTest();

            $accomodation = DB::table('aide_memoire_accomodation_nos')->where('id', 10033)->first();
            $aman_type = 'HZA';
            // $aman_type = 'AIDE MEMOIRE';
            
            $masterApproval->display([
                'table' => 'aide_memoire_accomodation_nos',
                'status' => 'aman_status',
                'counter' => @$accomodation->aman_counter,
                'counter_field' => 'aman_counter',
                'id_field' => 'id',

                'where' => @$aman_type,
                'id' => @$accomodation->id,
                'notify_user' => @$accomodation->am_added_by,
                'reference' => @$accomodation->aman_ref,
                'extra' => [
                    'labels' => [
                        '1' => 'Prepared By',
                        '2' => 'Tested By',
                        '3' => 'Verified By',
                    ],
                ],
            ]);

            echo '<div style="clear:both"></div>';

            ?>
        </div>
    </div>

    -------------------------------------------------------------------------------------------------------------

    Full page code
    -------------------------------------------------------------------------------------------------------------

    <div class="w-40 bg-style min-h-100vh page-style">


        $units_of_measures = master_data::where('md_master_code_id', '=', config('constants.options.UNIT_OF_MEASURE'))
        ->orderBy('md_name')
        ->select('md_id', 'md_name')
        ->get();

        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $allCourses->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <div id="loading-gif">
            <img src="{{ URL::asset('assets/images/brand/loading.gif') }}" alt="Loading...">
        </div>

        <style>
            .swal2-container {
                z-index: 99999 !important;
            }
        </style>

        <style>
            #loading-gif {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 9999;
                /* Ensure it's on top of other content */
            }
        </style>



        function showLoading() {
        $('#loading-gif').show();
        }


        function hideLoading() {
        $('#loading-gif').hide();
        }

        if ($permission_exists) {
        return response()->json([
        'status' => 'error',
        'message' => 'Permission was already created.',
        ], 409); // <-- Return a 409 Conflict status code } <script>
            document.getElementById('quiz-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
            title: 'Are you sure?',
            text: "Once submitted, you won't be able to change your answers.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
            if (result.isConfirmed) {

            const submitBtn = e.target.querySelector('button[type="submit"]');

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Submitting...<i class="fas fa-spinner fa-spin"></i>';

            e.target.submit();
            }
            });
            });
            </script>


            MAIL BACKUP
            --------------------------------------------------------
            MAIL_MAILER=smtp
            MAIL_HOST=smtp.gmail.com
            MAIL_PORT=587
            MAIL_USERNAME=huzaifabukenya227@gmail.com
            MAIL_PASSWORD=dmdzbelafzfsmelm
            MAIL_ENCRYPTION=tls

            <!-- CLEANING MASTER DATA TO REMAIN WITH ISLAMIC SUBJECTS ONLY. -->

            -- Step 1: Check which master_datas records will be deleted (preview)
SELECT md.*, mc.mc_id, mc.mc_name
FROM master_datas md
INNER JOIN master_codes mc ON md.md_master_code_id = mc.id
WHERE mc.mc_id IN ('SOS', 'SVS', 'SMS', 'SLS', 'SSS', 'SHS', 'STR', 'OLevel', 'ALevel', 'PLevel', 'URPF', 'Thanawi Papers', 'Idaad Papers', 'Examination Name');

-- Step 2: Count records to be deleted from master_datas
SELECT COUNT(*) as records_to_delete
FROM master_datas md
INNER JOIN master_codes mc ON md.md_master_code_id = mc.id
WHERE mc.mc_id IN ('SOS', 'SVS', 'SMS', 'SLS', 'SSS', 'SHS', 'STR', 'OLevel', 'ALevel', 'PLevel', 'URPF', 'Thanawi Papers', 'Idaad Papers', 'Examination Name');

-- Step 3: Delete from master_datas
DELETE md 
FROM master_datas md
INNER JOIN master_codes mc ON md.md_master_code_id = mc.id
WHERE mc.mc_id IN ('SOS', 'SVS', 'SMS', 'SLS', 'SSS', 'SHS', 'STR', 'OLevel', 'ALevel', 'PLevel', 'URPF', 'Thanawi Papers', 'Idaad Papers', 'Examination Name');

-- Step 4: Delete from master_codes
DELETE FROM master_codes
WHERE mc_id IN ('SOS', 'SVS', 'SMS', 'SLS', 'SSS', 'SHS', 'STR', 'OLevel', 'ALevel', 'PLevel', 'URPF', 'Thanawi Papers', 'Idaad Papers', 'Examination Name');

-- Step 5: Verify the deletions
SELECT * FROM master_codes WHERE mc_id IN ('SOS', 'SVS', 'SMS', 'SLS', 'SSS', 'SHS', 'STR', 'OLevel', 'ALevel', 'PLevel', 'URPF', 'Thanawi Papers', 'Idaad Papers', 'Examination Name');
SELECT * FROM master_datas WHERE md_master_code_id IN (SELECT id FROM master_codes WHERE mc_id IN ('SOS', 'SVS', 'SMS', 'SLS', 'SSS', 'SHS', 'STR', 'OLevel', 'ALevel', 'PLevel', 'URPF', 'Thanawi Papers', 'Idaad Papers', 'Examination Name'));



  <!-- INSERTION OF MASTER DATA AND MASTER CODES INFORMATION CLEANESED. -->


INSERT INTO `master_codes` (`id`, `mc_id`, `mc_code`, `mc_name`, `mc_description`, `mc_date_added`, `mc_added_by`, `created_at`, `updated_at`) VALUES
(1, 'SP', 'SP', 'School Products', 'School Products', '1745931824', '1', NULL, NULL),
(2, 'SG', 'SG', 'School Gender', 'School Gender', '1750796952', '1', NULL, NULL),
(3, 'SO', 'SO', 'School Ownership', 'School Ownership', '1750797538', '1', NULL, NULL),
(4, 'RL', 'RL', 'Regional Level', 'Regional Level', '1750798461', '1', NULL, NULL),
(5, 'SPP', 'SPP', 'School Population', 'School Population', '1750798882', '1', NULL, NULL),
(6, 'ST', 'ST', 'School Type', 'School Type', '1751364399', '1', NULL, NULL),
(7, 'STT', 'STT', 'School Terms', 'School Terms', '1751364706', '1', NULL, NULL),
(8, 'STS', 'STS', 'Technical subjects', 'Technical subjects', '1751371459', '1', NULL, NULL),
(20, 'Thanawi Papers', 'Thanawi Papers', 'Thanawi Papers', 'Thanawi Papers', '1770464165', '1', NULL, NULL),
(21, 'Idaad Papers', 'Idaad Papers', 'Idaad Papers', 'Idaad Papers', '1770464784', '1', NULL, NULL),
(23, 'IDAAD ARABIC LANGUAGE', 'IDAAD ARABIC LANGUAGE', 'IDAAD ARABIC LANGUAGE', 'IDAAD ARABIC LANGUAGE', '1776353600', '1', NULL, NULL),
(24, 'IDAAD FAITH & CIVILIZATION', 'IDAAD FAITH & CIVILIZATION', 'IDAAD FAITH & CIVILIZATION', 'IDAAD FAITH & CIVILIZATION', '1776353887', '1', NULL, NULL),
(25, 'IDAAD JURISPRUDENCE & ITS SOURCES', 'IDAAD JURISPRUDENCE & ITS SOURCES', 'IDAAD JURISPRUDENCE & ITS SOURCES', 'IDAAD JURISPRUDENCE & ITS SOURCES', '1776354126', '1', NULL, NULL),
(26, 'IDAAD PROPHETIC TRADITIONS', 'IDAAD PROPHETIC TRADITIONS', 'IDAAD PROPHETIC TRADITIONS', 'IDAAD PROPHETIC TRADITIONS', '1776354135', '1', NULL, NULL),
(27, 'IDAAD QURAN & ITS SCIENCES', 'IDAAD QURAN & ITS SCIENCES', 'IDAAD QURAN & ITS SCIENCES', 'IDAAD QURAN & ITS SCIENCES', '1776354151', '1', NULL, NULL),
(28, 'THANAWI ARABIC LANGUAGE', 'THANAWI ARABIC LANGUAGE', 'THANAWI ARABIC LANGUAGE', 'THANAWI ARABIC LANGUAGE', '1776354350', '1', NULL, NULL),
(29, 'THANAWI FAITH & CIVILIZATION', 'THANAWI FAITH & CIVILIZATION', 'THANAWI FAITH & CIVILIZATION', 'THANAWI FAITH & CIVILIZATION', '1776354562', '1', NULL, NULL),
(30, 'THANAWI JURISPRUDENCE & ITS SOURCES', 'THANAWI JURISPRUDENCE & ITS SOURCES', 'THANAWI JURISPRUDENCE & ITS SOURCES', 'THANAWI JURISPRUDENCE & ITS SOURCES', '1776354689', '1', NULL, NULL),
(31, 'THANAWI PROPHETIC TRADITIONS', 'THANAWI PROPHETIC TRADITIONS', 'THANAWI PROPHETIC TRADITIONS', 'THANAWI PROPHETIC TRADITIONS', '1776354832', '1', NULL, NULL),
(32, 'THANAWI QURAN & ITS SCIENCES', 'THANAWI QURAN & ITS SCIENCES', 'THANAWI QURAN & ITS SCIENCES', 'THANAWI QURAN & ITS SCIENCES', '1776354959', '1', NULL, NULL);



INSERT INTO `master_datas` (`md_id`, `md_master_code_id`, `md_code`, `md_name`, `md_description`, `md_date_added`, `md_added_by`, `created_at`, `updated_at`, `md_misc1`, `md_misc2`, `md_misc3`, `md_misc4`) VALUES
(1, 1, 'Idaad And Thanawi', 'Idaad And Thanawi', 'Idaad And Thanawi', '1770455659', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 2, 'Mixed', 'Mixed', 'Mixed', '1750796997', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 2, 'Girls', 'Girls', 'Girls', '1750796987', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 2, 'Boys', 'Boys', 'Boys', '1770455852', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 3, 'Mixed', 'Mixed', 'Mixed', '1750797921', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 3, 'Public', 'Public', 'Public', '1750797898', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 3, 'Private', 'Private', 'Private', '1750797830', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 4, 'National', 'National', 'National', '1750798478', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 5, '0 - 50', '0 - 50', '0 - 50', '1750799268', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 5, '50 - 150', '50 - 150', '50 - 150', '1750799340', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 5, '151 - 350', '151 - 350', '151 - 350', '1750799404', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 5, '351 - 500', '351 - 500', '351 - 500', '1750799414', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 5, '500 - 1000', '500 - 1000', '500 - 1000', '1750799422', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 5, '1001 - 2000', '1001 - 2000', '1001 - 2000', '1750799435', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 5, '2001 - 5000+', '2001 - 5000+', '2001 - 5000+', '1750799448', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(24, 6, 'Primary', 'Primary', 'Primary', '1751364466', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(25, 6, 'Secondary', 'Secondary', 'Secondary', '1751364481', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(26, 7, 'Term I', 'Term I', 'Term I', '1751364775', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(29, 7, 'Term II', 'Term II', 'Term II', '1751364836', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(30, 7, 'Term III', 'Term III', 'Term III', '1751364857', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(31, 8, 'Art and Design', 'Art and Design', 'Art and Design', '1751371611', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(33, 8, 'Agriculture', 'Agriculture', 'Agriculture', '1751371649', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(162, 21, 'AR-002', 'Arabic Literature', 'الأدب العربي', '1774097070', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(163, 21, 'AR-003', 'Composition & Comprehension', 'الإنشاء والمطالعة', '1774097112', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(164, 21, 'AR-004', 'Grammar & Morphology', 'النحو والصرف', '1774097140', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(165, 21, 'FC-005', 'Islamic Monotheism', 'التوحيد', '1774097162', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(166, 21, 'FC-007', 'Islamic History', 'التاريخ الإسلامي', '1774097185', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(167, 21, 'JS-011', 'Jurisprudence of Rituals', 'فقه العبادات', '1774097209', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(168, 21, 'PT-013', 'Traditions of the Prophet', 'الحديث', '1774097230', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(169, 21, 'QS-015', 'Quran Recitation and its Rules', 'التلاوة والتجويد', '1774097252', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(170, 21, 'QS-016', 'Quran Memorization & Exegesis', 'الحفظ والتفسير', '1774363346', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(171, 21, 'QS-017', 'Dictation & Calligraphy', 'الإملاء والخط', '1774097297', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(172, 20, 'PT-012', 'Sources of Prophetic Traditions', 'أصول الحديث', '1772949496', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(179, 20, 'AR-004', 'Grammar & Morphology', 'النحو والصرف', '1772949167', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(180, 20, 'JS-010', 'Islamic Family Law', 'فقه الأحوال الشخصية', '1772949463', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(181, 20, 'AR-002', 'Arabic Literature', 'الأدب العربي', '1772949110', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(182, 20, 'JS-009', 'Sources of Jurisprudence', 'أصول الفقه', '1772949432', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(183, 20, 'FC-007', 'Islamic History', 'التاريخ الإسلامي', '1772949364', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(185, 20, 'JS-008', 'Inheritance', 'الفرائض', '1772949396', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(186, 20, 'PT-013', 'Traditions of the Prophet', 'الحديث', '1772949538', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(187, 20, 'AR-003', 'Composition & Comprehension', 'الإنشاء والمطالعة', '1772949144', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(188, 20, 'QS-014', 'Sources of Exegesis', 'أصول التفسير', '1772949571', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(189, 20, 'QS-015', 'Quran Recitation & Its Rules', 'التلاوة والتجويد', '1772949611', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(190, 20, 'QS-016', 'Quran Memorization & Exegesis', 'الحفظ والتفسير', '1772949658', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(191, 20, 'AR-001', 'Rhetoric', 'البلاغة', '1772949062', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(192, 20, 'FC-005', 'Islamic monotheism', 'التوحيد', '1772949213', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(193, 20, 'FC-006', 'Religions &sects', 'الأديان والفرق', '1772949289', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(194, 23, 'AR-002', 'Arabic Literature', 'الأدب العربي', '1774097070', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(195, 23, 'AR-003', 'Composition & Comprehension', 'الإنشاء والمطالعة', '1774097112', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(196, 23, 'AR-004', 'Grammar & Morphology', 'النحو والصرف', '1774097140', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(197, 24, 'FC-005', 'Islamic Monotheism', 'التوحيد', '1774097162', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(198, 24, 'FC-007', 'Islamic History', 'التاريخ الإسلامي', '1774097185', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(199, 25, 'JS-011', 'Jurisprudence of Rituals', 'فقه العبادات', '1774097209', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(200, 26, 'PT-013', 'Traditions of the Prophet', 'الحديث', '1774097230', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(201, 27, 'QS-015', 'Quran Recitation and its Rules', 'التلاوة والتجويد', '1774097252', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(202, 27, 'QS-016', 'Quran Memorization & Exegesis', 'الحفظ والتفسير', '1774363346', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(203, 27, 'QS-017', 'Dictation & Calligraphy', 'الإملاء والخط', '1774097297', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(204, 28, 'AR-001', 'Rhetoric', 'البلاغة', '1772949062', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(205, 28, 'AR-002', 'Arabic Literature', 'الأدب العربي', '1772949110', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(206, 28, 'AR-003', 'Composition & Comprehension', 'الإنشاء والمطالعة', '1772949144', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(207, 28, 'AR-004', 'Grammar & Morphology', 'النحو والصرف', '1772949167', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(208, 29, 'FC-005', 'Islamic monotheism', 'التوحيد', '1772949213', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(209, 29, 'FC-006', 'Religions &sects', 'الأديان والفرق', '1772949289', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(210, 29, 'FC-007', 'Islamic History', 'التاريخ الإسلامي', '1772949364', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(211, 30, 'JS-009', 'Sources of Jurisprudence', 'أصول الفقه', '1772949432', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(212, 30, 'JS-008', 'Inheritance', 'الفرائض', '1772949396', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(213, 30, 'JS-010', 'Islamic Family Law', 'فقه الأحوال الشخصية', '1772949463', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(214, 31, 'PT-012', 'Sources of Prophetic Traditions', 'أصول الحديث', '1772949496', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(215, 31, 'PT-013', 'Traditions of the Prophet', 'الحديث', '1772949538', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(216, 32, 'QS-014', 'Sources of Exegesis', 'أصول التفسير', '1772949571', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(217, 32, 'QS-015', 'Quran Recitation & Its Rules', 'التلاوة والتجويد', '1772949611', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(218, 32, 'QS-016', 'Quran Memorization & Exegesis', 'الحفظ والتفسير', '1772949658', '1', NULL, NULL, NULL, NULL, NULL, NULL);



INSERT INTO `master_datas` (`md_id`, `md_master_code_id`, `md_code`, `md_name`, `md_description`, `md_date_added`, `md_added_by`, `created_at`, `updated_at`, `md_misc1`, `md_misc2`, `md_misc3`, `md_misc4`) VALUES
(162, 21, 'AR-002', 'Arabic Literature', 'الأدب العربي', '1774097070', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(163, 21, 'AR-003', 'Composition & Comprehension', 'الإنشاء والمطالعة', '1774097112', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(164, 21, 'AR-004', 'Grammar & Morphology', 'النحو والصرف', '1774097140', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(165, 21, 'FC-005', 'Islamic Monotheism', 'التوحيد', '1774097162', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(166, 21, 'FC-007', 'Islamic History', 'التاريخ الإسلامي', '1774097185', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(167, 21, 'JS-011', 'Jurisprudence of Rituals', 'فقه العبادات', '1774097209', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(168, 21, 'PT-013', 'Traditions of the Prophet', 'الحديث', '1774097230', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(169, 21, 'QS-015', 'Quran Recitation and its Rules', 'التلاوة والتجويد', '1774097252', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(170, 21, 'QS-016', 'Quran Memorization & Exegesis', 'الحفظ والتفسير', '1774363346', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(171, 21, 'QS-017', 'Dictation & Calligraphy', 'الإملاء والخط', '1774097297', '1', NULL, NULL, NULL, NULL, NULL, NULL),


(172, 20, 'PT-012', 'Sources of Prophetic Traditions', 'أصول الحديث', '1772949496', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(179, 20, 'AR-004', 'Grammar & Morphology', 'النحو والصرف', '1772949167', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(180, 20, 'JS-010', 'Islamic Family Law', 'فقه الأحوال الشخصية', '1772949463', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(181, 20, 'AR-002', 'Arabic Literature', 'الأدب العربي', '1772949110', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(182, 20, 'JS-009', 'Sources of Jurisprudence', 'أصول الفقه', '1772949432', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(183, 20, 'FC-007', 'Islamic History', 'التاريخ الإسلامي', '1772949364', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(185, 20, 'JS-008', 'Inheritance', 'الفرائض', '1772949396', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(186, 20, 'PT-013', 'Traditions of the Prophet', 'الحديث', '1772949538', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(187, 20, 'AR-003', 'Composition & Comprehension', 'الإنشاء والمطالعة', '1772949144', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(188, 20, 'QS-014', 'Sources of Exegesis', 'أصول التفسير', '1772949571', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(189, 20, 'QS-015', 'Quran Recitation & Its Rules', 'التلاوة والتجويد', '1772949611', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(190, 20, 'QS-016', 'Quran Memorization & Exegesis', 'الحفظ والتفسير', '1772949658', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(191, 20, 'AR-001', 'Rhetoric', 'البلاغة', '1772949062', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(192, 20, 'FC-005', 'Islamic monotheism', 'التوحيد', '1772949213', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(193, 20, 'FC-006', 'Religions &sects', 'الأديان والفرق', '1772949289', '1', NULL, NULL, NULL, NULL, NULL, NULL);

INSERT INTO `master_datas` (`md_id`, `md_master_code_id`, `md_code`, `md_name`, `md_description`, `md_date_added`, `md_added_by`, `created_at`, `updated_at`, `md_misc1`, `md_misc2`, `md_misc3`, `md_misc4`) VALUES
(197, 24, 'FC-005', 'Islamic Monotheism', 'التوحيد', '1774097162', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(198, 24, 'FC-007', 'Islamic History', 'التاريخ الإسلامي', '1774097185', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(199, 25, 'JS-011', 'Jurisprudence of Rituals', 'فقه العبادات', '1774097209', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(200, 26, 'PT-013', 'Traditions of the Prophet', 'الحديث', '1774097230', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(201, 27, 'QS-015', 'Quran Recitation and its Rules', 'التلاوة والتجويد', '1774097252', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(202, 27, 'QS-016', 'Quran Memorization & Exegesis', 'الحفظ والتفسير', '1774363346', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(203, 27, 'QS-017', 'Dictation & Calligraphy', 'الإملاء والخط', '1774097297', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(204, 28, 'AR-001', 'Rhetoric', 'البلاغة', '1772949062', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(205, 28, 'AR-002', 'Arabic Literature', 'الأدب العربي', '1772949110', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(206, 28, 'AR-003', 'Composition & Comprehension', 'الإنشاء والمطالعة', '1772949144', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(207, 28, 'AR-004', 'Grammar & Morphology', 'النحو والصرف', '1772949167', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(208, 29, 'FC-005', 'Islamic monotheism', 'التوحيد', '1772949213', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(209, 29, 'FC-006', 'Religions &sects', 'الأديان والفرق', '1772949289', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(210, 29, 'FC-007', 'Islamic History', 'التاريخ الإسلامي', '1772949364', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(211, 30, 'JS-009', 'Sources of Jurisprudence', 'أصول الفقه', '1772949432', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(212, 30, 'JS-008', 'Inheritance', 'الفرائض', '1772949396', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(213, 30, 'JS-010', 'Islamic Family Law', 'فقه الأحوال الشخصية', '1772949463', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(214, 31, 'PT-012', 'Sources of Prophetic Traditions', 'أصول الحديث', '1772949496', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(215, 31, 'PT-013', 'Traditions of the Prophet', 'الحديث', '1772949538', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(216, 32, 'QS-014', 'Sources of Exegesis', 'أصول التفسير', '1772949571', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(217, 32, 'QS-015', 'Quran Recitation & Its Rules', 'التلاوة والتجويد', '1772949611', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(218, 32, 'QS-016', 'Quran Memorization & Exegesis', 'الحفظ والتفسير', '1772949658', '1', NULL, NULL, NULL, NULL, NULL, NULL);




