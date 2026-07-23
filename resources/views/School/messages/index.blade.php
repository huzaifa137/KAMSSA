@extends('layouts-side-bar.master')

@section('content')
    <div class="side-app">
        <div class="container-fluid mt-3">
            <div class="card shadow-lg border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center flex-wrap gap-2"
                    style="background-color:#026837;">
                    <h4 class="mb-0"><i class="fa fa-inbox me-2"></i> Messages from the Administration</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Official messages and notices sent to your school. Click a message to
                        read it in full — it's marked as read automatically.</p>

                    @include('broadcast-messages.partials.inbox-list', [
                        'recipientRows' => $recipientRows,
                        'markReadUrlBase' => '/school/messages',
                    ])
                </div>
            </div>
        </div>
    </div>
                </div>
        </div>
    </div>
@endsection
