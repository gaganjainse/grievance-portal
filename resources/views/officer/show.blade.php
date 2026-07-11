@extends('layouts.app')

@section('title', 'Grievance #'.$grievance->ticket_id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Grievance #{{ $grievance->ticket_id }}</h3>
    <a href="{{ route('officer.grievances.index') }}" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $grievance->subject }}</h5>
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
            <div class="card-header bg-white"><strong>Comments & Updates</strong></div>
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
                    <p class="text-muted">No comments yet.</p>
                @endforelse
                <hr>
                <form method="POST" action="{{ route('officer.grievances.comment', $grievance) }}">
                    @csrf
                    <div class="mb-2"><textarea name="body" class="form-control" rows="2" placeholder="Add a comment..." required></textarea></div>
                    <button type="submit" class="btn btn-dark btn-sm"><i class="bi bi-chat"></i> Add Comment</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white"><strong>Update Status</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('officer.grievances.status', $grievance) }}">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="in_progress" {{ $grievance->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $grievance->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="rejected" {{ $grievance->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="resolution_notes" class="form-control" placeholder="Resolution notes (required for resolved/rejected)" value="{{ old('resolution_notes') }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-dark w-100"><i class="bi bi-check-circle"></i> Update</button>
                        </div>
                    </div>
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
                    <tr><td>Citizen</td><td>{{ $grievance->user->name }}<br><small>{{ $grievance->user->email }}<br>{{ $grievance->user->phone ?? '' }}</small></td></tr>
                    <tr><td>Category</td><td>{{ $grievance->category->name }}</td></tr>
                    @if($grievance->location)
                    <tr><td>Location</td><td>{{ $grievance->location }} @if($grievance->pincode)({{ $grievance->pincode }})@endif</td></tr>
                    @endif
                    <tr><td>Submitted</td><td>{{ $grievance->submitted_at->format('d M Y h:i A') }}</td></tr>
                    @if($grievance->isOverdue())
                    <tr><td>Overdue</td><td><span class="badge bg-danger">Yes</span></td></tr>
                    @endif
                </table>
            </div>
        </div>

        @if(!$grievance->assigned_to)
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('officer.grievances.assign', $grievance) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-person-check"></i> Assign to Me</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
