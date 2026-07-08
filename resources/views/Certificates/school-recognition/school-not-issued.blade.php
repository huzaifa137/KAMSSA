@extends('layouts-side-bar.master')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-p1B9XJvxXlJ0sFh1ExAmH4y3L1kGk+x+r6Gx7q6v5+PgfKhnYzOZ3xGlKEX2eVZCMu1k7r1R7pLLj5p2lP2vXw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content')
    <div class="side-app">

        <div class="page-header">
            <h4 class="page-title">Recognition Certificate</h4>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm text-center" style="border-radius: 18px; padding: 2.5rem 2rem;">
                    <div style="font-size: 4rem; color: #026837; margin-bottom: 1rem;">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h4 class="font-weight-bold text-dark">Certificate Not Yet Issued</h4>
                    <p class="text-muted mt-2">
                        Your school (<strong>{{ $schoolName ?? $schoolNumber }}</strong>) does not yet have a
                        Recognition Certificate issued by ITEBU.
                        <br>Please contact the ITEBU secretariat to have your certificate issued.
                    </p>
                    <div class="mt-3">
                        <a href="{{ url('/school/dashboard') }}" class="btn btn-outline-secondary"
                            style="border-radius: 10px;">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    </div>
@endsection