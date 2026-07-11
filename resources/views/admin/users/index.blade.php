@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Manage Users</h3>
    <a href="{{ route('admin.users.create') }}" class="btn btn-dark"><i class="bi bi-plus-lg"></i> Add User</a>
</div>

<div class="card">
    <div class="card-body">
        <form class="row g-2 mb-3" method="GET">
            <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search by name, email, phone..." value="{{ request('search') }}"></div>
            <div class="col-md-2"><select name="role" class="form-select"><option value="">All Roles</option><option value="citizen" {{ request('role')=='citizen'?'selected':'' }}>Citizen</option><option value="officer" {{ request('role')=='officer'?'selected':'' }}>Officer</option><option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option></select></div>
            <div class="col-md-2"><button type="submit" class="btn btn-outline-dark w-100"><i class="bi bi-search"></i> Filter</button></div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Department</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td><span class="badge bg-{{ $user->role === 'admin' ? 'dark' : ($user->role === 'officer' ? 'info' : 'secondary') }}">{{ ucfirst($user->role) }}</span></td>
                        <td>{{ $user->department->name ?? '-' }}</td>
                        <td>{!! $user->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-dark"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </div>
</div>
@endsection
