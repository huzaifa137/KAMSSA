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
                            <i class="bi bi-list-check me-2"></i> Manage Exam
                        </h4>
                        <a href="{{ route('edit.exams') }}" class="btn btn-outline-light ms-auto text-white">
                            <i class="bi bi-gear me-2"></i> Edit Exams
                        </a>
                    </div>

                    <div class="col-12">
                        @php
                            $terms = [
                                26 => 'Term 1',
                                29 => 'Term 2',
                                30 => 'Term 3',
                            ];
                        @endphp

                        @foreach ($terms as $termKey => $termName)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4 class="mb-0">{{ $termName }} - {{ $activeYear }}</h4>
                                </div>

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered  mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Exam</th>
                                                    <th>Class</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if(isset($exams[$termKey]) && $exams[$termKey]->count())

                                                    @foreach ($exams[$termKey] as $exam)

                                                        @php
                                                            $classIds = json_decode($exam->ce_class_ids, true);
                                                        @endphp

                                                        @foreach ($classIds as $index => $classId)

                                                            <tr class="{{ $exam->ce_status == 'Published' ? 'table-success' : '' }}">
                                                                @if ($index == 0)
                                                                    <td rowspan="{{ count($classIds) }}">
                                                                        {{ $exam->ce_exam_name }}
                                                                    </td>
                                                                @endif

                                                                <td>
                                                                    {{ Helper::item_md_name($classId) }}
                                                                </td>

                                                                <td>
                                                                    @if ($exam->ce_exam_status == 0)
                                                                        <span class="badge bg-secondary">
                                                                            Results Not Uploaded
                                                                        </span>
                                                                    @elseif ($exam->ce_exam_status == 1)
                                                                        <span class="badge bg-warning text-dark">
                                                                            Results Uploaded & Computed
                                                                        </span>
                                                                    @elseif ($exam->ce_exam_status == 2)
                                                                        <span class="badge bg-success">
                                                                            Results Published
                                                                        </span>
                                                                    @else
                                                                        <span class="badge bg-dark">
                                                                            Unknown Status
                                                                        </span>
                                                                    @endif
                                                                </td>

                                                                <td class="text-center">
                                                                    <a href="#" class="btn btn-sm btn-outline-secondary">
                                                                        <i class="bi bi-pencil"></i> Edit Exam
                                                                    </a>

                                                                    <a href="#" class="btn btn-sm btn-outline-dark">
                                                                        <i class="bi bi-journal-text"></i> Subject Papers
                                                                    </a>

                                                                    @if($exam->ce_status == 'Published')
                                                                        <a href="#" class="btn btn-sm btn-info">
                                                                            <i class="bi bi-bar-chart"></i> Analyze Results
                                                                        </a>
                                                                    @else
                                                                        <a href="#" class="btn btn-sm btn-success">
                                                                            <i class="bi bi-upload"></i> Publish Results
                                                                        </a>
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                        @endforeach

                                                    @endforeach

                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted py-4">
                                                            No exams created for {{ $termName }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        @endforeach
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

<!-- Load jQuery and SweetAlert2 from CDNs -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>