@extends('layouts.app')

@section('title', 'Department Grievances')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Department Grievances <small class="text-muted">({{ auth()->user()->department->name ?? 'N/A' }})</small></h3>
</div>

<div class="card">
    <div class="card-body">
        <form class="row g-2 mb-3" method="GET">
            <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search ticket or subject..." value="{{ request('search') }}"></div>
            <div class="col-md-2"><select name="status" class="form-select"><option value="">All Status</option><option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option><option value="under_review" {{ request('status')=='under_review'?'selected':'' }}>Under Review</option><option value="in_progress" {{ request('status')=='in_progress'?'selected':'' }}>In Progress</option><option value="resolved" {{ request('status')=='resolved'?'selected':'' }}>Resolved</option><option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option><option value="closed" {{ request('status')=='closed'?'selected':'' }}>Closed</option></select></div>
            <div class="col-md-2"><select name="priority" class="form-select"><option value="">All Priority</option><option value="low" {{ request('priority')=='low'?'selected':'' }}>Low</option><option value="medium" {{ request('priority')=='medium'?'selected':'' }}>Medium</option><option value="high" {{ request('priority')=='high'?'selected':'' }}>High</option><option value="urgent" {{ request('priority')=='urgent'?'selected':'' }}>Urgent</option></select></div>
            <div class="col-md-1"><button type="submit" class="btn btn-outline-dark w-100"><i class="bi bi-search"></i></button></div>
        </form>

        <table class="table table-hover">
            <thead><tr><th>Ticket</th><th>Citizen</th><th>Subject</th><th>Category</th><th>Priority</th><th>Status</th><th>Date</th><th></th></tr></thead>
            <tbody>
                @forelse($grievances as $g)
                <tr>
                    <td><strong>{{ $g->ticket_id }}</strong></td>
                    <td>{{ $g->user->name }}</td>
                    <td>{{ Str::limit($g->subject, 35) }}</td>
                    <td>{{ $g->category->name }}</td>
                    <td><span class="badge badge-priority-{{ $g->priority }}">{{ ucfirst($g->priority) }}</span></td>
                    <td><span class="badge bg-{{ $g->status === 'resolved' ? 'success' : ($g->status === 'rejected' ? 'danger' : ($g->status === 'pending' ? 'warning' : 'info')) }}">{{ ucfirst(str_replace('_',' ',$g->status)) }}</span></td>
                    <td><small>{{ $g->created_at->format('d M Y') }}</small></td>
                    <td><a href="{{ route('officer.grievances.show', $g) }}" class="btn btn-sm btn-outline-dark"><i class="bi bi-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">No grievances in your department</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $grievances->links() }}
    </div>
</div>
@endsection
