@extends('layouts.master')

@section('css')
    <!-- Morris Charts css -->
    <link href="{{ URL::asset('assets/plugins/morris/morris.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
@endsection
@section('content')
    <!--Row-->
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <h4 class="page-title" style="text-align: center;">User Information</h4>
            <div class="table-responsive">

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

                <div class="container">
                    <table id="table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 1px;">No.</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated via AJAX -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!--End row-->



    <!--Row-->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <!-- Add a div for showing errors -->
            <div id="error-message"
                style="display:none; background-color: red; color: white; padding: 10px; margin-top: 10px;"></div>

        </div>
    </div>

    <!--End row-->
    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>



    <script type="text/javascript">
        $(document).ready(function () {

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.user-information') }}',
                columns: [{
                    data: null,
                    name: 'serial',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'user_role',
                    name: 'user_role'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [
                    [1, 'asc']
                ], // Now column 1 is 'username', not 0
                searching: true,
                ordering: true,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            $(document).on('click', '.dropdown-toggle', function (e) {
                var $el = $(this).next('.dropdown-menu');
                var isVisible = $el.is(':visible');
                $('.dropdown-menu').hide();
                if (!isVisible) {
                    $el.show();
                }
                e.stopPropagation();
            });

            $(document).on('click', function (e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').hide();
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.delete-user', function (e) {
            e.preventDefault(); // prevent default link
            var url = $(this).attr('href');
            var name = $(this).data('name');

            Swal.fire({
                title: 'Are you sure?',
                text: `Are you sure you want to delete ${name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    </script>

@endsection