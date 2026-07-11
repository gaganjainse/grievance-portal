@extends('layouts.app')

@section('title', 'Grievance #'.$grievance->ticket_id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Grievance #{{ $grievance->ticket_id }}</h3>
    <a href="{{ route('admin.grievances.index') }}" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $grievance->subject }}</h5>
                <p class="text-muted">{{ $grievance->description }}</p>

                @if($grievance->location)
                    <p><i class="bi bi-geo-alt"></i> {{ $grievance->location }} @if($grievance->pincode) - {{ $grievance->pincode }} @endif</p>
                @endif

                @if($grievance->attachments->count() > 0)
                    <h6 class="mt-3">Attachments</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($grievance->attachments as $att)
                            <a href="{{ asset('storage/' . $att->stored_path) }}" target="_blank" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-paperclip"></i> {{ $att->original_name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white"><strong>Comments</strong></div>
            <div class="card-body">
                @foreach($grievance->comments as $comment)
                    <div class="d-flex mb-3">
                        <div class="me-2"><i class="bi bi-person-circle" style="font-size:1.5rem;"></i></div>
                        <div>
                            <strong>{{ $comment->user->name }}</strong>
                            <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                            <p class="mb-0">{{ $comment->body }}</p>
                        </div>
                    </div>
                @endforeach
                <hr>
                <form method="POST" action="{{ route('admin.grievances.status', $grievance) }}">
                    @csrf
                    <div class="mb-2">
                        <select name="status" class="form-select">
                            <option value="under_review" {{ $grievance->status == 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="in_progress" {{ $grievance->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ $grievance->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="rejected" {{ $grievance->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="closed" {{ $grievance->status == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <textarea name="resolution_notes" class="form-control" rows="2" placeholder="Resolution notes (required for resolved/rejected)">{{ $grievance->resolution_notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-dark btn-sm"><i class="bi bi-check-circle"></i> Update Status</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header bg-white"><strong>Details</strong></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><td>Status</td><td><span class="badge bg-{{ $grievance->status === 'resolved' ? 'success' : ($grievance->status === 'rejected' ? 'danger' : ($grievance->status === 'pending' ? 'warning' : 'info')) }}">{{ ucfirst(str_replace('_',' ',$grievance->status)) }}</span></td></tr>
                    <tr><td>Priority</td><td><span class="badge badge-priority-{{ $grievance->priority }}">{{ ucfirst($grievance->priority) }}</span></td></tr>
                    <tr><td>Department</td><td>{{ $grievance->department->name }}</td></tr>
                    <tr><td>Category</td><td>{{ $grievance->category->name }}</td></tr>
                    <tr><td>Citizen</td><td>{{ $grievance->user->name }}<br><small>{{ $grievance->user->email }}</small></td></tr>
                    <tr><td>Submitted</td><td>{{ $grievance->submitted_at->format('d M Y h:i A') }}</td></tr>
                    @if($grievance->assignedOfficer)
                    <tr><td>Assigned To</td><td>{{ $grievance->assignedOfficer->name }}</td></tr>
                    @endif
                    @if($grievance->resolved_at)
                    <tr><td>Resolved At</td><td>{{ $grievance->resolved_at->format('d M Y h:i A') }}</td></tr>
                    @endif
                </table>
            </div>
        </div>

        @if(!$grievance->assigned_to)
        <div class="card">
            <div class="card-header bg-white"><strong>Assign Officer</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.grievances.assign', $grievance) }}">
                    @csrf
                    <div class="mb-2">
                        <select name="assigned_to" class="form-select" required>
                            <option value="">Select officer...</option>
                            @foreach($officers as $o)
                                <option value="{{ $o->id }}">{{ $o->name }} ({{ $o->department->name ?? 'No Dept' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark btn-sm w-100"><i class="bi bi-person-check"></i> Assign</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
