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
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Create new code</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Create new code</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')


    <div class="row">
        <div class="col-md-3 panelSep">
            <div class="panel panel-primary tabs-style-4">
                <div class="tab-menu-heading">
                    <div class="tabs-menu">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            @foreach ($links as $key => $link)
                                <li>
                                    <a class="{{ $key == 0 ? 'active' : '' }}" href="{{ url($link['link_address']) }}">
                                        {{ $link['link_name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <div class="panel panel-default tabs-style-4">
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content">
                        <section id="Approved_suppliers">
                            <h3 class="heading text-primary">Create new code</h3>

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


                            <form id='myForm' action="{{ route('send-master-code') }}" method="POST">
                                @csrf
                                <div class="formSep">

                                    <div class="row">

                                        <input type="hidden" name="user_id" id="user_id"
                                            value="{{ $LoggedUserAdmin['id'] }}">

                                        <div class="col-sm-3 col-md-3 mb-3">
                                            <label for="mc_code">Master code</label>
                                            <input class="form-control" type="text" name="mc_code" id="mc_code"
                                                required>
                                        </div>

                                        <div class="col-sm-3 col-md-3 mb-3">
                                            <label for="mc_name">Master code name</label>
                                            <input class="form-control" type="text" name="mc_name" id="mc_name">
                                        </div>

                                        <div class="col-sm-3 col-md-3 mb-3">
                                            <label for="mc_description">Master description</label>
                                            <textarea class="form-control" name="mc_description" id="mc_description" required></textarea>
                                        </div>

                                        <div class="col-sm-12">
                                            <button class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Save</button>
                                        </div>

                                    </div>
                                </div>
                            </form>

                        </section>

                        <style>
                            .nav.panel-tabs {
                                display: flex;
                                justify-content: space-around;
                                /* This distributes the tabs evenly */
                                padding-left: 0;
                                margin-bottom: 0;
                                list-style: none;
                            }

                            .nav.panel-tabs li a {
                                padding: 10px 20px;
                                border-radius: 5px;
                                background-color: #f8f9fa;
                                text-align: center;
                                text-decoration: none;
                            }

                            .nav.panel-tabs li a.active {
                                background-color: #007bff;
                                color: white;
                            }

                            .nav.panel-tabs li a:hover {
                                background-color: #e9ecef;
                                color: #007bff;
                            }

                            .w-5 {
                                display: none;
                            }

                            .nav.panel-tabs a {
                                font-size: 14px;
                                padding: 10px 15px;
                            }

                            .heading {
                                font-size: 20px;
                                font-weight: bold;
                            }

                            .btn {
                                font-size: 13px;
                            }

                            table th,
                            table td {
                                font-size: 13px;
                            }

                            .formSep {
                                padding: 15px;
                                border: 1px solid #ddd;
                                margin-bottom: 20px;
                                border-radius: 5px;
                            }

                            .mb-3 {
                                margin-bottom: 1rem;
                            }

                            .panelSep {
                                padding: 15px;
                                border: 1px solid #ddd;
                                margin-bottom: 20px;
                                border-radius: 5px;
                            }
                        </style>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection



<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'Pleas confirm you want to save this code',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>

@section('scripts')
@endsection

@section('js')
@endsection
