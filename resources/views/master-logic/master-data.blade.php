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
            <h4 class="page-title">Master Data</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Master Data</li>
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
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h3 class="heading text-primary" style="margin: 0;">Master Data</h3>
                                <a href="{{ url('master-data/add-record') }}" class="btn btn-primary btn-sm"
                                    style="display: inline-block;">Add a
                                    record</a>
                            </div>

                            <table class="table table-bordered table-striped" id="table">
                                <br>
                                <thead>
                                    <tr>
                                        <th>Master Code</th>
                                        <th>Data Code</th>
                                        <th>Data Name</th>
                                        <th class="text-center">Data Description</th>
                                        <th>Date Added</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mc_code as $item)
                                        <tr>
                                            <td>{{ $item->mc_code }}</td>
                                            <td>{{ $item->md_code }}</td>
                                            <td>{{ $item->md_name }}</td>
                                            <td>{{ $item->md_description }}</td>
                                            <td>{{ Helper::date_fm($item->md_date_added) }}</td>
                                            <td class="text-center" style="width: 160px;">

                                                <a href="{{ url('master-data/edit-record/' . $item->md_id) }}"
                                                    class="btn btn-sm btn-primary edit-record-btn"
                                                    data-url="{{ url('master-data/edit-record/' . $item->md_id) }}">
                                                    Edit
                                                </a>

                                                <a href="{{ url('delete-record/' . $item->md_id) }}"
                                                    class="btn btn-sm btn-danger delete-record-btn">
                                                    Delete
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
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
                            background-color: #026837;
                            color: white;
                        }

                        .nav.panel-tabs li a:hover {
                            background-color: #e9ecef;
                            color: #026837;
                        }


                        .heading {
                            font-size: 20px;
                            font-weight: bold;
                        }

                        table th,
                        table td {
                            font-size: 13px;
                        }

                        .btn {
                            font-size: 13px;
                        }

                        .btn-sm {
                            padding: 5px 10px;
                        }

                        .table-responsive {
                            overflow-x: auto;
                        }

                        .w-5 {
                            display: none;
                        }

                        .nav.panel-tabs a {
                            font-size: 14px;
                            padding: 10px 15px;
                        }

                        .panelSep {
                            padding: 15px;
                            border: 1px solid #ddd;
                            margin-bottom: 20px;
                            border-radius: 5px;
                        }
                    </style>

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
                        document.querySelectorAll('.delete-record-btn').forEach(function(btn) {
                            btn.addEventListener('click', function(event) {
                                event.preventDefault(); // Prevent the default link behavior

                                Swal.fire({
                                    title: 'Are you sure ?',
                                    text: 'Please confirm before you delete this record!',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // If confirmed, redirect to the href (deletion URL)
                                        window.location.href = this.href;
                                    }
                                });
                            });
                        });

                        document.querySelectorAll('.edit-record-btn').forEach(function(button) {
                            button.addEventListener('click', function(event) {
                                event.preventDefault();

                                let url = this.getAttribute('data-url');

                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You are about to edit this record!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, edit it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = url;
                                    }
                                });
                            });
                        });
                    </script>


                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
