@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Categories</h3>
    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg"></i> Add Category</button>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead><tr><th>Name</th><th>Department</th><th>Escalation (days)</th><th>Grievances</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->department->name }}</td>
                    <td>{{ $cat->escalation_days }}</td>
                    <td>{{ $cat->grievances_count }}</td>
                    <td>{!! $cat->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editModal{{ $cat->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="modal-header"><h5 class="modal-title">Add Category</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Department</label><select name="department_id" class="form-select" required>@foreach($departments as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach</select></div>
            <div class="mb-3"><label class="form-label">Escalation (days)</label><input type="number" name="escalation_days" class="form-control" value="7" min="1" max="90" required></div>
            <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-dark">Save</button></div>
    </form>
</div></div></div>

@foreach($categories as $cat)
<div class="modal fade" id="editModal{{ $cat->id }}" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <form method="POST" action="{{ route('admin.categories.update', $cat) }}">
        @csrf @method('PUT')
        <div class="modal-header"><h5 class="modal-title">Edit Category</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ $cat->name }}" required></div>
            <div class="mb-3"><label class="form-label">Department</label><select name="department_id" class="form-select" required>@foreach($departments as $d)<option value="{{ $d->id }}" {{ $cat->department_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>@endforeach</select></div>
            <div class="mb-3"><label class="form-label">Escalation (days)</label><input type="number" name="escalation_days" class="form-control" value="{{ $cat->escalation_days }}" min="1" max="90" required></div>
            <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2">{{ $cat->description }}</textarea></div>
            <div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" value="1" id="catActive{{ $cat->id }}" {{ $cat->is_active ? 'checked' : '' }}><label class="form-check-label" for="catActive{{ $cat->id }}">Active</label></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-dark">Update</button></div>
    </form>
</div></div></div>
@endforeach
@endsection
