@extends('layouts.app')
@section('title', 'Add Teacher')
@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('teachers.store') }}" class="card card-body">
        @csrf
        <div class="info-banner mb-6">
            Employee ID will be generated automatically (e.g. EMP-2026-0001)
        </div>
        <div class="form-grid">
            <div class="sm:col-span-2">
                <label class="label">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="input" placeholder="Enter full name">
            </div>
            <div>
                <label class="label">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required class="input" placeholder="teacher@school.com">
            </div>
            <div>
                <label class="label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="input" placeholder="01XXXXXXXXX">
            </div>
            <div>
                <label class="label">Gender <span class="text-red-500">*</span></label>
                <select name="gender" class="select">
                    @foreach(['male','female','other'] as $g)
                        <option value="{{ $g }}" @selected(old('gender', 'male') == $g)>{{ ucfirst($g) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Qualification</label>
                <input type="text" name="qualification" value="{{ old('qualification') }}" class="input" placeholder="e.g. Masters">
            </div>
            <div>
                <label class="label">Specialization</label>
                <input type="text" name="specialization" value="{{ old('specialization') }}" class="input" placeholder="e.g. Mathematics">
            </div>
            <div>
                <label class="label">Joining Date <span class="text-red-500">*</span></label>
                <input type="date" name="joining_date" value="{{ old('joining_date', date('Y-m-d')) }}" required class="input">
            </div>
            <div>
                <label class="label">Salary (৳)</label>
                <input type="number" name="salary" value="{{ old('salary') }}" class="input" placeholder="35000" min="0">
            </div>
            <div>
                <label class="label">Status</label>
                <select name="status" class="select">
                    <option value="active" @selected(old('status', 'active') == 'active')>Active</option>
                    <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Save Teacher</button>
            <a href="{{ route('teachers.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
