@extends('layouts.app')

@section('title', 'All Grievances')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">All Grievances</h3>
</div>

<div class="card">
    <div class="card-body">
        <form class="row g-2 mb-3" method="GET">
            <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="Search ticket or subject..." value="{{ request('search') }}"></div>
            <div class="col-md-2"><select name="status" class="form-select"><option value="">All Status</option>@foreach($statuses as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
            <div class="col-md-2"><select name="priority" class="form-select"><option value="">All Priority</option><option value="low" {{ request('priority')=='low'?'selected':'' }}>Low</option><option value="medium" {{ request('priority')=='medium'?'selected':'' }}>Medium</option><option value="high" {{ request('priority')=='high'?'selected':'' }}>High</option><option value="urgent" {{ request('priority')=='urgent'?'selected':'' }}>Urgent</option></select></div>
            <div class="col-md-2"><select name="department_id" class="form-select"><option value="">All Departments</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ request('department_id')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
            <div class="col-md-1"><button type="submit" class="btn btn-outline-dark w-100"><i class="bi bi-search"></i></button></div>
        </form>

        <table class="table table-hover">
            <thead><tr><th>Ticket</th><th>Citizen</th><th>Subject</th><th>Department</th><th>Priority</th><th>Status</th><th>Date</th><th></th></tr></thead>
            <tbody>
                @forelse($grievances as $g)
                <tr>
                    <td><strong>{{ $g->ticket_id }}</strong></td>
                    <td>{{ $g->user->name }}</td>
                    <td>{{ Str::limit($g->subject, 40) }}</td>
                    <td>{{ $g->department->name }}</td>
                    <td><span class="badge badge-priority-{{ $g->priority }}">{{ ucfirst($g->priority) }}</span></td>
                    <td><span class="badge bg-{{ $g->status === 'resolved' ? 'success' : ($g->status === 'rejected' ? 'danger' : ($g->status === 'pending' ? 'warning' : ($g->status === 'closed' ? 'secondary' : 'info'))) }}">{{ ucfirst(str_replace('_',' ',$g->status)) }}</span></td>
                    <td><small>{{ $g->created_at->format('d M Y') }}</small></td>
                    <td><a href="{{ route('admin.grievances.show', $g) }}" class="btn btn-sm btn-outline-dark"><i class="bi bi-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">No grievances found</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $grievances->links() }}
    </div>
</div>
@endsection
