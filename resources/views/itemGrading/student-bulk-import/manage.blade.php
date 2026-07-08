@extends('layouts-side-bar.master')

@section('content')
    <div class="side-app">
        <div class="container-fluid mt-3">

            <style>
                .sbi-table th,
                .sbi-table td {
                    padding: 8px 10px;
                    border: 1px solid #e8e8e8;
                    text-align: center;
                    vertical-align: middle;
                }

                .sbi-table thead th {
                    background: #9d1a68;
                    color: white;
                }

                .sbi-table tbody tr:nth-child(even) {
                    background: #fafafa;
                }
            </style>

            <div class="card shadow-lg border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center flex-wrap gap-2"
                    style="background-color:#9d1a68;">
                    <h4 class="mb-0">
                        <i class="fa fa-users me-2"></i>
                        {{ $category }} Student Import — {{ $schoolNumber }} ({{ $schoolName }}) — {{ $year }}
                    </h4>
                    <span class="badge bg-light text-dark">
                        <i class="fa fa-user-graduate me-1"></i> {{ $studentRows->count() }} Students
                    </span>
                </div>

                <div class="card-body">

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            @if (session('success'))
                                Swal.fire({ icon: 'success', title: 'Success!', text: @json(session('success')), confirmButtonColor: '#9d1a68' });
                            @endif

                            @if (session('import_skipped') && count(session('import_skipped')))
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Some rows were skipped',
                                    html: `<ul style="text-align:left;">{!! collect(session('import_skipped'))->map(fn($m) => '<li>' . e($m) . '</li>')->join('') !!}</ul>`,
                                    confirmButtonColor: '#9d1a68'
                                });
                            @endif

                            @if ($errors->any())
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Import Error',
                                    html: `{!! implode('<br>', $errors->all()) !!}`,
                                    confirmButtonColor: '#d33'
                                });
                            @endif
                        });
                    </script>

                    {{-- Toolbar --}}
                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                        <a href="{{ route('student.bulk.import.index') }}" class="btn btn-outline-dark btn-sm">
                            <i class="fa fa-arrow-left me-1"></i> Change Year/Category/School
                        </a>

                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-outline-dark btn-sm"
                                href="{{ route('student.bulk.import.template', ['year' => $year, 'category' => $category, 'school_number' => $schoolNumber]) }}">
                                <i class="fa fa-download me-1"></i> Download Excel Template
                            </a>

                            <button type="button" class="btn btn-sm text-white" style="background-color:#9d1a68;"
                                data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fa fa-upload me-1"></i> Import Students
                            </button>

                            @if ($studentRows->count() > 0)
                                <button type="button" class="btn btn-outline-danger btn-sm" id="clearAllBtn">
                                    <i class="fa fa-trash me-1"></i> Clear All / Start Over
                                </button>
                            @endif

                            @if (in_array($category, ['UCE', 'UACE']) && $studentRows->count() > 0)
                                <a class="btn btn-sm text-white" style="background-color:#6a123f;"
                                    href="{{ route('subject.registration.manage', ['year' => $year, 'category' => $category, 'school_number' => $schoolNumber]) }}">
                                    <i class="fa fa-list-check me-1"></i> Proceed to Subject Registration
                                </a>
                            @endif
                        </div>
                    </div>

                    @if ($studentRows->count() > 0)
                        {{-- Quick search box: filters the table client-side, handy once a
                             school has 100+ imported students. --}}
                        <div class="mb-2">
                            <input type="text" id="sbiSearch" class="form-control form-control-sm"
                                style="max-width:280px;" placeholder="🔍 Search by name or Student_ID...">
                        </div>

                        <div class="table-responsive">
                            <table class="table sbi-table" id="sbiTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student_ID</th>
                                        <th>Name</th>
                                        <th>Sex</th>
                                        <th>Date of Birth</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($studentRows as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->Student_ID }}</td>
                                            <td>{{ $student->Student_Name }}</td>
                                            <td>{{ $student->StudentSex ?? '—' }}</td>
                                            <td>{{ $student->Date_of_Birth ?? '—' }}</td>
                                            <td>
                                                <form method="POST"
                                                    action="{{ route('student.bulk.import.destroy.student', ['studentId' => $student->Student_ID]) }}"
                                                    class="d-inline sbi-delete-form"
                                                    data-student-id="{{ $student->Student_ID }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="year" value="{{ $year }}">
                                                    <input type="hidden" name="category" value="{{ $category }}">
                                                    <input type="hidden" name="school_id" value="{{ $schoolId }}">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        title="Delete this student and all of their records">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fa fa-info-circle me-2"></i> No students imported yet for this school/year/category.
                            Download the template, fill it in, and import it below.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    {{-- Hidden form used to submit the "Clear All" wipe --}}
    <form method="POST" action="{{ route('student.bulk.import.destroy.all') }}" id="clearAllForm" class="d-none">
        @csrf
        @method('DELETE')
        <input type="hidden" name="year" value="{{ $year }}">
        <input type="hidden" name="category" value="{{ $category }}">
        <input type="hidden" name="school_id" value="{{ $schoolId }}">
    </form>

    {{-- Import Modal --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('student.bulk.import.import') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="year" value="{{ $year }}">
                    <input type="hidden" name="category" value="{{ $category }}">
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">

                    <div class="modal-header text-white" style="background-color:#9d1a68;">
                        <h5 class="modal-title"><i class="fa fa-upload me-2"></i> Import Students</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small">
                            Upload the filled-in Excel template. Student Name and Sex are required for each row;
                            everything else is optional. Student_ID is generated automatically, continuing from
                            the last number used for {{ $schoolNumber }}-{{ $category }}-*-{{ $year }}.
                        </p>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" style="background-color:#9d1a68;">
                            <i class="fa fa-check me-1"></i> Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelector('#importModal form').addEventListener('submit', function () {
            Swal.fire({
                title: 'Importing…',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
        });

        // Confirm before deleting a single student (this also removes their
        // subject registrations, marks, and results).
        document.querySelectorAll('.sbi-delete-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const studentId = form.dataset.studentId || 'this student';
                Swal.fire({
                    icon: 'warning',
                    title: 'Delete this student?',
                    html: `This will permanently remove <strong>${studentId}</strong> and all of their subject registrations, marks, and results. This cannot be undone.`,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete',
                    confirmButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Confirm before wiping every student for this year/category/school.
        const clearAllBtn = document.getElementById('clearAllBtn');
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Clear ALL students?',
                    html: `This will permanently delete <strong>every</strong> student imported for {{ $category }} — {{ $schoolNumber }} — {{ $year }}, along with their subject registrations, marks, and results.<br><br>Use this if a template was imported twice or the wrong file was uploaded. This cannot be undone.`,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, clear everything',
                    confirmButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('clearAllForm').submit();
                    }
                });
            });
        }

        // Live search: filters visible rows by Student_ID or Name.
        const sbiSearch = document.getElementById('sbiSearch');
        if (sbiSearch) {
            sbiSearch.addEventListener('input', function () {
                const term = this.value.trim().toLowerCase();
                document.querySelectorAll('#sbiTable tbody tr').forEach(function (row) {
                    const studentId = row.children[1]?.textContent.toLowerCase() || '';
                    const name = row.children[2]?.textContent.toLowerCase() || '';
                    row.style.display = (studentId.includes(term) || name.includes(term)) ? '' : 'none';
                });
            });
        }
    </script>
@endsection