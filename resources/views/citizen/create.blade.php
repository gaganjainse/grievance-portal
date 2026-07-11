@extends('layouts.app')

@section('title', 'File a Grievance')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white"><h5 class="mb-0"><i class="bi bi-plus-circle"></i> File a New Grievance</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('citizen.grievances.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Department <span class="text-danger">*</span></label>
                            <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $d)
                                    <option value="{{ $d->id }}" {{ old('department_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required maxlength="255">
                            @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Priority <span class="text-danger">*</span></label>
                            <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                <option value="low" {{ old('priority')=='low'?'selected':'' }}>Low</option>
                                <option value="medium" {{ old('priority')=='medium'?'selected':'' }} selected>Medium</option>
                                <option value="high" {{ old('priority')=='high'?'selected':'' }}>High</option>
                                <option value="urgent" {{ old('priority')=='urgent'?'selected':'' }}>Urgent</option>
                            </select>
                            @error('priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" placeholder="Address or area">
                            @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Pincode</label>
                            <input type="text" name="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode') }}" maxlength="6" pattern="[0-9]{6}">
                            @error('pincode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Supporting Documents (optional)</label>
                        <input type="file" name="attachments[]" class="form-control @error('attachments.*') is-invalid @enderror" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                        <small class="text-muted">Max 10MB per file. Allowed: JPG, PNG, PDF, DOC</small>
                        @error('attachments.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-dark px-4"><i class="bi bi-send"></i> Submit Grievance</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('department_id').addEventListener('change', function() {
    var deptId = this.value;
    var catSelect = document.getElementById('category_id');
    catSelect.innerHTML = '<option value="">Loading...</option>';
    if (deptId) {
        fetch('/api/categories/' + deptId)
            .then(r => r.json())
            .then(data => {
                catSelect.innerHTML = '<option value="">Select Category</option>';
                data.forEach(function(cat) {
                    catSelect.innerHTML += '<option value="' + cat.id + '">' + cat.name + '</option>';
                });
            });
    } else {
        catSelect.innerHTML = '<option value="">Select Category</option>';
    }
});
</script>
@endpush
