@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Reminder Settings</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.reminders.update') }}">
                        @csrf
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="send_vaccination" name="send_vaccination" value="1" {{ ($settings?->send_vaccination ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="send_vaccination">Send vaccination reminders</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="send_followup" name="send_followup" value="1" {{ ($settings?->send_followup ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="send_followup">Send next clinic reminders</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lead days (comma separated)</label>
                            <input type="text" name="lead_days" class="form-control" value="{{ isset($settings?->lead_days) ? implode(',', $settings->lead_days) : '1,3,7' }}">
                            <div class="form-text">Example: 1,3,7 means send 1, 3, and 7 days before due.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">From email</label>
                            <input type="email" name="from_email" class="form-control" value="{{ $settings?->from_email }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">From name</label>
                            <input type="text" name="from_name" class="form-control" value="{{ $settings?->from_name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reply-to email</label>
                            <input type="email" name="reply_to" class="form-control" value="{{ $settings?->reply_to }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save settings</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Reminder Log</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Client</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Sent At</th>
                                    <th>Error</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td class="text-uppercase small">{{ $log->reminder_type }}</td>
                                        <td>{{ $log->pet?->name ?? '—' }}</td>
                                        <td>{{ $log->owner_email ?? '—' }}</td>
                                        <td>
                                            @if($log->status === 'sent')
                                                <span class="badge bg-success">Sent</span>
                                            @else
                                                <span class="badge bg-danger">Failed</span>
                                            @endif
                                        </td>
                                        <td>{{ optional($log->sent_at)->format('Y-m-d H:i') }}</td>
                                        <td class="text-truncate" style="max-width: 240px;">{{ $log->error_message ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No reminders sent yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
