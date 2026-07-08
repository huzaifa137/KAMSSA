@extends('layouts.master')
@section('css')
    <!-- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
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

            <h3 class="text-center mt-8">
                Select Group from the left menu.
            </h3>

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
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
@endsection
