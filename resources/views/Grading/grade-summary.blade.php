<?php
use App\Http\Controllers\Helper;
?>
@extends('layouts-side-bar.master')

@section('content')
    <div class="side-app">

        <!-- Header Row -->
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header text-white">
                        @include('layouts.grading-buttons')
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Exam Results Summary</h4>
                    </div>

                    <div class="card-body">

                        @if($results->isEmpty())
                            <div class="alert alert-warning">
                                No results found for this exam.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Rank</th>
                                            <th>Student Name</th>
                                            <th>School Name</th>
                                            <th>Total Marks</th>
                                            <th>Average</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results as $student)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-success">
                                                        {{ $student->rank }}
                                                    </span>
                                                </td>
                                                <td>{{ $student->student_name }}</td>
                                                <td>{{ $student->stu }}</td>
                                                <td>{{ number_format($student->total_marks, 2) }}</td>
                                                <td>{{ number_format($student->average_marks, 2) }}%</td>
                                                <td>
                                                    <span class="badge 
                                                                @if($student->grade == 'A') bg-success
                                                                @elseif($student->grade == 'B') bg-success
                                                                @elseif($student->grade == 'C') bg-success
                                                                @elseif($student->grade == 'D') bg-success
                                                                @else bg-success
                                                                @endif
                                                            ">
                                                        {{ $student->grade }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection