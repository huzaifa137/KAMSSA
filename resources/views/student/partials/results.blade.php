<?php
use App\Http\Controllers\Helper;
?>

@if ($students->isEmpty())
    <p class="text-danger">No students found.</p>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width:1px;">No.</th>
                <th>Photo</th>
                <th>Admission No</th>
                <th>Name</th>
                <th>Name (AR)</th>
                <th>School</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $count => $student)
                <tr>
                    <td>{{ $count + 1 }}</td>

                    {{-- Student Photo --}}
                    <td class="text-center">
                        @php
                            $photoPath = public_path('assets/student_photos/' . $student->Student_ID . '.jpg');
                            $photoUrl = asset('assets/student_photos/' . $student->Student_ID . '.jpg');
                        @endphp

                        @if(file_exists($photoPath))
                            <img src="{{ $photoUrl }}?v={{ time() }}" alt="Student Photo" style="
                                width: 50px;
                                height: 50px;
                                object-fit: cover;
                                border-radius: 50%;
                                border: 2px solid #c51619;
                                box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                            ">
                        @else
                            <i class="fas fa-user-circle" style="font-size: 45px; color: #b5b5b5;"></i>
                        @endif
                    </td>

                    <td>{{ $student->Student_ID }}</td>
                    <td>{{ $student->Student_Name }}</td>
                    <td>{{ $student->Student_Name_AR }}</td>
                    <td>{{ $student->House }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm view-student-details mr-1" data-toggle="modal"
                            style="background-color:#c51619;color:#FFF;" data-target="#studentDetailsModal"
                            data-student-id="{{ $student->Student_ID }}" data-student-name="{{ $student->Student_Name }}"
                            data-student-name-ar="{{ $student->Student_Name_AR }}" data-student-sex="{{ $student->StudentSex }}"
                            data-student-sex-ar="{{ $student->StudentSex_AR }}"
                            data-date-of-birth="{{ $student->Date_of_Birth }}"
                            data-date-of-birth-ar="{{ $student->Date_of_Birth_AR }}" data-house="{{ $student->House }}"
                            data-class="{{ $student->Class }}" data-class-ar="{{ $student->Class_AR }}"
                            data-section="{{ $student->Section }}" data-admission-no="{{ $student->admnno }}"
                            data-admission-year="{{ $student->admnyr }}" data-entry-date="{{ $student->EntryDate }}"
                            data-state="{{ $student->state }}" data-district="{{ $student->District }}"
                            data-district-ar="{{ $student->District_AR }}" data-fathers-contact="{{ $student->Fatherscontact }}"
                            data-mothers-contact="{{ $student->MothersContact }}"
                            data-guardians-contact="{{ $student->GuardiansContact }}"
                            data-students-address="{{ $student->StudentsAddress }}"
                            data-fathers-address="{{ $student->FathersAddress }}"
                            data-mothers-address="{{ $student->MothersAddress }}"
                            data-father-status="{{ $student->FatherStatus }}" data-mother-status="{{ $student->MotherStatus }}"
                            data-is-orphan="{{ $student->IsOrphan }}" data-guardian-name="{{ $student->GuardianName }}"
                            data-guardian-relationship="{{ $student->GuardianRelationship }}"
                            data-guardians-job="{{ $student->GuardiansJob }}" data-disabilities="{{ $student->Disabilities }}"
                            data-chronic-diseases="{{ $student->ChronicleDiseases }}"
                            data-student-nationality="{{ $student->StudentsNationality }}"
                            data-student-citizenship="{{ $student->StudentsCitizenship }}"
                            data-father-nationality="{{ $student->FathersNationality }}"
                            data-father-citizenship="{{ $student->FathersCitizenship }}"
                            data-mother-nationality="{{ $student->MothersNationality }}"
                            data-mother-citizenship="{{ $student->MothersCitizenship }}"
                            data-guardian-nationality="{{ $student->GuardiansNationality }}"
                            data-guardian-citizenship="{{ $student->GuardiansCitizenship }}"
                            data-birth-place="{{ $student->Birth_Place }}" data-birth-place-ar="{{ $student->Birth_Place_AR }}"
                            data-mothers-job="{{ $student->MothersJob }}">
                            <i class="fa fa-eye"></i> View
                        </button>
                        <button type="button" class="btn btn-sm btn-primary edit-student-details" data-toggle="modal"
                            data-target="#editStudentModal" data-student-id="{{ $student->Student_ID }}"
                            data-student-name="{{ $student->Student_Name }}"
                            data-student-name-ar="{{ $student->Student_Name_AR }}" data-student-sex="{{ $student->StudentSex }}"
                            data-student-sex-ar="{{ $student->StudentSex_AR }}"
                            data-date-of-birth="{{ $student->Date_of_Birth }}"
                            data-date-of-birth-ar="{{ $student->Date_of_Birth_AR }}" data-house="{{ $student->House }}"
                            data-class="{{ $student->Class }}" data-class-ar="{{ $student->Class_AR }}"
                            data-section="{{ $student->Section }}" data-admission-no="{{ $student->admnno }}"
                            data-admission-year="{{ $student->admnyr }}" data-entry-date="{{ $student->EntryDate }}"
                            data-state="{{ $student->state }}" data-district="{{ $student->District }}"
                            data-district-ar="{{ $student->District_AR }}" data-fathers-contact="{{ $student->Fatherscontact }}"
                            data-mothers-contact="{{ $student->MothersContact }}"
                            data-guardians-contact="{{ $student->GuardiansContact }}"
                            data-students-address="{{ $student->StudentsAddress }}"
                            data-fathers-address="{{ $student->FathersAddress }}"
                            data-mothers-address="{{ $student->MothersAddress }}"
                            data-father-status="{{ $student->FatherStatus }}" data-mother-status="{{ $student->MotherStatus }}"
                            data-is-orphan="{{ $student->IsOrphan }}" data-guardian-name="{{ $student->GuardianName }}"
                            data-guardian-relationship="{{ $student->GuardianRelationship }}"
                            data-guardians-job="{{ $student->GuardiansJob }}" data-disabilities="{{ $student->Disabilities }}"
                            data-chronic-diseases="{{ $student->ChronicleDiseases }}"
                            data-student-nationality="{{ $student->StudentsNationality }}"
                            data-student-citizenship="{{ $student->StudentsCitizenship }}"
                            data-father-nationality="{{ $student->FathersNationality }}"
                            data-father-citizenship="{{ $student->FathersCitizenship }}"
                            data-mother-nationality="{{ $student->MothersNationality }}"
                            data-mother-citizenship="{{ $student->MothersCitizenship }}"
                            data-guardian-nationality="{{ $student->GuardiansNationality }}"
                            data-guardian-citizenship="{{ $student->GuardiansCitizenship }}"
                            data-birth-place="{{ $student->Birth_Place }}" data-birth-place-ar="{{ $student->Birth_Place_AR }}"
                            data-mothers-job="{{ $student->MothersJob }}">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- View Student Details Modal -->
    <div class="modal fade" id="studentDetailsModal" tabindex="-1" role="dialog" aria-labelledby="studentDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #026837 0%, #026837 100%);">
                    <h5 class="modal-title" id="studentDetailsModalLabel">
                        <i class="fas fa-user-graduate mr-2"></i> Student Details
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="studentModalContent">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #c51619 0%, #c51619 100%);">
                    <h5 class="modal-title" id="editStudentModalLabel">
                        <i class="fas fa-edit mr-2"></i> Edit Student
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editStudentForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="edit_student_id" name="student_id">

                        <!-- Student Photo Section -->
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <img id="editPhotoPreview" src="" alt="Student Photo"
                                    style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 3px solid #c51619; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            </div>
                            <div class="custom-file" style="max-width: 250px; margin: 0 auto;">
                                <input type="file" class="custom-file-input" id="editPhoto" name="photo" accept="image/*">
                                <label class="custom-file-label" for="editPhoto">Choose new photo</label>
                            </div>
                            <small class="text-muted">Leave empty to keep current photo</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Basic Info -->
                                <div class="form-group">
                                    <label>Student Name</label>
                                    <input type="text" name="student_name" id="edit_student_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Student Name (AR)</label>
                                    <input type="text" name="student_name_ar" id="edit_student_name_ar"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="student_sex" id="edit_student_sex" class="form-control">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" name="date_of_birth" id="edit_date_of_birth" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Birth Place</label>
                                    <input type="text" name="birth_place" id="edit_birth_place" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Birth Place (AR)</label>
                                    <input type="text" name="birth_place_ar" id="edit_birth_place_ar" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Academic Info -->
                                <div class="form-group">
                                    <label>Class</label>
                                    <input type="text" name="class" id="edit_class" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Section</label>
                                    <input type="text" name="section" id="edit_section" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>House</label>
                                    <input type="text" name="house" id="edit_house" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>District</label>
                                    <input type="text" name="district" id="edit_district" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>District (AR)</label>
                                    <input type="text" name="district_ar" id="edit_district_ar" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="text-muted">Contact Information</h6>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Father's Contact</label>
                                    <input type="text" name="fathers_contact" id="edit_fathers_contact"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mother's Contact</label>
                                    <input type="text" name="mothers_contact" id="edit_mothers_contact"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Guardian's Contact</label>
                                    <input type="text" name="guardians_contact" id="edit_guardians_contact"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Guardian Information -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="text-muted">Guardian Information</h6>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Guardian Name</label>
                                    <input type="text" name="guardian_name" id="edit_guardian_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Guardian Relationship</label>
                                    <input type="text" name="guardian_relationship" id="edit_guardian_relationship"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Guardian's Job</label>
                                    <input type="text" name="guardians_job" id="edit_guardians_job" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="text-muted">Additional Information</h6>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Disabilities</label>
                                    <textarea name="disabilities" id="edit_disabilities" class="form-control"
                                        rows="2"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Chronic Diseases</label>
                                    <textarea name="chronic_diseases" id="edit_chronic_diseases" class="form-control"
                                        rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn text-white" style="background-color:#c51619;">
                            <i class="fas fa-save mr-1"></i> Update Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .swal2-container {
            z-index: 99999 !important;
        }

        .modal-body .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .modal-body .card-header {
            background: linear-gradient(135deg, #026837 0%, #026837 100%);
            color: white;
            font-weight: 600;
            padding: 10px 15px;
        }

        .modal-body .card-header h6 {
            margin: 0;
            font-size: 14px;
        }

        .modal-body table th {
            background-color: #fff;
            color: #424e79 !important;
            font-weight: 600;
        }

        .modal-body .badge-success {
            background-color: #28a745;
        }

        .modal-body .badge-danger {
            background-color: #dc3545;
        }

        .custom-file-label::after {
            content: "Browse";
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Handle view student details
            $(document).on('click', '.view-student-details', function () {
                var data = $(this).data();

                // Helper function to format date
                function formatDate(dateString) {
                    if (!dateString) return 'N/A';
                    var date = new Date(dateString);
                    if (isNaN(date.getTime())) return dateString;
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    return (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + year;
                }

                function formatValue(value) {
                    return value || 'N/A';
                }

                function getStudentPhoto(studentId) {
                    var photoUrl = '/assets/student_photos/' + studentId + '.jpg';
                    var timestamp = new Date().getTime();
                    var photoWithTimestamp = photoUrl + '?v=' + timestamp;

                    return new Promise(function (resolve) {
                        var img = new Image();
                        img.onload = function () {
                            resolve(`
                                        <div class="student-avatar mb-3">
                                            <img src="${photoWithTimestamp}" alt="Student Photo" 
                                                style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid #026837; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                                        </div>
                                    `);
                        };
                        img.onerror = function () {
                            resolve(`
                                        <div class="student-avatar mb-3">
                                            <i class="fas fa-user-circle fa-5x" style="color: #026837;"></i>
                                        </div>
                                    `);
                        };
                        img.src = photoWithTimestamp;
                    });
                }

                getStudentPhoto(data.studentId).then(function (photoHtml) {
                    var modalContent = `
                                <div class="student-profile">
                                    <div class="text-center mb-4">
                                        ${photoHtml}
                                        <h4 class="font-weight-bold">${formatValue(data.studentName)}</h4>
                                        <p class="text-muted mb-1">${formatValue(data.studentNameAr)}</p>
                                        <span class="badge badge-${data.state == 'Active' ? 'success' : 'danger'} badge-lg">
                                            ${formatValue(data.state)}
                                        </span>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <h6><i class="fas fa-info-circle mr-2"></i>Basic Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-bordered table-sm">
                                                        <tr><th style="width: 40%">Student ID:</th><td><strong>${formatValue(data.studentId)}</strong></td></tr>
                                                        <tr><th>Date of Birth:</th><td>${formatDate(data.dateOfBirth)}</td></tr>
                                                        <tr><th>Date of Birth (AR):</th><td>${formatValue(data.dateOfBirthAr)}</td></tr>
                                                        <tr><th>Gender:</th><td>${formatValue(data.studentSex)} / ${formatValue(data.studentSexAr)}</td></tr>
                                                        <tr><th>Birth Place:</th><td>${formatValue(data.birthPlace)} / ${formatValue(data.birthPlaceAr)}</td></tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-bordered table-sm">
                                                        <tr><th style="width: 40%">Class:</th><td>${formatValue(data.class)} / ${formatValue(data.classAr)}</td></tr>
                                                        <tr><th>Section:</th><td>${formatValue(data.section)}</td></tr>
                                                        <tr><th>House:</th><td><strong>${formatValue(data.house)}</strong></td></tr>
                                                        <tr><th>District:</th><td>${formatValue(data.district)} / ${formatValue(data.districtAr)}</td></tr>
                                                        <tr><th>Entry Date:</th><td>${formatDate(data.entryDate)}</td></tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header"><h6><i class="fas fa-id-card mr-2"></i>Admission Information</h6></div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4"><p><strong>Admission No:</strong><br>${formatValue(data.admissionNo)}</p></div>
                                                <div class="col-md-4"><p><strong>Admission Year:</strong><br>${formatValue(data.admissionYear)}</p></div>
                                                <div class="col-md-4"><p><strong>Status:</strong><br><span class="badge badge-${data.state == 'Active' ? 'success' : 'danger'}">${formatValue(data.state)}</span></p></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header"><h6><i class="fas fa-address-book mr-2"></i>Contact Information</h6></div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4"><p><strong>Father's Contact:</strong><br>${formatValue(data.fathersContact)}</p></div>
                                                <div class="col-md-4"><p><strong>Mother's Contact:</strong><br>${formatValue(data.mothersContact)}</p></div>
                                                <div class="col-md-4"><p><strong>Guardian's Contact:</strong><br>${formatValue(data.guardiansContact)}</p></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                    $('#studentModalContent').html(modalContent);
                    $('#studentDetailsModalLabel').html(`<i class="fas fa-user-graduate mr-2"></i> Student Details: ${formatValue(data.studentName)}`);
                });
            });

            // Handle edit student details
            $(document).on('click', '.edit-student-details', function () {
                var data = $(this).data();

                // Populate form fields
                $('#edit_student_id').val(data.studentId);
                $('#edit_student_name').val(data.studentName);
                $('#edit_student_name_ar').val(data.studentNameAr);
                $('#edit_student_sex').val(data.studentSex);
                $('#edit_date_of_birth').val(data.dateOfBirth);
                $('#edit_birth_place').val(data.birthPlace);
                $('#edit_birth_place_ar').val(data.birthPlaceAr);
                $('#edit_class').val(data.class);
                $('#edit_section').val(data.section);
                $('#edit_house').val(data.house);
                $('#edit_district').val(data.district);
                $('#edit_district_ar').val(data.districtAr);
                $('#edit_fathers_contact').val(data.fathersContact);
                $('#edit_mothers_contact').val(data.mothersContact);
                $('#edit_guardians_contact').val(data.guardiansContact);
                $('#edit_guardian_name').val(data.guardianName);
                $('#edit_guardian_relationship').val(data.guardianRelationship);
                $('#edit_guardians_job').val(data.guardiansJob);
                $('#edit_disabilities').val(data.disabilities);
                $('#edit_chronic_diseases').val(data.chronicDiseases);

                // Set photo preview
                var photoUrl = '/assets/student_photos/' + data.studentId + '.jpg';
                var timestamp = new Date().getTime();
                var img = new Image();
                img.onload = function () {
                    $('#editPhotoPreview').attr('src', photoUrl + '?v=' + timestamp);
                };
                img.onerror = function () {
                    $('#editPhotoPreview').attr('src', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDE1MCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjE1MCIgaGVpZ2h0PSIxNTAiIGZpbGw9IiNFOUVDRUYiLz48dGV4dCB4PSI3NSIgeT0iNzUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGRvbWluYW50LWJhc2VsaW5lPSJtaWRkbGUiIGZpbGw9IiM2Qzc1N0QiIGZvbnQtc2l6ZT0iMTQiIGZvbnQtZmFtaWx5PSJzYW5zLXNlcmlmIj5ObyBQaG90bzwvdGV4dD48L3N2Zz4=');
                };
                img.src = photoUrl + '?v=' + timestamp;

                // Reset file input
                $('#editPhoto').val('');
                $('.custom-file-label').text('Choose new photo');

                // Update modal title
                $('#editStudentModalLabel').html(`<i class="fas fa-edit mr-2"></i> Edit Student: ${data.studentName}`);
            });

            // Preview new photo before upload
            $('#editPhoto').on('change', function () {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#editPhotoPreview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                    $('.custom-file-label').text(file.name);
                } else {
                    $('.custom-file-label').text('Choose new photo');
                }
            });

            // Handle edit form submission
            $('#editStudentForm').on('submit', function (e) {
                e.preventDefault();

                var studentId = $('#edit_student_id').val();
                var formData = new FormData(this);

                // Show confirmation dialog
                Swal.fire({
                    title: 'Confirm Update',
                    text: 'Are you sure you want to update this student\'s information?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#c51619',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Updating...',
                            text: 'Please wait while we update the student information',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Send AJAX request
                        $.ajax({
                            url: '/students/update/' + studentId,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-HTTP-Method-Override': 'POST'
                            },
                            success: function (response) {
                                // Close the loading alert
                                Swal.close();

                                // Close the edit modal
                                $('#editStudentModal').modal('hide');

                                // Show success toast notification
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer);
                                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                                    }
                                });

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Information updated successfully!'
                                });

                                // Reload the search results after a short delay
                                setTimeout(function () {
                                    location.reload();
                                }, 1500);
                            },
                            error: function (xhr) {
                                Swal.close();

                                var errorMessage = 'An error occurred while updating';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Update Failed',
                                    text: errorMessage,
                                    confirmButtonColor: '#c51619'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endif