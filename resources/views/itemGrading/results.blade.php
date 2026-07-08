@extends('layouts-side-bar.master')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-p1B9XJvxXlJ0sFh1ExAmH4y3L1kGk+x+r6Gx7q6v5+PgfKhnYzOZ3xGlKEX2eVZCMu1k7r1R7pLLj5p2lP2vXw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content')
    <div class="side-app">
        <div class="container mt-4">

            <style>
                .subject-tabs-wrapper {
                    margin-bottom: 25px;
                    padding: 10px 15px;
                    background: transparent;
                }

                .subject-tabs {
                    display: flex;
                    flex-wrap: nowrap;
                    overflow-x: auto;
                    overflow-y: hidden;
                    scrollbar-width: thin;
                    padding: 5px 0 15px 0;
                    gap: 12px;
                    scroll-behavior: smooth;
                }

                .subject-tabs::-webkit-scrollbar {
                    height: 6px;
                }

                .subject-tabs::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 10px;
                }

                .subject-tabs::-webkit-scrollbar-thumb {
                    background: #c51619;
                    border-radius: 10px;
                }

                .subject-tabs::-webkit-scrollbar-thumb:hover {
                    background: #1e5f33;
                }

                .subject-tab {
                    padding: 18px 25px;
                    background-color: #ffffff;
                    border: 1px solid #e0e0e0;
                    border-radius: 16px;
                    cursor: pointer;
                    font-weight: 600;
                    transition: all 0.3s ease;
                    position: relative;
                    min-width: 220px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                    flex: 0 0 auto;
                }

                .subject-tab:hover {
                    background-color: #f0f7f2;
                    border-color: #c51619;
                    transform: translateY(-4px);
                    box-shadow: 0 8px 16px rgba(40, 124, 68, 0.15);
                }

                .subject-tab.active {
                    background-color: #c51619;
                    color: white;
                    border-color: #c51619;
                    box-shadow: 0 8px 20px rgba(40, 124, 68, 0.25);
                    transform: translateY(-2px);
                }

                /* Tab Content Layout */
                .subject-tab .tab-content {
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                }

                .subject-tab .tab-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    width: 100%;
                    gap: 10px;
                }

                .subject-tab .subject-info {
                    flex: 1;
                }

                .subject-tab .subject-name {
                    font-size: 15px;
                    line-height: 1.4;
                    font-weight: 600;
                    word-break: break-word;
                    white-space: normal;
                    max-width: 180px;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .subject-tab.active .subject-name {
                    color: white;
                }

                /* Progress Bar */
                .subject-progress {
                    height: 8px;
                    background-color: #e9ecef;
                    border-radius: 10px;
                    margin: 8px 0;
                    overflow: hidden;
                    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
                }

                .progress-fill {
                    height: 100%;
                    background: linear-gradient(90deg, #28a745, #34ce57);
                    transition: width 0.3s ease;
                    border-radius: 10px;
                }

                /* Stats Row */
                .subject-tab .stats-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    font-size: 12px;
                    font-weight: 500;
                    color: #6c757d;
                    margin-top: 5px;
                    padding-top: 8px;
                    border-top: 1px dashed rgba(0, 0, 0, 0.1);
                }

                .subject-tab.active .stats-row {
                    color: rgba(255, 255, 255, 0.9);
                    border-top: 1px dashed rgba(255, 255, 255, 0.3);
                }

                .subject-tab .stats-row span {
                    display: flex;
                    align-items: center;
                    gap: 6px;
                }

                .subject-tab .stats-row i {
                    font-size: 11px;
                }

                .subject-tab .pending-badge {
                    background-color: #dc3545;
                    color: white;
                    padding: 4px 10px;
                    border-radius: 30px;
                    font-size: 12px;
                    font-weight: 600;
                    display: inline-flex;
                    align-items: center;
                    gap: 5px;
                    box-shadow: 0 2px 5px rgba(220, 53, 69, 0.3);
                }

                .subject-tab .saved-badge {
                    background-color: #e9ecef;
                    color: #495057;
                    padding: 4px 10px;
                    border-radius: 30px;
                    font-size: 12px;
                    font-weight: 600;
                    display: inline-flex;
                    align-items: center;
                    gap: 5px;
                }

                .subject-tab.active .saved-badge {
                    background-color: rgba(255, 255, 255, 0.2);
                    color: white;
                }

                /* Remove old badge */
                .subject-tab .tab-badge {
                    display: none;
                }

                /* Tab Content Styling */
                .tab-pane {
                    display: none;
                }

                .tab-pane.active {
                    display: block;
                }

                /* Table Styling */
                .mark-input {
                    transition: all 0.2s;
                }

                .mark-input.saved {
                    border-color: #28a745;
                    background-color: #f0fff0;
                }

                .mark-input.unsaved {
                    border-color: #ffc107;
                }

                /* Save Indicator */
                .save-indicator {
                    display: inline-block;
                    width: 10px;
                    height: 10px;
                    border-radius: 50%;
                    margin-left: 5px;
                }

                .save-indicator.saved {
                    background-color: #28a745;
                }

                .save-indicator.unsaved {
                    background-color: #ffc107;
                }

                /* Action Buttons */
                .action-buttons {
                    position: sticky;
                    bottom: 20px;
                    z-index: 1000;
                    display: flex;
                    justify-content: flex-end;
                    gap: 10px;
                    padding: 10px;
                    background: rgba(255, 255, 255, 0.95);
                    border-radius: 50px;
                    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
                    margin-top: 20px;
                }

                /* Responsive */
                @media (max-width: 768px) {
                    .subject-tab {
                        min-width: 200px;
                        padding: 15px 20px;
                    }

                    .subject-tab .subject-name {
                        font-size: 14px;
                        max-width: 160px;
                    }

                    .action-buttons {
                        flex-direction: column;
                        border-radius: 10px;
                    }

                    .action-buttons button {
                        width: 100%;
                    }
                }

                @media (max-width: 480px) {
                    .subject-tab {
                        min-width: 180px;
                        padding: 12px 15px;
                    }

                    .subject-tab .subject-name {
                        font-size: 13px;
                        max-width: 140px;
                    }
                }

                .card-footer .d-flex {
                    flex-wrap: wrap;
                    gap: 10px;
                }

                .card-footer .d-flex>div {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 8px;
                }

                .card-footer .d-flex>button {
                    flex-shrink: 0;
                }

                @media (max-width: 576px) {
                    .card-footer .d-flex {
                        flex-direction: column;
                        align-items: stretch;
                    }

                    .card-footer .d-flex>div {
                        justify-content: flex-start;
                        width: 100%;
                    }

                    .card-footer .d-flex>button {
                        width: 100%;
                    }
                }
            </style>

            <div class="card shadow-lg border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center"
                    style="background-color: #026837;">
                    <h4 class="mb-0">
                        {{-- <i class="fa fa-school me-2"></i> School ID - {{ $schoolNumber ?? 'N/A' }} ({{ $schoolName ?? '' }}) --}}
                        <i class="fa fa-school me-2"></i> School ID - {{ $schoolNumber ?? 'N/A' }}
                    </h4>
                    <span class="badge bg-light text-dark">
                        <i class="fa fa-users me-1"></i> {{ $records->count() }} Students
                    </span>
                </div>

                <div class="card-body">

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            @if (session('success'))
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: @json(session('success')),
                                    confirmButtonColor: '#3085d6'
                                });
                            @endif

                            @if ($errors->any())
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    html: `{!! implode('<br>', $errors->all()) !!}`,
                                    confirmButtonColor: '#d33'
                                });
                            @endif
                        });
                    </script>

                    @if ($records->count() > 0)
                        <!-- Multi-Subject Tabs -->
                        <div class="subject-tabs-wrapper">
                            <div class="subject-tabs" id="subjectTabs">
                                @foreach ($subjects as $index => $subject)
                                    @php
                                        $subjectMarks = $existingMarks[$subject->md_id] ?? [];
                                        $savedCount = count($subjectMarks);
                                        $unsavedCount = $records->count() - $savedCount;
                                        $progressPercent =
                                            $records->count() > 0 ? ($savedCount / $records->count()) * 100 : 0;
                                    @endphp
                                    <div class="subject-tab {{ $index === 0 ? 'active' : '' }}"
                                        data-subject-id="{{ $subject->md_id }}" data-subject-name="{{ $subject->md_name }}">
                                        <div class="tab-content">
                                            <div class="tab-header">
                                                <div class="subject-info">
                                                    <div class="subject-name">{{ $subject->md_name }}</div>
                                                </div>
                                                @if ($unsavedCount > 0)
                                                    <span class="pending-badge">
                                                        <i class="fa fa-clock"></i> {{ $unsavedCount }}
                                                    </span>
                                                @else
                                                    <span class="saved-badge">
                                                        <i class="fa fa-check-circle"></i> Complete
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="subject-progress">
                                                <div class="progress-fill" style="width: {{ $progressPercent }}%"></div>
                                            </div>

                                            <div class="stats-row">
                                                <span>
                                                    <i class="fa fa-save"></i> {{ $savedCount }}/{{ $records->count() }}
                                                    saved
                                                </span>
                                                <span>
                                                    <i class="fa fa-percent"></i> {{ round($progressPercent) }}%
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Forms Container -->
                        <div id="formsContainer">
                            @foreach ($subjects as $index => $subject)
                                @php
                                    $subjectMarks = $existingMarks[$subject->md_id] ?? [];
                                @endphp

                                <div class="tab-pane {{ $index === 0 ? 'active' : '' }}"
                                    id="subject-form-{{ $subject->md_id }}" data-subject-id="{{ $subject->md_id }}">

                                    <form method="POST" action="{{ route('iteb.save.marks') }}" class="subject-form"
                                        data-subject-id="{{ $subject->md_id }}">
                                        @csrf
                                        <input type="hidden" name="subject_id" value="{{ $subject->md_id }}">

                                        <div class="card shadow-sm border-0 mb-3">
                                            <div
                                                class="card-header bg-light d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">
                                                    <i class="fa fa-book me-2"></i> {{ $subject->md_name }}
                                                    <small class="text-muted ms-2">({{ $records->count() }}
                                                        students)</small>
                                                </h5>
                                                <div class="subject-status">
                                                    <span
                                                        class="save-indicator {{ count($subjectMarks) == $records->count() ? 'saved' : 'unsaved' }}"></span>
                                                    <span
                                                        class="saved-count">{{ count($subjectMarks) }}</span>/{{ $records->count() }}
                                                    saved
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="10%">#</th>
                                                                <th width="40%">Index Number</th>
                                                                <th width="30%">Marks (0-100)</th>
                                                                <th width="20%">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($records as $key => $record)
                                                                @php
                                                                    $markValue =
                                                                        $subjectMarks[$record->Student_ID] ?? '';
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td>
                                                                        {{ $record->Student_ID }}
                                                                        <input type="hidden" name="students[]"
                                                                            value="{{ $record->Student_ID }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number"
                                                                            name="marks[{{ $record->Student_ID }}]"
                                                                            class="form-control mark-input {{ $markValue ? 'saved' : '' }}"
                                                                            placeholder="Enter marks"
                                                                            data-student="{{ $record->Student_ID }}"
                                                                            value="{{ old('marks.' . $record->Student_ID, $markValue) }}"
                                                                            min="0" max="100" step="1">
                                                                    </td>
                                                                    <td>
                                                                        @if ($markValue)
                                                                            <span class="badge bg-success">Saved
                                                                                ({{ $markValue }})
                                                                            </span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-warning text-dark">Pending</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="card-footer bg-light">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-sm fill-all-btn">
                                                            <i class="fa fa-magic me-1"></i> Fill All (with 0)
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm clear-all-btn">
                                                            <i class="fa fa-eraser me-1"></i> Clear All
                                                        </button>
                                                    </div>
                                                    <button type="submit" class="btn text-white"
                                                        style="background-color: #c51619;">
                                                        <i class="fa fa-save me-2"></i> Save {{ $subject->md_name }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <!-- Global Action Buttons -->
                        <div class="action-buttons">
                            <button type="button" class="btn btn-outline-primary" id="saveAllVisibleBtn">
                                <i class="fa fa-eye me-2"></i> Save Current Subject
                            </button>
                            <button type="button" class="btn btn-success" id="saveAllSubjectsBtn">
                                <i class="fa fa-save me-2"></i> Save All Subjects
                            </button>
                        </div>
                    @else
                        <div class="alert alert-danger text-center">
                            <i class="fa fa-exclamation-triangle me-2"></i> No records found for selected filters.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        const studentIds = @json($records->pluck('Student_ID'));
        const subjects = @json($subjects->pluck('md_id'));
        const existingMarks = @json($existingMarks);

        // ==================== TAB SWITCHING ====================
        $('.subject-tab').on('click', function() {
            const subjectId = $(this).data('subject-id');

            // Update tab active state
            $('.subject-tab').removeClass('active');
            $(this).addClass('active');

            // Update form visibility
            $('.tab-pane').removeClass('active');
            $(`#subject-form-${subjectId}`).addClass('active');
        });

        // ==================== AUTO-TAB FUNCTIONALITY ====================
        $(document).on('input', '.tab-pane.active .mark-input', function() {
            if ($(this).prop('disabled')) return;

            let currentValue = $(this).val();
            currentValue = currentValue.replace(/[^0-9]/g, '');

            // Special case: Allow 100
            if (currentValue === '100') {
                $(this).val(currentValue);
                updateMarkStatus($(this), currentValue);
                moveToNextInput(this);
                return;
            }

            // Limit to 2 digits
            if (currentValue.length > 2) {
                currentValue = currentValue.slice(0, 2);
            }

            $(this).val(currentValue);
            updateMarkStatus($(this), currentValue);

            // Auto-advance on 2 digits
            if (currentValue.length === 2) {
                moveToNextInput(this);
            }
        });

        function moveToNextInput(currentInput) {
            const inputs = $('.tab-pane.active .mark-input:enabled');
            const currentIndex = inputs.index(currentInput);
            if (currentIndex < inputs.length - 1) {
                $(inputs[currentIndex + 1]).focus();
            }
        }

        function updateMarkStatus(input, value) {
            const row = input.closest('tr');
            const statusBadge = row.find('td:last-child .badge');

            if (value && value !== '') {
                statusBadge.removeClass('bg-warning').addClass('bg-success').text(`Saved (${value})`);
                input.removeClass('unsaved').addClass('saved');
            } else {
                statusBadge.removeClass('bg-success').addClass('bg-warning').text('Pending');
                input.removeClass('saved').addClass('unsaved');
            }

            // Update tab progress
            updateTabProgress(input.closest('.tab-pane').data('subject-id'));
        }

        // ==================== KEYBOARD NAVIGATION ====================
        $(document).on('keydown', '.tab-pane.active .mark-input', function(e) {
            const inputs = $('.tab-pane.active .mark-input:enabled');
            const currentIndex = inputs.index(this);

            if (e.key === 'Backspace' && $(this).val().length === 0 && currentIndex > 0) {
                $(inputs[currentIndex - 1]).focus();
            } else if (e.key === 'ArrowLeft' && currentIndex > 0) {
                e.preventDefault();
                $(inputs[currentIndex - 1]).focus();
            } else if (e.key === 'ArrowRight' && currentIndex < inputs.length - 1) {
                e.preventDefault();
                $(inputs[currentIndex + 1]).focus();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (currentIndex < inputs.length - 1) {
                    $(inputs[currentIndex + 1]).focus();
                }
            }
        });

        // ==================== FILL ALL FUNCTIONALITY ====================
        $('.fill-all-btn').on('click', function() {
            const form = $(this).closest('form');
            const subjectId = form.data('subject-id');

            Swal.fire({
                title: 'Fill all marks?',
                text: 'This will set all empty marks to 0. Continue?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, fill all',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.find('.mark-input').each(function() {
                        if ($(this).val() === '') {
                            $(this).val('0');
                            updateMarkStatus($(this), '0');
                        }
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'Filled!',
                        text: 'All empty marks set to 0',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        });

        // ==================== CLEAR ALL FUNCTIONALITY ====================
        $('.clear-all-btn').on('click', function() {
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Clear all marks?',
                text: 'This will remove all marks for this subject. Continue?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, clear all',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.find('.mark-input').val('');
                    form.find('.mark-input').each(function() {
                        updateMarkStatus($(this), '');
                    });
                }
            });
        });

        // ==================== UPDATE TAB PROGRESS ====================
        function updateTabProgress(subjectId) {
            const tab = $(`.subject-tab[data-subject-id="${subjectId}"]`);
            const form = $(`#subject-form-${subjectId}`);
            const inputs = form.find('.mark-input');
            const totalInputs = inputs.length;
            const filledInputs = inputs.filter(function() {
                return $(this).val() !== '';
            }).length;
            const pending = totalInputs - filledInputs;
            const progressPercent = (filledInputs / totalInputs) * 100;

            // Update progress bar
            tab.find('.progress-fill').css('width', progressPercent + '%');

            // Update stats row
            const statsRow = tab.find('.stats-row');
            statsRow.find('span:first-child').html(
                `<i class="fa fa-save"></i> ${filledInputs}/${totalInputs} saved`);
            statsRow.find('span:last-child').html(
                `<i class="fa fa-percent"></i> ${Math.round(progressPercent)}%`);

            // Update pending badge
            const tabHeader = tab.find('.tab-header');
            if (pending > 0) {
                tabHeader.find('.pending-badge').remove();
                tabHeader.append(`
                    <span class="pending-badge">
                        <i class="fa fa-clock"></i> ${pending}
                    </span>
                `);
            } else {
                tabHeader.find('.pending-badge').remove();
                tabHeader.append(`
                    <span class="saved-badge">
                        <i class="fa fa-check-circle"></i> Complete
                    </span>
                `);
            }

            // Update status in form header
            form.find('.subject-status .save-indicator')
                .removeClass('saved unsaved')
                .addClass(filledInputs === totalInputs ? 'saved' : 'unsaved');
            form.find('.saved-count').text(filledInputs);
        }

        // ==================== FORM SUBMISSION ====================
        $('.subject-form').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const subjectName = form.closest('.tab-pane').find('.card-header h5').text().trim();
            const subjectId = form.data('subject-id');

            // Validate all marks are filled
            const emptyInputs = form.find('.mark-input').filter(function() {
                return $(this).val() === '';
            });

            if (emptyInputs.length > 0) {
                const studentList = emptyInputs.map(function() {
                    return $(this).data('student');
                }).get().join('<br>');

                Swal.fire({
                    icon: 'error',
                    title: 'Incomplete Submission',
                    html: `
                    <p>All students must have marks for <strong>${subjectName}</strong>.</p>
                    <p><strong>Missing students:</strong></p>
                    <div style="max-height:200px; overflow-y:auto; text-align:left;">
                        ${studentList}
                    </div>
                `,
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Validate mark ranges
            const invalidInputs = form.find('.mark-input').filter(function() {
                const val = parseInt($(this).val(), 10);
                return isNaN(val) || val < 0 || val > 100;
            });

            if (invalidInputs.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Marks',
                    text: 'All marks must be between 0 and 100.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Confirm submission
            Swal.fire({
                title: 'Submit Marks?',
                html: `Save marks for <strong>${subjectName}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, save',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Saving...',
                        html: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Saved!',
                                text: 'Marks saved successfully',
                                confirmButtonText: 'OK',
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });

                        },
                        error: function(xhr) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON && xhr.responseJSON
                                    .message ?
                                    xhr.responseJSON.message :
                                    'Failed to save marks',
                                confirmButtonText: 'OK'
                            });

                        }
                    });
                }
            });
        });

        // ==================== SAVE ALL SUBJECTS ====================
        $('#saveAllSubjectsBtn').on('click', function() {
            const forms = $('.subject-form');
            let hasEmptyMarks = false;
            let hasInvalidMarks = false;
            let emptySubjects = [];

            // Validate all forms first
            forms.each(function() {
                const form = $(this);
                const subjectName = form.closest('.tab-pane').find('.card-header h5').text()
                    .trim();
                const emptyInputs = form.find('.mark-input').filter(function() {
                    return $(this).val() === '';
                });

                if (emptyInputs.length > 0) {
                    hasEmptyMarks = true;
                    emptySubjects.push(subjectName);
                }

                const invalidInputs = form.find('.mark-input').filter(function() {
                    const val = parseInt($(this).val(), 10);
                    return $(this).val() !== '' && (isNaN(val) || val < 0 || val > 100);
                });

                if (invalidInputs.length > 0) {
                    hasInvalidMarks = true;
                }
            });

            if (hasEmptyMarks) {
                Swal.fire({
                    icon: 'error',
                    title: 'Incomplete Marks',
                    html: `
                    <p>The following subjects have empty marks:</p>
                    <ul style="text-align:left;">
                        ${emptySubjects.map(s => `<li>${s}</li>`).join('')}
                    </ul>
                `,
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (hasInvalidMarks) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Marks',
                    text: 'Some marks are invalid. All marks must be between 0-100.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Confirm saving all
            Swal.fire({
                title: 'Save All Subjects?',
                html: `This will save marks for <strong>${forms.length} subjects</strong>.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, save all',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show overall progress
                    Swal.fire({
                        title: 'Saving all subjects...',
                        html: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit forms sequentially
                    let completed = 0;
                    let errors = [];

                    function submitForm(index) {
                        if (index >= forms.length) {
                            // All done
                            Swal.fire({
                                icon: errors.length > 0 ? 'warning' : 'success',
                                title: errors.length > 0 ? 'Completed with errors' :
                                    'All Saved!',
                                html: `
                                Saved ${completed - errors.length}/${forms.length} subjects.<br>
                                ${errors.length > 0 ? 'Errors: ' + errors.join(', ') : ''}
                            `,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                            return;
                        }

                        const form = $(forms[index]);
                        const subjectName = form.closest('.tab-pane').find('.card-header h5')
                            .text().trim();

                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: form.serialize(),
                            success: function() {
                                completed++;
                                submitForm(index + 1);
                            },
                            error: function(xhr) {
                                completed++;
                                errors.push(subjectName);
                                submitForm(index + 1);
                            }
                        });
                    }

                    submitForm(0);
                }
            });
        });

        // ==================== SAVE CURRENT SUBJECT ====================
        $('#saveAllVisibleBtn').on('click', function() {
            const activeForm = $('.tab-pane.active .subject-form');
            activeForm.submit();
        });

        // Initialize all tabs progress on load
        subjects.forEach(function(subjectId) {
            updateTabProgress(subjectId);
        });
    });
</script>
