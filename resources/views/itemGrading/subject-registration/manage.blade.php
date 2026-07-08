@extends('layouts-side-bar.master')

@section('content')
    <div class="side-app">
        <div class="container-fluid mt-3">

            <style>
                .sr-table-wrap {
                    overflow-x: auto;
                    max-width: 100%;
                }

                .sr-table {
                    border-collapse: separate;
                    border-spacing: 0;
                    font-size: 0.85rem;
                    white-space: nowrap;
                }

                .sr-table th,
                .sr-table td {
                    padding: 8px 10px;
                    border: 1px solid #e8e8e8;
                    text-align: center;
                    vertical-align: middle;
                }

                .sr-table thead th {
                    background: #9d1a68;
                    color: white;
                    position: sticky;
                    top: 0;
                    z-index: 2;
                }

                .sr-table th.subject-col {
                    min-width: 90px;
                    max-width: 120px;
                    white-space: normal;
                }

                .sr-table th.subject-compulsory {
                    background: #6a123f;
                }

                .sr-table td.sticky-col,
                .sr-table th.sticky-col {
                    position: sticky;
                    left: 0;
                    background: #fff;
                    z-index: 1;
                    text-align: left;
                }

                .sr-table thead th.sticky-col {
                    background: #9d1a68;
                    z-index: 3;
                }

                .sr-table tbody tr:nth-child(even) td.sticky-col {
                    background: #fafafa;
                }

                .subject-check {
                    width: 18px;
                    height: 18px;
                    cursor: pointer;
                }

                .subject-check:disabled {
                    opacity: 0.7;
                    cursor: not-allowed;
                }

                .compulsory-tag {
                    font-size: 0.65rem;
                    display: block;
                    opacity: 0.85;
                }
            </style>

            <div class="card shadow-lg border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center flex-wrap gap-2"
                    style="background-color:#9d1a68;">
                    <h4 class="mb-0">
                        <i class="fa fa-list-check me-2"></i>
                        {{ $category }} Subject Registration — {{ $schoolNumber }} ({{ $schoolName }}) — {{ $year }}
                    </h4>
                    <span class="badge bg-light text-dark">
                        <i class="fa fa-users me-1"></i> {{ $students->count() }} Students
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

                    {{-- Toolbar: download template / import filled sheet --}}
                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                        <div class="text-muted small">
                            <i class="fa fa-circle" style="color:#6a123f;font-size:8px;"></i> Compulsory (auto-registered) &nbsp;
                            <i class="fa fa-square" style="color:#9d1a68;font-size:8px;"></i> Optional (tick what each student sat)
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-outline-dark btn-sm"
                                href="{{ route('subject.registration.template', ['year' => $year, 'category' => $category, 'school_number' => $schoolNumber]) }}">
                                <i class="fa fa-download me-1"></i> Download Excel Template
                            </a>

                            <button type="button" class="btn btn-sm text-white" style="background-color:#9d1a68;"
                                data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fa fa-upload me-1"></i> Import Filled Template
                            </button>
                        </div>
                    </div>

                    @if ($students->count() > 0)
                        <div class="sr-table-wrap">
                            <table class="sr-table">
                                <thead>
                                    <tr>
                                        <th class="sticky-col" style="left:0;">#</th>
                                        <th class="sticky-col" style="left:40px;">Student_ID</th>
                                        <th class="sticky-col" style="left:180px;">Name</th>
                                        @foreach ($subjects as $subject)
                                            <th class="subject-col {{ $subject->md_misc1 === 'Compulsory' ? 'subject-compulsory' : '' }}">
                                                {{ $subject->md_name }}
                                                <span class="compulsory-tag">{{ $subject->md_misc1 }}</span>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $index => $student)
                                        @php
                                            $studentId = $student->Student_ID;
                                            $registeredIds = $registrations->get($studentId, collect());
                                        @endphp
                                        <tr>
                                            <td class="sticky-col" style="left:0;">{{ $index + 1 }}</td>
                                            <td class="sticky-col" style="left:40px;">{{ $studentId }}</td>
                                            <td class="sticky-col" style="left:180px;">{{ $names[$studentId] ?? '—' }}</td>
                                            @foreach ($subjects as $subject)
                                                @php $isCompulsory = $subject->md_misc1 === 'Compulsory'; @endphp
                                                <td>
                                                    <input type="checkbox" class="subject-check"
                                                        data-student="{{ $studentId }}"
                                                        data-subject="{{ $subject->md_id }}"
                                                        {{ $registeredIds->has($subject->md_id) ? 'checked' : '' }}
                                                        {{ $isCompulsory ? 'disabled' : '' }}>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-danger text-center">
                            <i class="fa fa-exclamation-triangle me-2"></i> No students found for this school/year/category.
                            Make sure students have been registered first.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    {{-- Import Modal --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('subject.registration.import') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="year" value="{{ $year }}">
                    <input type="hidden" name="category" value="{{ $category }}">
                    <input type="hidden" name="school_number" value="{{ $schoolNumber }}">

                    <div class="modal-header text-white" style="background-color:#9d1a68;">
                        <h5 class="modal-title"><i class="fa fa-upload me-2"></i> Import Subject Registrations</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small">
                            Upload the same Excel file you downloaded, with each student's optional subjects
                            marked <strong>YES</strong>. Compulsory subjects are registered automatically no
                            matter what the sheet says.
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
        $(document).ready(function () {
            $(document).on('change', '.subject-check', function () {
                const checkbox = $(this);
                const checked = checkbox.is(':checked');

                $.ajax({
                    url: '{{ route('subject.registration.toggle') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        student_id: checkbox.data('student'),
                        subject_id: checkbox.data('subject'),
                        year: '{{ $year }}',
                        category: '{{ $category }}',
                        checked: checked ? 1 : 0,
                    },
                    error: function (xhr) {
                        checkbox.prop('checked', !checked); // revert on failure
                        Swal.fire({
                            icon: 'error',
                            title: 'Could not update',
                            text: xhr.responseJSON?.message || 'Please try again.',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            });

            document.querySelector('#importModal form').addEventListener('submit', function () {
                Swal.fire({
                    title: 'Importing…',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => Swal.showLoading()
                });
            });
        });
    </script>
@endsection