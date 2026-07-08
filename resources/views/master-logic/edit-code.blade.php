@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <?php
    
    use App\Http\Controllers\AccessRightController;
    use App\Http\Controllers\MasterDataController;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Helper;
    $controller = new Controller();
    $user_id = Helper::user_id();
    
    $links = MasterDataController::links();
    
    ?>

    <!--Page header-->
    <div class="page-header border">
        <div class="page-leftheader">
            <h4 class="page-title">Edit master code</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit master code</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 panelSep border">
            <div class="panel panel-primary tabs-style-4">
                <div class="tab-menu-heading">
                    <div class="tabs-menu">
                        <!-- Tabs -->
                        @include('layouts.active-links')

                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <div class="panel panel-default tabs-style-4">
                <div class="panel-body tabs-menu-body border">
                    <div class="tab-content">
                        <section id="Approved_suppliers">
                            <h3 class="heading text-primary">Edit master code</h3>

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

                            <form id="myForm" action="{{ route('update-master-code') }}" method="POST">
                                @csrf
                                <div class="formSep">
                                    <div class="row">
                                        @foreach ($record_code as $item)
                                            <input type="hidden" name="user_id" id="user_id"
                                                value="{{ $LoggedUserAdmin['id'] }}">
                                            <input type="hidden" name="mc_id" id="mc_id" value="{{ $item->mc_id }}">

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label for="md_master_code_id" class="form-label">Master Code</label>
                                                <input class="form-control" type="text" name="md_master_code_id"
                                                    value="{{ $item->mc_code }}" id="md_master_code_id">
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label for="mc_name" class="form-label">Master Code Name</label>
                                                <input class="form-control" type="text" name="mc_name"
                                                    value="{{ $item->mc_name }}" id="mc_name">
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label for="mc_description" class="form-label">Master Code Description</label>
                                                <input class="form-control" type="text" name="mc_description"
                                                    value="{{ $item->mc_description }}" id="mc_description">
                                            </div>

                                        @endforeach

                                        <div class="col-sm-12">
                                            <button class="btn btn-primary w-100"><i class="fa fa-fw fa-save"></i>
                                                Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </section>

                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
    </div>

    <br> <br>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'Please confirm you want to master code',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Form submission after confirmation
                }
            });
        });
    });
</script>

@section('scripts')
@endsection

@section('js')
@endsection
