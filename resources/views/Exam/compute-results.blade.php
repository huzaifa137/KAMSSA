<?php
use App\Http\Controllers\Helper; 
?>
@extends('layouts-side-bar.master')
@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <div class="side-app">
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        @include('layouts.exam-buttons')
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card bg-primary">
                    <div class="card-header d-flex justify-content-between align-items-center mb-5">
                        <h4 class="card-title mb-0 text-white">
                            <i class="bi bi-list-check me-2"></i> Generate Exams
                        </h4>
                    </div>

                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Exam</th>
                                        <th>Class</th>
                                        <th>Students</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Report Card</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($pendingComputations as $key => $row)

                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>
                                                {{ Helper::db_item_from_column('created_exams', $row->exam_id, 'ce_exam_name') }}
                                            </td>

                                            <td>
                                                {{ Helper::item_md_name($row->class_id) }}
                                            </td>

                                            <td>
                                                {{ $row->students }}
                                            </td>

                                            <td>
                                                @if ($row->compute_status == 1)
                                                    <span class="badge bg-warning text-dark">Pending Computation</span>
                                                @else
                                                    <span class="badge bg-success">Computed</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                @if ($row->compute_status == 1)
                                                    <form action="{{ route('exams.compute.results') }}" method="POST"
                                                        onsubmit="return confirm('Compute results for this class?');">
                                                        @csrf
                                                        <input type="hidden" name="exam_id" value="{{ $row->exam_id }}">
                                                        <input type="hidden" name="class_id" value="{{ $row->class_id }}">

                                                        <button class="btn btn-sm btn-success">
                                                            <i class="bi bi-calculator"></i> Compute & Download PDF
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('exams.download.ranked', ['exam' => $row->exam_id, 'class' => $row->class_id]) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bi bi-download"></i> Download PDF
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($row->compute_status != 1)
                                                    <form
                                                        action="{{ route('exams.download.reportcard', ['exam' => $row->exam_id, 'class' => $row->class_id]) }}"
                                                        method="GET">
                                                        <button class="btn btn-sm btn-secondary">
                                                            <i class="bi bi-file-earmark-pdf"></i> Download Report Card
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                No results pending computation
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    </div>
    </div>
    </div>
    </div>


@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>