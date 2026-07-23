@extends('layouts-side-bar.master')

@section('content')
    <div class="side-app">
        <div class="container-fluid mt-3">
            <div class="card shadow-lg border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center flex-wrap gap-2"
                    style="background-color:#026837;">
                    <h4 class="mb-0"><i class="fa fa-inbox me-2"></i> My Inbox</h4>
                    <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-light px-3 py-2 rounded-pill">
                        <span style="color:#FFF;"><i class="fa fa-bullhorn me-2"></i> Notifications Hub</span>
                    </a>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Messages sent directly to your system-user account. Click a message to
                        read it in full — it's marked as read automatically.</p>

                    @include('broadcast-messages.partials.inbox-list', [
                        'recipientRows' => $recipientRows,
                        'markReadUrlBase' => '/notifications/inbox',
                    ])
                </div>
            </div>
        </div>
    </div>
               </div>
        </div>
    </div>
@endsection
