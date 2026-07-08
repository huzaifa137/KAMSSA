@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <?php
    
    use App\Http\Controllers\AccessRightController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Helper;
    $controller = new Controller();
    $user_id = Helper::user_id();
    
    $links = UserController::links();
    
    ?>

    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Add role</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Add role</li>
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
                        @include('layouts.active-links')
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <div class="panel panel-default tabs-style-4">
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content border">
                        <section id="Approved_suppliers">
                            <h3 class="heading text-primary">Add role</h3>

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


                            <form id='myForm' action="{{ route('save-role') }}" method="POST">

                                @if (Session::get('success'))
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif

                                @if (Session::get('fail'))
                                    <div class="alert alert-danger">
                                        {{ Session::get('fail') }}
                                    </div>
                                @endif

                                @csrf
                                <div class="row">
                                    <input type="hidden" name="user_id" id="user_id"
                                        value="{{ $LoggedUserAdmin['id'] }}">

                                    <div class="col-sm-6 col-md-6 mb-3">
                                        <label for="">Enter new user role :</label>
                                        <input class="form-control" type="text" name="user_role" id="user_role" required>
                                    </div>

                                    <div class="col-sm-12">
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-fw fa-save"></i> Save</button>
                                    </div>
                                </div>
                                <style>
                                    .border {
                                        border: 1px solid #ddd;
                                        border-radius: 8px;
                                        padding: 20px;
                                        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.25);
                                        background-color: #ffffff;
                                    }
                                </style>
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
