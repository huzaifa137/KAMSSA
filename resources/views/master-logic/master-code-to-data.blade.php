@extends('layouts.master')
@section('css')
<!-- Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
						<!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">Master Code</h4>
							</div>
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
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

						<!-- Row -->
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="col-md-12 p-4">
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

                                            <button id="addCodeBtn" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add Record</button>
                                            <div id="addCodeForm">
                                            <h3 class="heading text-primary">Add Record</h3>
                                            <form id='myForm' action="{{ route('send-master-code') }}" method="POST">
                                                @csrf
                                                <div class="formSep">

                                                    <div class="row">

                                                        <div class="col-sm-3 col-md-3 mb-3">
                                                            <label for="mc_code">Master code</label>
                                                            <input class="form-control" type="text" name="mc_code" id="mc_code"
                                                                required>
                                                        </div>

                                                        <div class="col-sm-9 col-md-9 mb-3">
                                                            <label for="mc_name">Master code name</label>
                                                            <input class="form-control" type="text" name="mc_name" id="mc_name">
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 mb-3">
                                                            <label for="mc_description">Master description</label>
                                                            <textarea class="form-control" name="mc_description" id="mc_description" required></textarea>
                                                        </div>

                                                        <div class="col-sm-12 mt-5">
                                                            <button class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Save</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </form>

                                                </div>

                                        </section>

                                    </div>
								</div>
								<div class="card mt-5 store">
									<div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="table">
                                            <thead>
                                                <tr>
                                                    <th>Master code</th>
                                                    <th>Master code name</th>
                                                    <th>Master description</th>
                                                    <th>Total List </th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($all_data as $item)
                                                    <tr>
                                                        <td title="{{ $item->id }}">{{ $item->mc_code }}</td>
                                                        <td>{{ $item->mc_name }}</td>
                                                        <td>{{ $item->mc_description }}</td>
                                                        <td>{{ Helper::totalRows('master_datas', 'md_master_code_id', $item->id) }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            <a href="{{ 'master-code-list/' . $item->mc_id }}" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-list"></i> Master Data List
                                                            </a>
                                                            
                                                            <a href="{{ url('master-data/edit-code/' . $item->id) }}"
                                                               class="btn btn-sm btn-primary edit-record-btn"
                                                               data-url="{{ url('master-data/edit-code/' . $item->id) }}">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            
                                                            <a href="{{ url('delete-code/' . $item->mc_id) }}" onclick="return confirm('Please confirm you want to delete this master code with all its records !')"
                                                               class="btn btn-sm btn-danger delete-record-btn">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </a>
                                                            

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
<script>
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
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection