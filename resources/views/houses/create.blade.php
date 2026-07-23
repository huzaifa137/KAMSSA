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
                <div class="card shadow-sm" style="border-top: 4px solid #026837; border-radius: 10px;">

                    {{-- Card Header --}}
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background-color: #026837; border-radius: 6px 6px 0 0;">
                        <div class="d-flex align-items-center gap-2">
                            <div style="background: rgba(255,255,255,0.15); border-radius: 8px; width:38px; height:38px;
                                                display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-school text-white" style="font-size:16px;"></i>
                            </div> &nbsp; &nbsp;
                            <div class="ms-2">
                                <h5 class="mb-0 text-white fw-semibold">Add New School</h5>
                                <small class="text-white" style="font-size:11px;">Fill in the details below</small>
                            </div>
                        </div>
                        <a href="{{ url('all-schools') }}" class="btn btn-sm text-white"
                            style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); border-radius:6px;">
                            <i class="fas fa-list me-1"></i> All Schools
                        </a>
                    </div>

                    <div class="card-body" style="background: #ffffff; border-radius: 0 0 20px 20px; padding: 0;">

                        {{-- Progress/Step Indicator --}}
                        <div
                            style="background: linear-gradient(135deg, #0f1724 0%, #1a2a3a 100%); padding: 30px 40px; border-radius: 0 0 20px 20px; margin-bottom: 30px;">
                            <div
                                style="display: flex; align-items: center; justify-content: space-between; max-width: 600px; margin: 0 auto;">
                                <div style="text-align: center;">
                                    <div
                                        style="width: 40px; height: 40px; background: #026837; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                                        <i class="fas fa-check" style="color: white; font-size: 16px;"></i>
                                    </div>
                                    <span
                                        style="color: #026837; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">School</span>
                                </div>
                                <div style="flex: 1; height: 2px; background: #2a3a4a; margin: 0 10px;"></div>
                                <div style="text-align: center;">
                                    <div
                                        style="width: 40px; height: 40px; background: #2a3a4a; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; border: 2px solid #026837;">
                                        <span style="color: #026837; font-weight: 700; font-size: 14px;">2</span>
                                    </div>
                                    <span
                                        style="color: #8899aa; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Details</span>
                                </div>
                                <div style="flex: 1; height: 2px; background: #2a3a4a; margin: 0 10px;"></div>
                                <div style="text-align: center;">
                                    <div
                                        style="width: 40px; height: 40px; background: #2a3a4a; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;">
                                        <span style="color: #8899aa; font-weight: 700; font-size: 14px;">3</span>
                                    </div>
                                    <span
                                        style="color: #8899aa; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Confirm</span>
                                </div>
                            </div>

                            {{-- Auto-generated ID --}}
                            <div
                                style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #2a3a4a;">
                                <span
                                    style="color: #8899aa; font-size: 12px; text-transform: uppercase; letter-spacing: 2px;">School
                                    Reference</span>
                                <div
                                    style="display: inline-block; background: rgba(0, 208, 132, 0.1); padding: 8px 30px; border-radius: 50px; margin-top: 8px; border: 1px solid rgba(0, 208, 132, 0.2);">
                                    <span
                                        style="color: #026837; font-size: 22px; font-weight: 700; letter-spacing: 3px; font-family: 'Courier New', monospace;">
                                        IT-{{ str_pad($nextNumber, 3, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                                <div style="margin-top: 6px;">
                                    <span style="color: #667788; font-size: 11px;">
                                        <i class="fas fa-sync-alt" style="font-size: 10px;"></i> Auto-generated
                                    </span>
                                </div>
                            </div>
                        </div>

                        <form id="createHouseForm" method="POST" action="{{ route('houses.store') }}"
                            style="padding: 0 40px 40px 40px;">
                            @csrf

                            {{-- Main Information Card --}}
                            <div
                                style="background: #f8fafc; border-radius: 16px; padding: 30px; margin-bottom: 25px; border: 1px solid #e8edf2;">
                                <h6
                                    style="color: #1a2a3a; font-weight: 700; font-size: 16px; margin-bottom: 25px; display: flex; align-items: center;">
                                    <span
                                        style="display: inline-block; width: 4px; height: 20px; background: #026837; border-radius: 4px; margin-right: 12px;"></span>
                                    School Information
                                </h6>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <label
                                            style="display: block; color: #4a5a6a; font-size: 13px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            <i class="fas fa-university"
                                                style="color: #026837; margin-right: 8px; width: 16px;"></i>
                                            School Name
                                        </label>
                                        <input type="text" name="House" id="House"
                                            class="form-control @error('House') is-invalid @enderror"
                                            placeholder="Type school name..." value="{{ old('House') }}" required
                                            style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: white; transition: all 0.25s ease;"
                                            onfocus="this.style.borderColor='#026837'; this.style.boxShadow='0 0 0 4px rgba(0,208,132,0.08)'"
                                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                        @error('House')
                                            <div style="color: #e74c3c; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            style="display: block; color: #4a5a6a; font-size: 13px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            <i class="fas fa-location-dot"
                                                style="color: #026837; margin-right: 8px; width: 16px;"></i>
                                            District
                                        </label>
                                        <input type="text" name="Location" id="Location"
                                            class="form-control @error('Location') is-invalid @enderror"
                                            placeholder="Enter district..." value="{{ old('Location') }}" required
                                            style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: white; transition: all 0.25s ease;"
                                            onfocus="this.style.borderColor='#026837'; this.style.boxShadow='0 0 0 4px rgba(0,208,132,0.08)'"
                                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                        @error('Location')
                                            <div style="color: #e74c3c; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- Category Selection --}}
                            <div id="categorySelectionContainer"
                                style="background: #f8fafc; border-radius: 16px; padding: 30px; margin-bottom: 25px; border: 1px solid #e8edf2;">
                                <h6
                                    style="color: #1a2a3a; font-weight: 700; font-size: 16px; margin-bottom: 20px; display: flex; align-items: center;">
                                    <span
                                        style="display: inline-block; width: 4px; height: 20px; background: #026837; border-radius: 4px; margin-right: 12px;"></span>
                                    Category Selection
                                </h6>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                    <label for="categoryAnswers"
                                        style="cursor: pointer; display: block; transition: all 0.3s ease;"
                                        onclick="selectCategory('categoryAnswers', 'categoryNoAnswers')">
                                        <input type="radio" name="Category" id="categoryAnswers" value="Answer Sheets"
                                            style="display: none;" {{ old('Category') == 'Answer Sheets' ? 'checked' : '' }}>
                                        <div
                                            style="padding: 20px; border: 2px solid {{ old('Category') == 'Answer Sheets' ? '#026837' : '#e2e8f0' }}; border-radius: 12px; background: {{ old('Category') == 'Answer Sheets' ? '#f0fdf4' : 'transparent' }}; text-align: center; transition: all 0.3s ease;">
                                            <div style="font-size: 32px; margin-bottom: 8px; color: #026837;">
                                                <i class="fas fa-file-pen"></i>
                                            </div>
                                            <div style="font-weight: 700; color: #1a2a3a; font-size: 15px;">Answer Sheets
                                            </div>
                                            <div style="font-size: 12px; color: #8899aa; margin-top: 4px;">Exam materials
                                                provided</div>
                                        </div>
                                    </label>

                                    <label for="categoryNoAnswers"
                                        style="cursor: pointer; display: block; transition: all 0.3s ease;"
                                        onclick="selectCategory('categoryNoAnswers', 'categoryAnswers')">
                                        <input type="radio" name="Category" id="categoryNoAnswers" value="No Answer Sheets"
                                            style="display: none;" {{ old('Category') == 'No Answer Sheets' ? 'checked' : '' }}>
                                        <div
                                            style="padding: 20px; border: 2px solid {{ old('Category') == 'No Answer Sheets' ? '#e74c3c' : '#e2e8f0' }}; border-radius: 12px; background: {{ old('Category') == 'No Answer Sheets' ? '#fdf2f2' : 'transparent' }}; text-align: center; transition: all 0.3s ease;">
                                            <div style="font-size: 32px; margin-bottom: 8px; color: #e74c3c;">
                                                <i class="fas fa-ban"></i>
                                            </div>
                                            <div style="font-weight: 700; color: #1a2a3a; font-size: 15px;">No Answer Sheets
                                            </div>
                                            <div style="font-size: 12px; color: #8899aa; margin-top: 4px;">No exam materials
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div id="categoryError"
                                    style="color: #e74c3c; font-size: 12px; margin-top: 10px; display: none;"></div>
                            </div>

                            {{-- Administrator Details Card --}}
                            <div
                                style="background: linear-gradient(135deg, #f8fafc 0%, #f0f4f8 100%); border-radius: 16px; padding: 30px; margin-bottom: 25px; border: 1px solid #e8edf2; position: relative; overflow: hidden;">
                                <div
                                    style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(0,208,132,0.03); border-radius: 50%;">
                                </div>
                                <div
                                    style="position: absolute; bottom: -30px; left: -30px; width: 100px; height: 100px; background: rgba(0,208,132,0.02); border-radius: 50%;">
                                </div>

                                <h6
                                    style="color: #1a2a3a; font-weight: 700; font-size: 16px; margin-bottom: 25px; display: flex; align-items: center; position: relative; z-index: 1;">
                                    <span
                                        style="display: inline-block; width: 4px; height: 20px; background: #026837; border-radius: 4px; margin-right: 12px;"></span>
                                    <i class="fas fa-user-tie"
                                        style="color: #026837; margin-right: 10px; font-size: 18px;"></i>
                                    Administrator Details
                                </h6>

                                <div
                                    style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; position: relative; z-index: 1;">
                                    <div>
                                        <label
                                            style="display: block; color: #4a5a6a; font-size: 13px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            <i class="fas fa-user"
                                                style="color: #026837; margin-right: 8px; width: 16px;"></i>
                                            Full Name(s)
                                        </label>
                                        <input type="text" name="AdministratorNames" id="AdministratorNames"
                                            class="form-control @error('AdministratorNames') is-invalid @enderror"
                                            placeholder="Enter administrator name..."
                                            value="{{ old('AdministratorNames') }}" required
                                            style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: white; transition: all 0.25s ease;"
                                            onfocus="this.style.borderColor='#026837'; this.style.boxShadow='0 0 0 4px rgba(0,208,132,0.08)'"
                                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                        @error('AdministratorNames')
                                            <div style="color: #e74c3c; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            style="display: block; color: #4a5a6a; font-size: 13px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            <i class="fas fa-phone"
                                                style="color: #026837; margin-right: 8px; width: 16px;"></i>
                                            Telephone
                                        </label>
                                        <input type="text" name="AdministratorTelephones" id="AdministratorTelephones"
                                            class="form-control @error('AdministratorTelephones') is-invalid @enderror"
                                            placeholder="e.g. 0712-345-678" value="{{ old('AdministratorTelephones') }}"
                                            required
                                            style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: white; transition: all 0.25s ease;"
                                            onfocus="this.style.borderColor='#026837'; this.style.boxShadow='0 0 0 4px rgba(0,208,132,0.08)'"
                                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                        @error('AdministratorTelephones')
                                            <div style="color: #e74c3c; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div style="grid-column: 1 / -1;">
                                        <label
                                            style="display: block; color: #4a5a6a; font-size: 13px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            <i class="fas fa-briefcase"
                                                style="color: #026837; margin-right: 8px; width: 16px;"></i>
                                            Position Title
                                        </label>
                                        <input type="text" name="Title" id="Title"
                                            class="form-control @error('Title') is-invalid @enderror"
                                            placeholder="e.g. Headteacher, Principal, Director..."
                                            value="{{ old('Title') }}" required
                                            style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: white; transition: all 0.25s ease;"
                                            onfocus="this.style.borderColor='#026837'; this.style.boxShadow='0 0 0 4px rgba(0,208,132,0.08)'"
                                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                        @error('Title')
                                            <div style="color: #e74c3c; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px; border-top: 2px solid #f0f4f8;">
                                <a href="{{ url('schools/all') }}"
                                    style="display: inline-flex; align-items: center; padding: 12px 28px; color: #4a5a6a; text-decoration: none; border-radius: 12px; font-weight: 600; font-size: 14px; transition: all 0.25s ease; background: #f8fafc; border: 2px solid #e2e8f0;"
                                    onmouseover="this.style.background='#eef2f6'; this.style.borderColor='#c8d0d8'"
                                    onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'">
                                    <i class="fas fa-arrow-left" style="margin-right: 10px; font-size: 13px;"></i>
                                    Back to Schools
                                </a>

                                <button type="submit" id="submitBtn"
                                    style="padding: 12px 40px; background: linear-gradient(135deg, #026837 0%, #026837 100%); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 15px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,208,132,0.3); display: inline-flex; align-items: center;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 25px rgba(0,208,132,0.4)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,208,132,0.3)'">
                                    <i class="fas fa-save" style="margin-right: 10px;"></i>
                                    Create School
                                    <span
                                        style="display: inline-block; margin-left: 12px; background: rgba(255,255,255,0.2); padding: 2px 10px; border-radius: 50px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Submit
                                    </span>
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

                let $form = $(this);
                let $btn = $('#submitBtn');
                let isValid = true;

                // Clear previous errors
                $form.find('.form-control').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();
                $('#categoryError').hide();
                $('#categorySelectionContainer').css('border-color', '#e8edf2');

                // Validate required fields
                ['House', 'Location', 'AdministratorNames', 'AdministratorTelephones', 'Title'].forEach(function (field) {
                    let $input = $form.find('[name="' + field + '"]');
                    if (!$input.val() || $input.val().trim() === '') {
                        $input.addClass('is-invalid');
                        $input.after('<div class="invalid-feedback">This field is required.</div>');
                        isValid = false;
                    }
                });

                // Validate Category selection
                if (!$('input[name="Category"]:checked').length) {
                    $('#categoryError').text('Please select a category.').show();
                    $('#categorySelectionContainer').css('border-color', '#e74c3c');
                    isValid = false;
                }

                if (!isValid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete Form',
                        text: 'Please fill in all required fields.',
                        confirmButtonColor: '#026837'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Save this school?',
                    html: '<span style="color:#555;">You are about to register <strong>'
                        + $('#House').val().trim() + '</strong>.</span>',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#069c4a',
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
                                    confirmButtonColor: '#287C44'
                                }).then(function () {
                                    $form[0].reset();
                                    $('.select2').val('').trigger('change');
                                });
                            },
                            error: function (data) {
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

        // Function to handle category selection
        function selectCategory(selectedId, otherId) {
            const selectedLabel = document.querySelector(`label[for="${selectedId}"] div`);
            const otherLabel = document.querySelector(`label[for="${otherId}"] div`);

            // Update selected category styling
            selectedLabel.style.borderColor = selectedId === 'categoryAnswers' ? '#026837' : '#e74c3c';
            selectedLabel.style.background = selectedId === 'categoryAnswers' ? '#f0fdf4' : '#fdf2f2';

            // Reset the other category styling
            otherLabel.style.borderColor = '#e2e8f0';
            otherLabel.style.background = 'transparent';

            // Hide error if a category is selected
            $('#categoryError').hide();
            $('#categorySelectionContainer').css('border-color', '#e8edf2');
        }

        // Initialize selection on page load
        document.addEventListener('DOMContentLoaded', function () {
            const selectedCategory = document.querySelector('input[name="Category"]:checked');
            if (selectedCategory) {
                const selectedId = selectedCategory.id;
                const otherId = selectedId === 'categoryAnswers' ? 'categoryNoAnswers' : 'categoryAnswers';
                selectCategory(selectedId, otherId);
            }
        });
    </script>
@endsection