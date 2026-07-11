@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">My Dashboard</h3>
    <a href="{{ route('citizen.grievances.create') }}" class="btn btn-dark"><i class="bi bi-plus-lg"></i> New Grievance</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card border-primary border-2">
            <div class="card-body"><h5 class="card-title text-primary">{{ $stats['total'] }}</h5><small>Total Filed</small></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-warning border-2">
            <div class="card-body"><h5 class="card-title text-warning">{{ $stats['pending'] }}</h5><small>Pending</small></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-info border-2">
            <div class="card-body"><h5 class="card-title text-info">{{ $stats['in_progress'] }}</h5><small>In Progress</small></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-success border-2">
            <div class="card-body"><h5 class="card-title text-success">{{ $stats['resolved'] }}</h5><small>Resolved</small></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between">
        <strong>Recent Grievances</strong>
        <a href="{{ route('citizen.grievances.index') }}" class="text-decoration-none">View All</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Ticket</th><th>Subject</th><th>Department</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                @forelse($recentGrievances as $g)
                <tr>
                    <td><a href="{{ route('citizen.grievances.show', $g) }}">{{ $g->ticket_id }}</a></td>
                    <td>{{ Str::limit($g->subject, 40) }}</td>
                    <td>{{ $g->department->name }}</td>
                    <td><span class="badge bg-{{ $g->status === 'resolved' ? 'success' : ($g->status === 'rejected' ? 'danger' : ($g->status === 'pending' ? 'warning' : 'info')) }}">{{ ucfirst(str_replace('_',' ',$g->status)) }}</span></td>
                    <td><small>{{ $g->created_at->format('d M Y') }}</small></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No grievances filed yet. <a href="{{ route('citizen.grievances.create') }}">File your first grievance</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
