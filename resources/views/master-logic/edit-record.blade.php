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
            <h4 class="page-title">Edit Master Record</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Record</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-primary tabs-style-4">
                <div class="tab-menu-heading">
                    <div class="tabs-menu">
                        @include('layouts.active-links')
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="panel panel-default tabs-style-4">
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content">
                        <section id="Approved_suppliers" class="border">
                            <h3 class="heading text-primary">Edit Record</h3>
                            @foreach ($tb_record as $item)
                                <form id='myForm' action="{{ route('update-master-record') }}" method="POST">
                                    @csrf
                                    <div class="formSep">
                                        <div class="row">
                                            <input type="hidden" name="md_id" value="{{ $item->md_id }}">
                                            <input type="hidden" name="record_id" value="{{ $item->md_id }}">

                                            <div class="col-sm-3 col-md-3 mb-3">
                                                <label for="md_master_code_id">Master Code Name</label>
                                                <select name="md_master_code_id" id="md_master_code_id" class="form-control"
                                                    readonly>
                                                    <option value="{{ $master_code_id }}">{{ $master_code_name }}</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-3 col-md-3 mb-3">
                                                <label for="md_code">Master Data Code</label>
                                                <input class="form-control" type="text" name="md_code"
                                                    value="{{ $item->md_code }}">
                                            </div>

                                            <div class="col-sm-3 col-md-3 mb-3">
                                                <label for="md_name">Master Data Name</label>
                                                <input class="form-control" type="text" name="md_name" id="md_name"
                                                    value="{{ $item->md_name }}">
                                            </div>

                                            <div class="col-sm-3 col-md-3 mb-3">
                                                <label for="md_description">Master Data Description</label>
                                                <input class="form-control" type="text" name="md_description"
                                                    id="md_description" value="{{ $item->md_description }}">
                                            </div>

                                            <div class="col-sm-12 text-right">

                                                <button class="btn btn-primary" id="add_new_data"><i
                                                        class="fa fa-fw fa-save"></i> Save</button>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            @endforeach
                    </div>
                </div>
            </div>

            </section>

        </div>
    </div>
    </div>
    </div>
    </div>
@endsection

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
    document.addEventListener('DOMContentLoaded', function() {
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
