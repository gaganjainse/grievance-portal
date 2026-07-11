@extends('layouts.app')

@section('title', 'Officer Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Officer Dashboard</h3>
    <span class="text-muted">{{ auth()->user()->department->name ?? 'No Department' }}</span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body"><i class="icon bi bi-person-check"></i><h5>{{ $stats['assigned'] }}</h5><small>Assigned to Me</small></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body"><i class="icon bi bi-eye"></i><h5>{{ $stats['pending_review'] }}</h5><small>Pending Review</small></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body"><i class="icon bi bi-gear"></i><h5>{{ $stats['in_progress'] }}</h5><small>In Progress</small></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body"><i class="icon bi bi-check-circle"></i><h5>{{ $stats['resolved'] }}</h5><small>Resolved</small></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white"><strong>My Assigned Grievances</strong></div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Ticket</th><th>Citizen</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                        @forelse($myGrievances as $g)
                        <tr>
                            <td>{{ $g->ticket_id }}</td>
                            <td>{{ $g->user->name }}</td>
                            <td><span class="badge bg-{{ $g->status === 'resolved' ? 'success' : ($g->status === 'rejected' ? 'danger' : ($g->status === 'pending' ? 'warning' : 'info')) }}">{{ ucfirst(str_replace('_',' ',$g->status)) }}</span></td>
                            <td><a href="{{ route('officer.grievances.show', $g) }}" class="btn btn-sm btn-outline-dark"><i class="bi bi-eye"></i></a></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-muted text-center">No assigned grievances</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white"><strong>Unassigned - {{ auth()->user()->department->name ?? 'My Dept' }}</strong></div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Ticket</th><th>Citizen</th><th>Priority</th><th></th></tr></thead>
                    <tbody>
                        @forelse($departmentGrievances as $g)
                        <tr>
                            <td>{{ $g->ticket_id }}</td>
                            <td>{{ $g->user->name }}</td>
                            <td><span class="badge badge-priority-{{ $g->priority }}">{{ ucfirst($g->priority) }}</span></td>
                            <td><a href="{{ route('officer.grievances.show', $g) }}" class="btn btn-sm btn-outline-dark"><i class="bi bi-eye"></i></a></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-muted text-center">No unassigned grievances</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
