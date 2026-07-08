<?php
use App\Http\Controllers\Helper;
use App\Http\Controllers\Controller;
$controller = new Controller();
?>
@extends('layouts-side-bar.master')
@section('css')
    <!---jvectormap css-->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="side-app">

    {{-- Page Header --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-primary">
                <div class="card-header">
                    @include('layouts.subjects-buttons')
                </div>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-10 col-sm-12 mx-auto">
            <div class="card shadow-sm" style="border-top: 4px solid #c51619; border-radius: 10px;">

                {{-- Card Header --}}
                <div class="card-header d-flex justify-content-between align-items-center"
                    style="background-color: #c51619; border-radius: 6px 6px 0 0;">
                    <div class="d-flex align-items-center gap-2">
                        <div style="background: rgba(255,255,255,0.15); border-radius: 8px; width:38px; height:38px;
                                    display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-school text-white" style="font-size:16px;"></i>
                        </div>
                        <div class="ms-2">
                            <h5 class="mb-0 text-white fw-semibold">Add New School</h5>
                            <small class="text-white-50" style="font-size:11px;">Fill in the details below</small>
                        </div>
                    </div>
                    <a href="{{ url('all-schools') }}" class="btn btn-sm text-white"
                        style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); border-radius:6px;">
                        <i class="fas fa-list me-1"></i> All Schools
                    </a>
                </div>

                {{-- Card Body --}}
                <div class="card-body" style="background:#f8faf9; border-radius: 0 0 10px 10px; padding: 28px 32px;">

                    {{-- Auto-generated ID badge --}}
                    <div class="d-flex align-items-center mb-4 p-3"
                        style="background:#e8f5ee; border-left: 4px solid #c51619; border-radius:0 6px 6px 0;">
                        <i class="fas fa-hashtag me-2" style="color:#c51619;"></i>
                        <span style="color:#c51619; font-size:13px;">
                            School Number will be auto-generated:
                            <strong id="preview-number">IT-{{ str_pad($nextNumber, 3, '0', STR_PAD_LEFT) }}</strong>
                        </span>
                    </div>

                    <form id="createHouseForm" method="POST" action="{{ route('houses.store') }}">
                        @csrf

                        {{-- School Name --}}
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold" style="color:#2d3748; font-size:13px;">
                                School Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#c51619; border-color:#c51619;">
                                    <i class="fas fa-school text-white" style="font-size:13px;"></i>
                                </span>
                                <input type="text" name="House" id="House"
                                    class="form-control @error('House') is-invalid @enderror"
                                    placeholder="e.g. NOOR ISLAMIC INSTITUTE"
                                    value="{{ old('House') }}" required
                                    style="border-left: none; font-size:14px;">
                                @error('House')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Location --}}
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold" style="color:#2d3748; font-size:13px;">
                                Location <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#c51619; border-color:#c51619;">
                                    <i class="fas fa-map-marker-alt text-white" style="font-size:13px;"></i>
                                </span>
                                <input type="text" name="Location" id="Location"
                                    class="form-control @error('Location') is-invalid @enderror"
                                    placeholder="e.g. Mbale - Bwalula"
                                    value="{{ old('Location') }}" required
                                    style="border-left: none; font-size:14px;">
                                @error('Location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Contact Person --}}
                        <!-- <div class="form-group mb-4">
                            <label class="form-label fw-semibold" style="color:#2d3748; font-size:13px;">
                                Contact Person
                                <span class="text-muted fw-normal" style="font-size:11px;">(optional)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#c51619; border-color:#c51619;">
                                    <i class="fas fa-user text-white" style="font-size:13px;"></i>
                                </span>
                                <select name="ContactPerson" id="ContactPerson"
                                    class="form-control select2 @error('ContactPerson') is-invalid @enderror"
                                    style="border-left: none; font-size:14px;">
                                    <option value="0">-- Select Contact Person --</option>
                                    @foreach ($contacts as $contact)
                                        <option value="{{ $contact->id }}"
                                            {{ old('ContactPerson') == $contact->id ? 'selected' : '' }}>
                                            {{ $contact->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ContactPerson')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> -->

                        {{-- Divider --}}
                        <hr style="border-color:#d4eadb; margin: 20px 0;">

                        {{-- Submit --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ url('schools/all') }}" class="btn btn-outline-secondary"
                                style="font-size:13px; border-radius:6px; padding: 8px 20px;">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" id="submitBtn" class="btn text-white"
                                style="background:#c51619; font-size:13px; border-radius:6px;
                                       padding: 8px 24px; min-width:120px;">
                                <i class="fa-solid fa-paper-plane me-2"></i> Save School
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    $('#createHouseForm').on('submit', function (e) {
        e.preventDefault();

        let $form   = $(this);
        let $btn    = $('#submitBtn');
        let isValid = true;

        // Clear previous errors
        $form.find('.form-control').removeClass('is-invalid');
        $form.find('.invalid-feedback').remove();

        // Validate required fields
        ['House', 'Location'].forEach(function (field) {
            let $input = $form.find('[name="' + field + '"]');
            if (!$input.val() || $input.val().trim() === '') {
                $input.addClass('is-invalid');
                $input.after('<div class="invalid-feedback">This field is required.</div>');
                isValid = false;
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Form',
                text: 'Please fill in all required fields.',
                confirmButtonColor: '#c51619'
            });
            return;
        }

        Swal.fire({
            title: 'Save this school?',
            html: '<span style="color:#555;">You are about to register <strong>'
                + $('#House').val().trim() + '</strong>.</span>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#c51619',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel'
        }).then(function (result) {
            if (result.isConfirmed) {
                let originalHtml = $btn.html();
                $btn.prop('disabled', true)
                    .html('Saving… <i class="fas fa-spinner fa-spin ms-1"></i>');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: response.message || 'School has been added successfully.',
                            confirmButtonColor: '#c51619'
                        }).then(function () {
                            $form[0].reset();
                            $('.select2').val('').trigger('change');
                            // Update the preview number badge
                            $('#preview-number').text(response.next_number || '');
                        });
                    },
                    // error: function (xhr) {
                    //     if (xhr.status === 422) {
                    //         let errors = xhr.responseJSON.errors;
                    //         $.each(errors, function (field, messages) {
                    //             let $field = $form.find('[name="' + field + '"]');
                    //             $field.addClass('is-invalid');
                    //             $field.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                    //         });
                    //         Swal.fire({
                    //             icon: 'error',
                    //             title: 'Validation Error',
                    //             text: 'Please correct the highlighted fields.',
                    //             confirmButtonColor: '#c51619'
                    //         });
                    //     } else {
                    //         Swal.fire({
                    //             icon: 'error',
                    //             title: 'Error',
                    //             text: 'Something went wrong. Please try again.',
                    //             confirmButtonColor: '#c51619'
                    //         });
                    //     }
                    // },
                    error: function(data) {
$('body').html(data.responseText);
},
                    complete: function () {
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
            }
        });
    });

});
</script>
@endsection