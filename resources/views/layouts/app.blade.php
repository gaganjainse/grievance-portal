<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Grievance Portal') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .sidebar { min-height: 100vh; background: #1a1a2e; color: #fff; }
        .sidebar .nav-link { color: rgba(255,255,255,.7); padding: .7rem 1rem; border-radius: 6px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,.1); }
        .sidebar .nav-link i { margin-right: 10px; width: 20px; text-align: center; }
        .sidebar .brand { padding: 1.2rem 1rem; font-size: 1.25rem; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,.1); }
        .badge-priority-urgent { background: #dc3545; }
        .badge-priority-high { background: #fd7e14; }
        .badge-priority-medium { background: #ffc107; color: #000; }
        .badge-priority-low { background: #6c757d; }
        .stat-card { border: none; border-radius: 12px; transition: transform .2s; }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-card .icon { font-size: 2rem; opacity: .2; position: absolute; right: 15px; bottom: 10px; }
        .stat-card { position: relative; overflow: hidden; }
        .grievance-timeline .timeline-item { position: relative; padding-left: 30px; padding-bottom: 20px; }
        .grievance-timeline .timeline-item::before { content: ''; position: absolute; left: 10px; top: 5px; bottom: 0; width: 2px; background: #dee2e6; }
        .grievance-timeline .timeline-item::after { content: ''; position: absolute; left: 4px; top: 5px; width: 14px; height: 14px; border-radius: 50%; background: #0d6efd; border: 3px solid #fff; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .table th { font-weight: 600; font-size: .85rem; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; }
        .table td { vertical-align: middle; }
        .user-dropdown { cursor: pointer; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @auth
            <div class="col-md-2 p-0 sidebar d-none d-md-block">
                <div class="brand">
                    <i class="bi bi-shield-check"></i> Grievance Portal
                </div>
                <nav class="mt-3">
                    @php $user = auth()->user(); @endphp

                    @if($user->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.grievances.index') }}" class="nav-link {{ request()->routeIs('admin.grievances.*') ? 'active' : '' }}">
                            <i class="bi bi-ticket"></i> Grievances
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Users
                        </a>
                        <a href="{{ route('admin.departments.index') }}" class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                            <i class="bi bi-building"></i> Departments
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="bi bi-tags"></i> Categories
                        </a>

                    @elseif($user->isOfficer())
                        <a href="{{ route('officer.dashboard') }}" class="nav-link {{ request()->routeIs('officer.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        <a href="{{ route('officer.grievances.index') }}" class="nav-link {{ request()->routeIs('officer.grievances.*') ? 'active' : '' }}">
                            <i class="bi bi-ticket"></i> Grievances
                        </a>

                    @else
                        <a href="{{ route('citizen.dashboard') }}" class="nav-link {{ request()->routeIs('citizen.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        <a href="{{ route('citizen.grievances.index') }}" class="nav-link {{ request()->routeIs('citizen.grievances.*') ? 'active' : '' }}">
                            <i class="bi bi-ticket"></i> My Grievances
                        </a>
                        <a href="{{ route('citizen.grievances.create') }}" class="nav-link {{ request()->routeIs('citizen.grievances.create') ? 'active' : '' }}">
                            <i class="bi bi-plus-circle"></i> New Grievance
                        </a>
                    @endif

                    <hr style="border-color:rgba(255,255,255,.1)">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                            <i class="bi bi-box-arrow-left"></i> Logout
                        </button>
                    </form>
                </nav>
            </div>
            @endauth

            <div class="col-md-{{ auth()->check() ? '10' : '12' }} p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>
