@extends('layouts.app')

@section('title', 'Grievance #'.$grievance->ticket_id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Grievance #{{ $grievance->ticket_id }}</h3>
    <a href="{{ route('citizen.grievances.index') }}" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5>{{ $grievance->subject }}</h5>
                    <span class="badge badge-priority-{{ $grievance->priority }}" style="font-size:.9rem;">{{ ucfirst($grievance->priority) }}</span>
                </div>
                <p class="text-muted">{{ $grievance->description }}</p>

                @if($grievance->attachments->count() > 0)
                    <h6>Attachments</h6>
                    @foreach($grievance->attachments as $att)
                        <a href="{{ asset('storage/' . $att->stored_path) }}" target="_blank" class="btn btn-sm btn-outline-dark me-1"><i class="bi bi-paperclip"></i> {{ $att->original_name }}</a>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white"><strong>Updates & Comments</strong></div>
            <div class="card-body">
                @forelse($grievance->comments as $comment)
                    <div class="d-flex mb-3">
                        <div class="me-2"><i class="bi bi-person-circle" style="font-size:1.5rem;"></i></div>
                        <div>
                            <strong>{{ $comment->user->name }}</strong>
                            <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                            <p class="mb-0">{{ $comment->body }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No updates yet.</p>
                @endforelse

                @if(in_array($grievance->status, ['pending', 'under_review', 'in_progress']))
                    <hr>
                    <form method="POST" action="{{ route('citizen.grievances.comment', $grievance) }}">
                        @csrf
                        <div class="mb-2">
                            <textarea name="body" class="form-control" rows="2" placeholder="Add a comment or update..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark btn-sm">Add Comment</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header bg-white"><strong>Status</strong></div>
            <div class="card-body">
                <div class="grievance-timeline">
                    <div class="timeline-item"><small class="text-muted">Submitted</small><br>{{ $grievance->submitted_at->format('d M Y h:i A') }}</div>
                    @if($grievance->assigned_at)
                    <div class="timeline-item"><small class="text-muted">Assigned</small><br>{{ $grievance->assigned_at->format('d M Y h:i A') }}</div>
                    @endif
                    @if($grievance->resolved_at)
                    <div class="timeline-item"><small class="text-muted">Resolved</small><br>{{ $grievance->resolved_at->format('d M Y h:i A') }}</div>
                    @endif
                </div>
                <hr>
                <table class="table table-sm">
                    <tr><td>Status</td><td><span class="badge bg-{{ $grievance->status === 'resolved' ? 'success' : ($grievance->status === 'rejected' ? 'danger' : ($grievance->status === 'pending' ? 'warning' : 'info')) }}">{{ ucfirst(str_replace('_',' ',$grievance->status)) }}</span></td></tr>
                    <tr><td>Department</td><td>{{ $grievance->department->name }}</td></tr>
                    <tr><td>Category</td><td>{{ $grievance->category->name }}</td></tr>
                    @if($grievance->assignedOfficer)
                    <tr><td>Assigned To</td><td>{{ $grievance->assignedOfficer->name }}</td></tr>
                    @endif
                    @if($grievance->resolution_notes)
                    <tr><td>Resolution</td><td><small>{{ $grievance->resolution_notes }}</small></td></tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
