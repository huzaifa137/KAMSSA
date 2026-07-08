@extends('layouts.master')
@section('css')
    <!-- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Master Data</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Master Code</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <?php
    use App\Http\Controllers\Helper;
    ?>

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
    <!-- Row -->
    <div class="row mb-5">
        <div class="col-lg-3">
            <div class="panel panel-primary">
                <div class="list-group">
                    @foreach ($selected as $item)
                        @if ($item->mc_id == $mc_id)
                            <a href="#" class="active pt-1 pb-1 list-group-item"><i class="fa fa-circle"
                                    aria-hidden="true"></i> &nbsp; {{ $item->mc_name }} <span
                                    class="badge badge-white pull-right">{{ @$code_totals[$item->id]->total }}</span></a>
                        @else
                            <a href="{{ url('master-data/master-code-list/' . $item->mc_id) }}"
                                class="pt-1 pb-1 list-group-item">{{ $item->mc_name }} <span
                                    class="badge badge-white pull-right">{{ @$code_totals[$item->id]->total }}</span></a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="col-md-12 p-4">
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
                        rel="stylesheet">

                    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
                        rel="stylesheet">

                    <style>
                        .form-builder-section {
                            position: relative;
                            margin-bottom: 20px;
                            padding: 15px;
                            border: 1px solid #dee2e6;
                            border-radius: 5px;
                            background-color: #f8f9fa;
                        }

                        .delete-btn {
                            position: absolute;
                            top: 10px;
                            right: 10px;
                            color: #dc3545;
                        }

                        .delete-btn:hover {
                            color: #a71d2a;
                        }

                        .option-wrapper {
                            position: relative;
                            margin-bottom: 10px;
                        }

                        .delete-option-btn {
                            position: absolute;
                            right: 10px;
                            top: 50%;
                            transform: translateY(-50%);
                            color: #dc3545;
                            font-size: 1.2rem;
                            cursor: pointer;
                        }

                        .dropdown-options-list li {
                            font-size: 0.95rem;
                        }

                        .dropdown-options-list .btn {
                            font-size: 0.75rem;
                            padding: 2px 6px;
                        }
                    </style>

                    <section id="Approved_suppliers">
                        <button id="addCodeBtn" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add
                            Record</button>
                        <div id="addCodeForm">
                            <h3 class="heading text-primary">Add Record</h3>

                            <form id="myForm" action="{{ route('add-new-record') }}" method="POST">
                                @csrf
                                <meta name="csrf-token" content="{{ csrf_token() }}">

                                <div class="formSep">
                                    <div class="row">
                                        <div class="col-sm-3 col-md-3">
                                            <label for="">Master Code</label>
                                            <select name="master_code_id" id="master_code_id" class="form-control">
                                                @foreach ($selected as $item)
                                                    @if ($item->mc_id == $mc_id)
                                                        <option selected value="{{ $item->id }}">{{ $item->mc_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->mc_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-3 col-md-3">
                                            <label for="">Master Data Code</label>
                                            <input class="form-control" type="text" name="md_code" id="md_code"
                                                required>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <label for="mask_product">Master Data Name</label>
                                            <input class="form-control" type="text" name="md_name" id="md_name"
                                                required>
                                        </div>

                                        <div class="col-sm-12 col-md-12 ">
                                            <label for="" class="mt-5">Master Data Description</label>
                                            <textarea class="form-control" name="md_description" id="md_description"></textarea>
                                        </div>

                                        <div class="col-sm-3 col-md-3 margTp" style="display: none">
                                            <label for="">md_date_added</label>
                                            <input class="form-control" type="text" name="md_date_added"
                                                id="md_date_added">
                                        </div>

                                        <div class="col-sm-3 col-md-3 margTp" style="display: none">
                                            <label for="mask_product">md_added_by</label>
                                            <input class="form-control" type="text" name="md_added_by" id="md_added_by">
                                        </div>

                                        <div class="container mt-4">
                                            <div class="form-group mb-3">
                                                <select id="elementType" class="form-control">
                                                    <option value="">-- Choose Element --</option>
                                                    <option value="input">Input</option>
                                                    <option value="textarea">Textarea</option>
                                                    <option value="select">Dropdown</option>
                                                </select>
                                            </div>

                                            <div id="elementOptions" class="mt-3" style="display: none;"></div>
                                            <button type="button" id="addElement" class="btn btn-success mb-3">
                                                <i class="bi bi-plus-circle"></i> Add Element
                                            </button>

                                            <hr>

                                            <div id="formElements"></div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <br>
                                        <div class="mt-5 col-sm-3 col-md-3">
                                            <button class="btn btn-primary" type="submit" id="add_new_data">
                                                <i class="fa fa-fw fa-save"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <script>
                            $(document).ready(function() { // Ensure DOM is ready

                                $('#elementType').on('change', function() {
                                    const selected = $(this).val();
                                    const $optionsDiv = $('#elementOptions').empty().hide();

                                    if (selected === 'select') {
                                        $optionsDiv.show().append(`
                        <label><strong>Add Dropdown Options</strong></label>
                        <div id="dropdownOptions">
                            <div class="option-wrapper">
                                <input type="text" class="form-control option-input" placeholder="Option 1">
                                <span class="delete-option-btn bi bi-x-circle-fill"></span>
                            </div>
                            <div class="option-wrapper">
                                <input type="text" class="form-control option-input" placeholder="Option 2">
                                <span class="delete-option-btn bi bi-x-circle-fill"></span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2 mb-2" id="addDropdownOption">
                            <i class="bi bi-plus"></i> Add More Option
                        </button>
                    `);
                                    }
                                });

                                $('#elementOptions').on('click', '#addDropdownOption', function() {
                                    $('#dropdownOptions').append(`
                    <div class="option-wrapper">
                        <input type="text" class="form-control option-input" placeholder="New Option">
                        <span class="delete-option-btn bi bi-x-circle-fill"></span>
                    </div>
                `);
                                });

                                $('#elementOptions').on('click', '.delete-option-btn', function() {
                                    $(this).closest('.option-wrapper').remove();
                                });

                                $('#addElement').on('click', function() {
                                    const selected = $('#elementType').val();
                                    if (!selected) {
                                        Swal.fire('Warning', 'Please select a form element type.', 'warning');
                                        return;
                                    }

                                    const index = $('#formElements .form-builder-section').length + 1;
                                    const deleteButton =
                                        `<button type="button" class="btn btn-sm delete-btn" title="Delete Section"><i class="bi bi-trash3-fill"></i></button>`;
                                    let elementHtml = '';

                                    if (selected === 'input') {
                                        elementHtml = `
                        <div class="form-builder-section">
                            ${deleteButton}
                            <label>Input Field ${index}</label>
                            <input type="text" name="dynamic_input_${index}" class="form-control">
                        </div>`;
                                    }

                                    if (selected === 'textarea') {
                                        elementHtml = `
                        <div class="form-builder-section">
                            ${deleteButton}
                            <label>Textarea ${index}</label>
                            <textarea name="dynamic_textarea_${index}" class="form-control" rows="3"></textarea>
                        </div>`;
                                    }

                                    if (selected === 'select') {
                                        const options = [];
                                        $('#dropdownOptions .option-input').each(function() {
                                            const val = $(this).val().trim();
                                            if (val) options.push(val);
                                        });

                                        if (options.length === 0) {
                                            Swal.fire('Error', 'You must add at least one non-empty option for the dropdown.',
                                                'error');
                                            return;
                                        }

                                        // Build the options HTML for the select tag
                                        let selectOptionsHtml = options.map(opt => `<option value="${opt}">${opt}</option>`)
                                            .join('');

                                        // Build the list of initial options for display/management
                                        let optionListHtml = options.map(opt => `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            ${opt}
                            <button type="button" class="btn btn-sm btn-danger btn-delete-option">
                                <i class="bi bi-x-circle-fill"></i>
                            </button>
                        </li>
                    `).join('');

                                        elementHtml = `
                        <div class="form-builder-section">
                            ${deleteButton}
                            <label>Dropdown ${index}</label>
                            <div class="dropdown-section" data-field-name="dynamic_select_${index}">
                                <select name="dynamic_select_${index}" class="form-control mb-2">
                                    ${selectOptionsHtml}
                                </select>
                                <ul class="list-group dropdown-options-list">
                                    ${optionListHtml}
                                </ul>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control new-dropdown-option" placeholder="Add new option">
                                    <button type="button" class="btn btn-sm btn-outline-secondary add-new-option">
                                        <i class="bi bi-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>`;
                                    }

                                    $('#formElements').append(elementHtml);
                                    $('#elementType').val('');
                                    $('#elementOptions').hide().empty();
                                });

                                $('#formElements').on('click', '.delete-btn', function() {
                                    $(this).closest('.form-builder-section').remove();
                                    renumberElements();
                                });

                                function renumberElements() {
                                    $('#formElements .form-builder-section').each(function(index) {
                                        const number = index + 1;
                                        const label = $(this).find('label').first();
                                        const inputField = $(this).find('input[type="text"], textarea, select');

                                        let currentName = inputField.attr('name');
                                        let newName = '';

                                        if (currentName.includes('dynamic_input_')) {
                                            newName = `dynamic_input_${number}`;
                                            label.text(`Input Field ${number}`);
                                        } else if (currentName.includes('dynamic_textarea_')) {
                                            newName = `dynamic_textarea_${number}`;
                                            label.text(`Textarea ${number}`);
                                        } else if (currentName.includes('dynamic_select_')) {
                                            newName = `dynamic_select_${number}`;
                                            label.text(`Dropdown ${number}`);
                                            $(this).find('.dropdown-section').attr('data-field-name', newName);
                                        }
                                        inputField.attr('name', newName); // Update name attribute
                                    });
                                }

                                $('#formElements').on('click', '.add-new-option', function() {
                                    const container = $(this).closest('.dropdown-section');
                                    const input = container.find('.new-dropdown-option');
                                    const value = input.val().trim();
                                    const select = container.find('select');
                                    const optionList = container.find('.dropdown-options-list');

                                    if (!value) {
                                        Swal.fire('Error', 'Option cannot be empty.', 'error');
                                        return;
                                    }

                                    select.append(`<option value="${value}">${value}</option>`);
                                    optionList.append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ${value}
                        <button type="button" class="btn btn-sm btn-danger btn-delete-option">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </li>`);

                                    input.val('');
                                });

                                $('#formElements').on('click', '.btn-delete-option', function() {
                                    const listItem = $(this).closest('li');
                                    const optionText = listItem.contents().get(0).nodeValue.trim(); // Get the text content
                                    const select = $(this).closest('.dropdown-section').find('select');

                                    select.find('option').filter(function() {
                                        return $(this).text() === optionText;
                                    }).remove();

                                    listItem.remove();
                                });

                                $('#myForm').on('submit', function(e) {
                                    e.preventDefault();

                                    const $form = $(this);
                                    const url = $form.attr('action');
                                    const method = $form.attr('method');

                                    const formData = new FormData($form[0]);

                                    const dynamicElementsData = {};

                                    $('#formElements .form-builder-section').each(function() {
                                        const $this = $(this);
                                        const inputField = $this.find('input[type="text"], textarea, select');

                                        if (inputField.length > 0) {
                                            const name = inputField.attr('name');
                                            const value = inputField.val();

                                            if (inputField.is('select')) {
                                                const options = [];
                                                inputField.find('option').each(function() {
                                                    options.push({
                                                        value: $(this).val(),
                                                        text: $(this).text()
                                                    });
                                                });
                                                dynamicElementsData[name] = {
                                                    value: value,
                                                    options: options
                                                };
                                            } else {
                                                dynamicElementsData[name] = value;
                                            }
                                        }
                                    });

                                    formData.append('dynamic_form_elements', JSON.stringify(dynamicElementsData));

                                    $.ajax({
                                        url: url,
                                        method: method,
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            if (response.success) {
                                                Swal.fire('Success!', response.message, 'success').then(() => {
                                                    window.location.href = response.redirect_url;
                                                });
                                            } else {
                                                Swal.fire('Error!', response.message, 'error');
                                            }
                                        },
                                        // error: function(xhr) {
                                        //     let errorMessage = 'An unknown error occurred.';
                                        //     if (xhr.responseJSON && xhr.responseJSON.message) {
                                        //         errorMessage = xhr.responseJSON.message;
                                        //     } else if (xhr.responseText) {
                                        //         errorMessage = xhr.responseText;
                                        //     }
                                        //     Swal.fire('Error!', errorMessage, 'error');
                                        //     console.error(xhr.responseText);
                                        // }
                                        error: function(data) {
                                            $('body').html(data.responseText);
                                        }
                                    });
                                });
                            });
                        </script>
                    </section>

                </div>
            </div>
            <h3 class="mt-4 mb-0 pb-0 text-primary text-uppercase">{{ $mc_name }} List</h3>
            <div class="card mt-5 store">
                <div class="table-responsive p-5">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <tr>
                                <!-- <th style="width:30px;">No.</th> -->
                                <th>Data Code</th>
                                <th>Data Name</th>
                                <th class="text-center">Data Description</th>
                                <!-- <th>Date Added</th> -->
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>

                    <input type="hidden" value="{{ $mc_id }}" id="mc_id" />

                </div>

            </div>
        </div>
    </div>
    <!-- End Row -->

    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            var mcId = $('#mc_id').val();
            if (!mcId) {
                console.error('mc_id is empty or undefined');
                return;
            }

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('master-code-list', ['id' => '__mc_id__']) }}'.replace("__mc_id__", $(
                        '#mc_id').val()),
                    // error: function(xhr, error, thrown) {
                    //     // Log the error response to display it
                    //     console.error('AJAX Error:', xhr.status, error, thrown);
                    //     $('body').html(xhr.responseText); // Show the raw response from the server
                    // }
                    error: function(data) {
                        $('body').html(data.responseText);
                    }
                },
                columns: [{
                        data: 'md_code',
                        name: 'md_code'
                    },
                    {
                        data: 'md_name',
                        name: 'md_name'
                    },
                    {
                        data: 'md_description',
                        name: 'md_description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                pageLength: 20,
                lengthMenu: [10, 25, 50, 100],
                order: [
                    [0, 'asc']
                ],
                searching: true,
                ordering: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

        });


        $(document).ready(function() {
            $('#addCodeForm').hide();
            $('#addCodeBtn').click(function() {
                $('#addCodeForm').toggle();
                const buttonText = $('#addCodeForm').is(':visible') ? 'Hide Form' : 'Add Code';
                $(this).text(buttonText);
            });
        });
    </script>
    <!--Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
@endsection
