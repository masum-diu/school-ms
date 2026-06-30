@extends('layouts.app')
@section('title', 'Edit Teacher')
@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('teachers.update', $teacher) }}" class="card card-body">
        @csrf @method('PUT')
        <div class="form-grid">
            <div>
                <label class="label">Employee ID</label>
                <input type="text" value="{{ $teacher->employee_id }}" disabled class="input-disabled font-mono">
            </div>
            <div>
                <label class="label">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $teacher->name) }}" required class="input">
            </div>
            <div>
                <label class="label">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $teacher->email) }}" required class="input">
            </div>
            <div>
                <label class="label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}" class="input">
            </div>
            <div>
                <label class="label">Gender <span class="text-red-500">*</span></label>
                <select name="gender" class="select">
                    @foreach(['male','female','other'] as $g)
                        <option value="{{ $g }}" @selected(old('gender', $teacher->gender) == $g)>{{ ucfirst($g) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Qualification</label>
                <input type="text" name="qualification" value="{{ old('qualification', $teacher->qualification) }}" class="input">
            </div>
            <div>
                <label class="label">Specialization</label>
                <input type="text" name="specialization" value="{{ old('specialization', $teacher->specialization) }}" class="input">
            </div>
            <div>
                <label class="label">Joining Date <span class="text-red-500">*</span></label>
                <input type="date" name="joining_date" value="{{ old('joining_date', $teacher->joining_date->format('Y-m-d')) }}" required class="input">
            </div>
            <div>
                <label class="label">Salary (৳)</label>
                <input type="number" name="salary" value="{{ old('salary', $teacher->salary) }}" class="input" min="0">
            </div>
            <div>
                <label class="label">Status</label>
                <select name="status" class="select">
                    <option value="active" @selected(old('status', $teacher->status) === 'active')>Active</option>
                    <option value="inactive" @selected(old('status', $teacher->status) === 'inactive')>Inactive</option>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Update Teacher</button>
            <a href="{{ route('teachers.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
