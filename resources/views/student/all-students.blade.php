<?php
use App\Http\Controllers\Helper;
?>
@extends('layouts-side-bar.master')
@section('content')

<style>
    .filter-action-btn {
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
    padding: .5rem .6rem;
}

@media (max-width: 1200px) and (min-width: 768px) {
    /* Laptop range where col-md-2 gets tight — let the button row take full width */
    .card-body form .row > div.d-flex {
        flex: 0 0 100%;
        max-width: 100%;
        margin-top: .5rem;
    }
}

@media (max-width: 575px) {
    .filter-action-btn {
        font-size: .8rem;
    }
}
</style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mt-5">

                    <div class="card-header  text-white d-flex justify-content-between align-items-center"
                        style="background-color: #026837;">
                        <h3 class="card-title">All Students</h3>
                        <a href="{{ route('students.add.new.student') }}" class="btn btn-sm" style="background-color: #287C44;">
                            <span
                                class="rounded-circle bg-white d-inline-flex align-items-center justify-content-center me-1"
                                style="width: 20px; height: 20px;">
                                <i class="fas fa-plus" style="font-size: 12px;"></i>
                            </span>
                            <span class="text-white">Add Student</span>
                        </a>
                    </div>

                 <div class="card-body">
    <!-- Filter Form -->
    <form method="GET" action="{{ route('students.all.students') }}" class="mb-4">
        <div class="row g-3 align-items-end">

            <!-- House (larger) -->
            <div class="col-12 col-md-6">
                <label for="house_id" class="form-label">Filter by School:</label>
                <select name="house_id" id="house_id" class="form-control select2">
                    <option value="">All Houses</option>
                    @foreach ($houses as $house)
                        <option value="{{ $house->ID }}"
                            {{ request('house_id') == $house->ID ? 'selected' : '' }}>
                            {{ $house->House }} - {{ $house->House_AR ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Year -->
            <div class="col-12 col-md-2">
                <label for="year" class="form-label">Filter by Year:</label>
                <select name="year" id="year" class="form-control select2">
                    <option value="">-- Select Year --</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->year_en }}" {{ request('year') == $year->year_en ? 'selected' : '' }}>
                            {{ $year->year_en }} - {{ $year->year_ar }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Type -->
            <div class="col-12 col-md-2">
                <label for="type" class="form-label">Filter by Type:</label>
                <select name="type" id="type" class="form-control select2">
                    <option value="">All Types</option>
                    <option value="uce" {{ request('type') == 'uce' ? 'selected' : '' }}>
                        O-LEVEL (UCE)
                    </option>
                    <option value="uace" {{ request('type') == 'uace' ? 'selected' : '' }}>
                        A-LEVEL (UACE)
                    </option>
                    <!-- <option value="ple" {{ request('type') == 'ple' ? 'selected' : '' }}>
                        Primary (PLE)
                    </option> -->
                </select>
            </div>

<div class="col-12 col-md-2 d-flex" style="gap: 0.25rem;">
    <button type="submit" class="btn btn-primary flex-fill filter-action-btn">
        <i class="fas fa-filter me-1"></i> Filter
    </button>

    <a href="{{ route('students.all.students') }}" class="btn btn-secondary flex-fill filter-action-btn">
        <i class="fas fa-undo me-1"></i> Reset
    </a>
</div>

        </div>
    </form>

    <!-- Students Table -->
    @if (request()->anyFilled(['house_id', 'year', 'type']))
        <div class="alert mb-3 text-white rounded-0" style="background-color: #287C44;">
            <strong>Active Filters : </strong>

            @if (request('house_id'))
                @php
                    $selectedHouse = $houses->firstWhere('ID', request('house_id'));
                @endphp
                <span class="badge mr-2 rounded-0" style="background-color: #026837;">
                    School: {{ $selectedHouse->House ?? '' }}
                </span>
            @endif

            @if (request('year'))
                <span class="badge mr-2 rounded-0" style="background-color: #026837;">
                    Year: {{ request('year') }}
                </span>
            @endif

            @if (request('type'))
                <span class="badge mr-2 rounded-0" style="background-color: #026837;">
                    Category: {{ request('type') === 'ple' ? 'Primary (PLE)' : ucfirst(request('type')) }}
                </span>
            @endif

            <a href="{{ route('students.all.students') }}" class="float-right text-white">
                Clear all filters
            </a>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Student ID</th>
                    <th class="text-center">Student Name</th>
                    <th class="text-center">School</th>
                    <th class="text-center">Admission Year</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $index => $student)
                    <tr>
                                                <td>{{ $students->firstItem() + $index }}</td>

                        <td>{{ $student->Student_ID }}</td>
                        <td>{{ $student->Student_Name }}</td>
                        <td>{{ $student->House }}</td>
                        <td>{{ $student->EntryDate }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info view-student-details"
                                data-toggle="modal" data-target="#studentDetailsModal"
                                data-student-id="{{ $student->Student_ID }}"
                                data-student-name="{{ $student->Student_Name }}"
                                data-student-name-ar="{{ $student->Student_Name_AR }}"
                                data-student-sex="{{ $student->StudentSex }}"
                                data-student-sex-ar="{{ $student->StudentSex_AR }}"
                                data-date-of-birth="{{ $student->Date_of_Birth }}"
                                data-date-of-birth-ar="{{ $student->Date_of_Birth_AR }}"
                                data-house="{{ $student->House }}" data-class="{{ $student->Class }}"
                                data-class-ar="{{ $student->Class_AR }}"
                                data-section="{{ $student->Section }}"
                                data-admission-no="{{ $student->admnno }}"
                                data-admission-year="{{ $student->admnyr }}"
                                data-entry-date="{{ $student->EntryDate }}"
                                data-state="{{ $student->state }}"
                                data-district="{{ $student->District }}"
                                data-district-ar="{{ $student->District_AR }}"
                                data-fathers-contact="{{ $student->Fatherscontact }}"
                                data-mothers-contact="{{ $student->MothersContact }}"
                                data-guardians-contact="{{ $student->GuardiansContact }}"
                                data-students-address="{{ $student->StudentsAddress }}"
                                data-fathers-address="{{ $student->FathersAddress }}"
                                data-mothers-address="{{ $student->MothersAddress }}"
                                data-father-status="{{ $student->FatherStatus }}"
                                data-mother-status="{{ $student->MotherStatus }}"
                                data-is-orphan="{{ $student->IsOrphan }}"
                                data-guardian-name="{{ $student->GuardianName }}"
                                data-guardian-relationship="{{ $student->GuardianRelationship }}"
                                data-guardians-job="{{ $student->GuardiansJob }}"
                                data-disabilities="{{ $student->Disabilities }}"
                                data-chronic-diseases="{{ $student->ChronicleDiseases }}"
                                data-student-nationality="{{ $student->StudentsNationality }}"
                                data-student-citizenship="{{ $student->StudentsCitizenship }}"
                                data-father-nationality="{{ $student->FathersNationality }}"
                                data-father-citizenship="{{ $student->FathersCitizenship }}"
                                data-mother-nationality="{{ $student->MothersNationality }}"
                                data-mother-citizenship="{{ $student->MothersCitizenship }}"
                                data-guardian-nationality="{{ $student->GuardiansNationality }}"
                                data-guardian-citizenship="{{ $student->GuardiansCitizenship }}"
                                @if ($student->house) data-house-name="{{ $student->house->House }}"
                                data-house-location="{{ $student->house->Location }}"
                                data-house-number="{{ $student->house->Number }}" @endif>
                                <i class="fa fa-eye"></i> View Details
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No students found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $students->links() }}
    </div>

    <div class="d-flex justify-content-between align-items-center mt-2">
        <div>
            <small>Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of
                {{ $students->total() }} students</small>
        </div>
        <div>
            <small>Page {{ $students->currentPage() }} of {{ $students->lastPage() }}</small>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Single Modal for all students -->
    <div class="modal fade" id="studentDetailsModal" tabindex="-1" role="dialog"
        aria-labelledby="studentDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentDetailsModalLabel">Student Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="studentModalContent">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        // Auto-submit form when dropdown changes
        document.getElementById('house_id').addEventListener('change', function() {
            this.form.submit();
        });

        document.getElementById('year').addEventListener('change', function() {
            this.form.submit();
        });

        document.getElementById('type').addEventListener('change', function() {
            this.form.submit();
        });

        // Optional: Add confirmation before reset
        document.querySelector('a.btn-secondary').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "This will reset all filters!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = this.href;
                }
            });
        });

        // Handle student details modal
        $(document).ready(function() {
            $('.view-student-details').on('click', function() {
                var data = $(this).data();

                // Helper function to format date
                function formatDate(dateString) {
                    if (!dateString) return 'N/A';
                    var date = new Date(dateString);
                    return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
                }

                // Helper function to format value with fallback
                function formatValue(value) {
                    return value || 'N/A';
                }

                // Build modal content
                var modalContent = `
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 40%" class="text-dark">Student ID:</th>
                                        <td>${formatValue(data.studentId)}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark">Student Name:</th>
                                        <td>${formatValue(data.studentName)}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark">Student Name (AR):</th>
                                        <td>${formatValue(data.studentNameAr)}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark">Date of Birth:</th>
                                        <td>${data.dateOfBirth ? formatDate(data.dateOfBirth) : 'N/A'}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark">Date of Birth (AR):</th>
                                        <td>${formatValue(data.dateOfBirthAr)}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark">Gender:</th>
                                        <td>${formatValue(data.studentSex)} / ${formatValue(data.studentSexAr)}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark">School:</th>
                                        <td>${formatValue(data.house)}</td>
                                    </tr>
                                    ${data.houseName ? `
                                        <tr>
                                            <th class="text-dark">House Details:</th>
                                            <td>
                                                <strong>Name:</strong> ${formatValue(data.houseName)}<br>
                                                <strong>Location:</strong> ${formatValue(data.houseLocation)}<br>
                                                <strong>Number:</strong> ${formatValue(data.houseNumber)}
                                            </td>
                                        </tr>
                                        ` : ''}
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="text-dark" style="width: 40%">Class:</th>
                                        <td>${formatValue(data.class)} / ${formatValue(data.classAr)}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark">Section:</th>
                                        <td>${formatValue(data.section)}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark">Admission No:</th>
                                        <td>${formatValue(data.admissionNo)}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark">Admission Year:</th>
                                        <td>${formatValue(data.admissionYear)}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark">Entry Date:</th>
                                        <td>${data.entryDate ? formatDate(data.entryDate) : 'N/A'}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark">Status:</th>
                                        <td>
                                            <span class="badge badge-${data.state == 'Active' ? 'success' : 'danger'}">
                                                ${formatValue(data.state)}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark">District:</th>
                                        <td>${formatValue(data.district)} / ${formatValue(data.districtAr)}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Contact Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Father's Contact:</strong><br>
                                                ${formatValue(data.fathersContact)}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Mother's Contact:</strong><br>
                                                ${formatValue(data.mothersContact)}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Guardian's Contact:</strong><br>
                                                ${formatValue(data.guardiansContact)}
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4">
                                                <strong>Student's Address:</strong><br>
                                                ${formatValue(data.studentsAddress)}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Father's Address:</strong><br>
                                                ${formatValue(data.fathersAddress)}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Mother's Address:</strong><br>
                                                ${formatValue(data.mothersAddress)}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Parent/Guardian Information -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Parent/Guardian Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Father's Status:</strong><br>
                                                ${formatValue(data.fatherStatus)}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Mother's Status:</strong><br>
                                                ${formatValue(data.motherStatus)}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Is Orphan:</strong><br>
                                                ${formatValue(data.isOrphan)}
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4">
                                                <strong>Guardian Name:</strong><br>
                                                ${formatValue(data.guardianName)}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Guardian Relationship:</strong><br>
                                                ${formatValue(data.guardianRelationship)}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Guardian's Job:</strong><br>
                                                ${formatValue(data.guardiansJob)}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medical Information -->
                        ${(data.disabilities || data.chronicDiseases) ? `
                                                                                                <div class="row mt-3">
                                                                                                    <div class="col-12">
                                                                                                        <div class="card">
                                                                                                            <div class="card-header">
                                                                                                                <h6>Medical Information</h6>
                                                                                                            </div>
                                                                                                            <div class="card-body">
                                                                                                                ${data.disabilities ? `<p><strong>Disabilities:</strong> ${data.disabilities}</p>` : ''}
                                                                                                                ${data.chronicDiseases ? `<p><strong>Chronic Diseases:</strong> ${data.chronicDiseases}</p>` : ''}
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                ` : ''}

                        <!-- Nationality/Citizenship Information -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Nationality & Citizenship</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <strong>Student:</strong><br>
                                                ${formatValue(data.studentNationality)} / ${formatValue(data.studentCitizenship)}
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Father:</strong><br>
                                                ${formatValue(data.fatherNationality)} / ${formatValue(data.fatherCitizenship)}
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Mother:</strong><br>
                                                ${formatValue(data.motherNationality)} / ${formatValue(data.motherCitizenship)}
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Guardian:</strong><br>
                                                ${formatValue(data.guardianNationality)} / ${formatValue(data.guardianCitizenship)}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                // Update modal content
                $('#studentModalContent').html(modalContent);

                // Update modal title with student name
                $('#studentDetailsModalLabel').text('Student Details: ' + formatValue(data.studentName));
            });
        });
    </script>
@endsection
