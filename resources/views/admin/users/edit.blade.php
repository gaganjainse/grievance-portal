@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white"><h5 class="mb-0">Edit User: {{ $user->name }}</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf @method('PUT')
                    <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ $user->name }}" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ $user->email }}" required></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ $user->phone }}"></div>
                    <div class="mb-3"><label class="form-label">New Password (leave blank to keep)</label><input type="password" name="password" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="citizen" {{ $user->role=='citizen'?'selected':'' }}>Citizen</option>
                            <option value="officer" {{ $user->role=='officer'?'selected':'' }}>Officer</option>
                            <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Department</label>
                        <select name="department_id" class="form-select">
                            <option value="">None</option>
                            @foreach($departments as $d)<option value="{{ $d->id }}" {{ $user->department_id==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" id="isActive" {{ $user->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                    <button type="submit" class="btn btn-dark">Update User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
