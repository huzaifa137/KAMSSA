<?php
use App\Http\Controllers\Helper;
use App\Http\Controllers\Controller;
$controller = new Controller();
?>
@extends('layouts-side-bar.master')
@section('css')
    <!---jvectormap css-->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
@endsection
@section('content')
    <br> <br>
    <h3>Contact US</h3>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="panel panel-primary w-100">
                <div class="tab-menu-heading crypto-tabs">
                    <div class="tabs-menu1">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class=""><a href="#tab5" class="active" data-toggle="tab">Send Message</a></li>
                            <li><a href="#tab6" data-toggle="tab" class="">My Messages</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card panel-body tabs-menu-body br-tl-0 border-top-0 p-6 w-100 shadow2 crypto-content">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab5">
                            <div class="mb-0 border">
                                <form id="messageForm" action="{{ route('student.submit.message') }}" method="POST">
                                    @csrf
                                    <div class="card-body text-center">
                                        <div class="text-left text-dark">
                                            <h3 style="color: #026837;">Send us a message </h3>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6" style="display: none;">
                                                    <label class="form-label float-left" for="studentEmail">Student
                                                        Email</label>
                                                    <input type="text" id="studentEmail" name="studentEmail"
                                                        value="{{ $studentEmail }}" class="form-control" required readonly>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label float-left" for="subject">Subject of
                                                        message</label>
                                                    <input type="text" id="subject" name="subject"
                                                        placeholder="Please provide a subject for your message"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label float-left" for="message">Message to
                                                        UgandanProgrammer</label>
                                                    <textarea id="message" name="message" class="form-control" style="height: 300px; width: 100%;"
                                                        placeholder="Please provide your message to the ugandanProgrammer admnistrators" required></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" id="submitMessage" class="btn btn-block btn-primary">Send
                                            Message</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-dark">All Messages</h5>

                                    @if ($messages->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table card-table table-vcenter text-nowrap table-primary mb-0">
                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th class="text-white">#</th>
                                                        <th class="text-white">Email</th>
                                                        <th class="text-white">Subject</th>
                                                        <th class="text-white">Date Sent</th>
                                                        <th class="text-white">Status</th>
                                                        <th class="text-white">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($messages as $index => $message)
                                                        <tr>
                                                            <td style="width: 1px;">{{ $index + 1 }}</td>
                                                            <td>{{ $message->student_email }}</td>
                                                            <td>{{ $message->student_subject }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($message->date_added)->format('Y-m-d H:i') }}
                                                            </td>
                                                            <td>
                                                                @if ($message->admin_response_status == 1)
                                                                    <span class="badge badge-success">Responded</span>
                                                                @else
                                                                    <span class="badge badge-warning">Pending
                                                                        Response</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-info" data-toggle="modal"
                                                                    data-target="#messageModal{{ $message->id }}">
                                                                    <i class="fas fa-envelope-open-text mr-1"></i> View
                                                                    Message
                                                                </button>
                                                            </td>
                                                        </tr>

                                                        <!-- Move the modal here, inside the loop -->
                                                        <div class="modal fade" id="messageModal{{ $message->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="messageModalLabel{{ $message->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-primary text-white">
                                                                        <h5 class="modal-title"
                                                                            id="messageModalLabel{{ $message->id }}">
                                                                            Student Message Details
                                                                        </h5>
                                                                        <button type="button" class="close text-white"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p><strong>Email:</strong>
                                                                            {{ $message->student_email }}</p>
                                                                        <p><strong>Subject:</strong>
                                                                            {{ $message->student_subject }}
                                                                        </p>
                                                                        <p><strong>Message:</strong></p>
                                                                        <div
                                                                            style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; text-align: justify;">
                                                                            {{ $message->student_message }}
                                                                        </div>
                                                                        <hr>
                                                                        <p><strong>Date Sent:</strong>
                                                                            {{ \Carbon\Carbon::parse($message->date_added)->format('Y-m-d H:i') }}
                                                                        </p>

                                                                        @if ($message->admin_response_status == 0)
                                                                            <p style="color: rgb(255, 174, 0) !important;"><strong>Admin Response Pending</strong></p>
                                                                        @else
                                                                            <p><strong>Admin Response:</strong></p>
                                                                            <div
                                                                                style="background-color: #f1f1f1; padding: 15px; border-radius: 5px; text-align: justify;">
                                                                                {{ $message->admin_response_message }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="text-muted">No messages submitted yet.</p>
                                    @endif
                                </div>
                            </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        const form = $('#messageForm');
        const submitBtn = $('#submitMessage');

        form.on('submit', function(e) {
            e.preventDefault();


            const studentEmail = $('#studentEmail').val().trim();
            const subject = $('#subject').val().trim();
            const message = $('#message').val().trim();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            if (!studentEmail || !subject || !message) {
                let missing = [];
                if (!studentEmail) missing.push("Student Email");
                if (!subject) missing.push("Subject");
                if (!message) missing.push("Message");

                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Fields',
                    text: `Please fill in the following: ${missing.join(', ')}`
                });
                return;
            }

            Swal.fire({
                title: 'Send this message?',
                text: "You're about to send this message to the admin.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, send it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitBtn.prop('disabled', true).html(
                        'Sending... <i class="fas fa-spinner fa-spin"></i>');

                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: {
                            _token: csrfToken,
                            studentEmail: studentEmail,
                            subject: subject,
                            message: message
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Message Sent',
                                text: 'Your message has been delivered.'
                            }).then(() => {
                                form[0].reset();
                                submitBtn.prop('disabled', false).html(
                                    'Send Message');
                                location.reload();
                            });
                        },
                        error: function(data) {
                            $('body').html(data.responseText);
                        }
                    });
                }
            });
        });
    });
</script>

@section('js')
    <!-- ECharts js -->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <!-- Peitychart js-->
    <script src="{{ URL::asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/peitychart.init.js') }}"></script>
    <!-- Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!---jvectormap js-->
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.world.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.sampledata.js') }}"></script>
    <!-- Index js-->
    <script src="{{ URL::asset('assets/js/index1.js') }}"></script>
    <!-- Data tables js-->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datatables.js') }}"></script>
    <!--Counters -->
    <script src="{{ URL::asset('assets/plugins/counters/counterup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/counters/waypoints.min.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
@endsection
