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
            <h4 class="page-title">Add Record</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Record</li>
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
                <div class="panel-body tabs-menu-body border">
                    <div class="tab-content">
                        <section id="Approved_suppliers">
                            <h3 class="heading text-primary">Add Record</h3>

                            <form id="myForm" action="{{ route('add-new-record') }}" method="POST">

                                @csrf
                                <div class="formSep">

                                    <div class="row">
                                        <input type="hidden" name="user_id" id="user_id"
                                            value="{{ $LoggedUserAdmin['id'] }}">

                                        <div class="col-sm-3 col-md-3">
                                            <label for="">Master code name</label>
                                            <select name="master_code_id" id="master_code_id" class="form-control">
                                                @foreach ($selected as $item)
                                                    <option value="{{ $item->id }}">{{ $item->mc_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-sm-3 col-md-3">
                                            <label for="">master data code</label>
                                            <input class="form-control" type="text" name="md_code" id="md_code"
                                                required>
                                        </div>


                                        <div class="col-sm-3 col-md-3">
                                            <label for="mask_product"> master data name</label>
                                            <input class="form-control" type="text" name="md_name" id="md_name"
                                                required>
                                        </div>

                                        <div class="col-sm-3 col-md-3 ">
                                            <label for="">master data description</label>
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


                                        <div class="clearfix"></div>
                                        <br>
                                        <div class="col-sm-3 col-md-3">
                                            <button class="btn btn-primary btn-sm" id="add_new_data"><i
                                                    class="fa fa-fw fa-save"></i> Save</button>
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
@endsection

@section('scripts')
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


    <script>
        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
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
    </script>
@endsection


@section('js')
@endsection
