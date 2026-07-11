@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Admin Dashboard</h3>
    <span class="text-muted">{{ now()->format('l, d M Y') }}</span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body"><i class="icon bi bi-ticket"></i>
                <h5 class="card-title">{{ $stats['total_grievances'] }}</h5>
                <small>Total Grievances</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body"><i class="icon bi bi-hourglass-split"></i>
                <h5 class="card-title">{{ $stats['pending'] }}</h5>
                <small>Pending</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body"><i class="icon bi bi-gear"></i>
                <h5 class="card-title">{{ $stats['in_progress'] }}</h5>
                <small>In Progress</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body"><i class="icon bi bi-check-circle"></i>
                <h5 class="card-title">{{ $stats['resolved'] }}</h5>
                <small>Resolved</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card" style="background:#1a1a2e;color:#fff;">
            <div class="card-body"><i class="icon bi bi-people"></i>
                <h5 class="card-title">{{ $stats['total_users'] }}</h5>
                <small>Total Users</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border">
            <div class="card-body"><i class="icon bi bi-person-badge"></i>
                <h5 class="card-title">{{ $stats['total_citizens'] }}</h5>
                <small>Citizens</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border">
            <div class="card-body"><i class="icon bi bi-person-gear"></i>
                <h5 class="card-title">{{ $stats['total_officers'] }}</h5>
                <small>Officers</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border">
            <div class="card-body"><i class="icon bi bi-building"></i>
                <h5 class="card-title">{{ $stats['total_departments'] }}</h5>
                <small>Departments</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white"><strong>Department-wise Statistics</strong></div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Department</th><th>Total</th><th>Resolved</th><th>Rate</th></tr></thead>
                    <tbody>
                        @foreach($departmentStats as $ds)
                        <tr>
                            <td>{{ $ds['name'] }}</td>
                            <td>{{ $ds['total'] }}</td>
                            <td>{{ $ds['resolved'] }}</td>
                            <td>@if($ds['total'] > 0) {{ round(($ds['resolved']/$ds['total'])*100) }}% @else - @endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white"><strong>Recent Grievances</strong></div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Ticket</th><th>Citizen</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($recentGrievances as $g)
                        <tr>
                            <td><a href="{{ route('admin.grievances.show', $g) }}">{{ $g->ticket_id }}</a></td>
                            <td>{{ $g->user->name }}</td>
                            <td><span class="badge bg-{{ $g->status === 'resolved' ? 'success' : ($g->status === 'rejected' ? 'danger' : ($g->status === 'pending' ? 'warning' : 'info')) }}">{{ ucfirst(str_replace('_',' ',$g->status)) }}</span></td>
                            <td><small>{{ $g->created_at->format('d M Y') }}</small></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-muted text-center">No grievances yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
