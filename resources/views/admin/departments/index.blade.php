@extends('layouts.app')

@section('title', 'Departments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Departments</h3>
    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg"></i> Add Department</button>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead><tr><th>Name</th><th>Slug</th><th>Grievances</th><th>Officers</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($departments as $dept)
                <tr>
                    <td>{{ $dept->name }}</td>
                    <td><code>{{ $dept->slug }}</code></td>
                    <td>{{ $dept->grievances_count }}</td>
                    <td>{{ $dept->users_count }}</td>
                    <td>{!! $dept->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editModal{{ $dept->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this department?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $departments->links() }}
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <form method="POST" action="{{ route('admin.departments.store') }}">
        @csrf
        <div class="modal-header"><h5 class="modal-title">Add Department</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"></textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-dark">Save</button></div>
    </form>
</div></div></div>

@foreach($departments as $dept)
<div class="modal fade" id="editModal{{ $dept->id }}" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <form method="POST" action="{{ route('admin.departments.update', $dept) }}">
        @csrf @method('PUT')
        <div class="modal-header"><h5 class="modal-title">Edit Department</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ $dept->name }}" required></div>
            <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ $dept->description }}</textarea></div>
            <div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" value="1" id="active{{ $dept->id }}" {{ $dept->is_active ? 'checked' : '' }}><label class="form-check-label" for="active{{ $dept->id }}">Active</label></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-dark">Update</button></div>
    </form>
</div></div></div>
@endforeach
@endsection
