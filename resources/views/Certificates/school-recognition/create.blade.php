@extends('layouts-side-bar.master')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-p1B9XJvxXlJ0sFh1ExAmH4y3L1kGk+x+r6Gx7q6v5+PgfKhnYzOZ3xGlKEX2eVZCMu1k7r1R7pLLj5p2lP2vXw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content')
    <div class="side-app">
        <div class="page-header">
            <h4 class="page-title">Issue Recognition Certificate</h4>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-sm border-0" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-header"
                        style="background: linear-gradient(135deg, #026837 0%, #c51619 100%); padding: 1.2rem 1.6rem;">
                        <h5 class="mb-0 text-white font-weight-bold">
                            <i class="fas fa-stamp mr-2"></i> Issue New School Recognition Certificate
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('school.recognition.store') }}" method="POST">
                            @csrf

                            <div class="form-group mb-4">
                                <label class="font-weight-semibold text-dark">
                                    <i class="fas fa-school mr-1 text-success"></i> Select School
                                </label>
                                <select name="house_number" class="form-control select2" required
                                    style="border-radius: 10px; border: 1.5px solid #ced4da; padding: 0.55rem 1rem;">
                                    <option value="">— Select a school —</option>
                                    @foreach($houses as $house)
                                        <option value="{{ $house->Number }}" {{ old('house_number') == $house->Number ? 'selected' : '' }}>
                                            {{ $house->Number }} — {{ $house->House }}
                                            @if($house->Location) ({{ $house->Location }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">A school can only hold one active certificate at a time.</small>
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-semibold text-dark">
                                    <i class="fas fa-calendar-alt mr-1 text-success"></i> Date of Issue
                                </label>
                                <input type="date" name="issued_date" class="form-control"
                                    value="{{ old('issued_date', date('Y-m-d')) }}" required
                                    style="border-radius: 10px; border: 1.5px solid #ced4da;">
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-semibold text-dark">
                                    <i class="fas fa-user-tie mr-1 text-success"></i> Issued By (Signing Officer)
                                </label>
                                <input type="text" name="issued_by" class="form-control"
                                    value="{{ old('issued_by', 'Executive Secretary (ITEBU)') }}"
                                    placeholder="e.g. Executive Secretary (ITEBU)"
                                    style="border-radius: 10px; border: 1.5px solid #ced4da;">
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-semibold text-dark">
                                    <i class="fas fa-sticky-note mr-1 text-success"></i> Internal Notes
                                    <span class="text-muted font-weight-normal">(optional)</span>
                                </label>
                                <textarea name="notes" class="form-control" rows="3"
                                    placeholder="Any internal remarks about this certificate..."
                                    style="border-radius: 10px; border: 1.5px solid #ced4da;">{{ old('notes') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ route('school.recognition.index') }}" class="btn btn-outline-secondary"
                                    style="border-radius: 10px; padding: 0.5rem 1.4rem;">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </a>
                                <button type="submit" class="btn btn-success font-weight-bold"
                                    style="border-radius: 10px; padding: 0.55rem 2rem; background: #026837; border-color: #026837;">
                                    <i class="fas fa-certificate mr-2"></i> Issue Certificate
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
        </div>
    </div>

    <!-- Hidden Reactivate Form -->
    <form id="reactivate-form" method="POST" action="" class="d-none">
        @csrf
        @method('POST')
    </form>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check for validation errors
        @if($errors->any())
            let errorMessages = '<ul style="text-align: left;">';
            @foreach($errors->all() as $error)
                errorMessages += '<li>{{ addslashes($error) }}</li>';
            @endforeach
            errorMessages += '</ul>';

            Swal.fire({
                title: 'Validation Error!',
                html: errorMessages,
                icon: 'error',
                confirmButtonColor: '#026837',
                confirmButtonText: 'OK'
            });
        @endif

        // Check for success
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                html: '{!! addslashes(session('success')) !!}',
                icon: 'success',
                confirmButtonColor: '#026837',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('school.recognition.index') }}';
                }
            });
        @endif

        // Check for error (simple format)
        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                html: '{!! addslashes(session('error')) !!}',
                icon: 'error',
                confirmButtonColor: '#026837',
                confirmButtonText: 'OK'
            });
        @endif

        // Check for structured alert
        @if(session()->has('alert'))
            const alert = @json(session('alert'));
            const swalOptions = {
                title: alert.title || 'Error!',
                html: alert.message,
                icon: alert.icon || 'error',
                confirmButtonColor: '#026837',
                confirmButtonText: alert.confirmButtonText || 'OK',
            };

            if (alert.showCancelButton) {
                swalOptions.showCancelButton = true;
                swalOptions.cancelButtonText = alert.cancelButtonText || 'Cancel';
                swalOptions.cancelButtonColor = '#6c757d';
            }

            Swal.fire(swalOptions).then((result) => {
                if (result.isConfirmed && alert.certificateId) {
                    // Submit the reactivate form
                    const form = document.getElementById('reactivate-form');
                    form.action = `{{ url('school-recognition') }}/${alert.certificateId}/reactivate`;
                    form.submit();
                }
            });
        @endif
    });
</script>