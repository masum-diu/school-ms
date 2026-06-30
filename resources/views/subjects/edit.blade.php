@extends('layouts.app')
@section('title', 'Edit Subject')
@section('content')
<div class="max-w-lg">
    <form method="POST" action="{{ route('subjects.update', $subject) }}" class="card card-body">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="sm:col-span-2">
                <label class="label">Subject Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $subject->name) }}" required class="input">
            </div>
            <div>
                <label class="label">Code <span class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code', $subject->code) }}" required class="input font-mono">
            </div>
            <div>
                <label class="label">Class</label>
                <select name="school_class_id" class="select">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)<option value="{{ $class->id }}" @selected(old('school_class_id', $subject->school_class_id) == $class->id)>{{ $class->name }}</option>@endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="label">Teacher</label>
                <select name="teacher_id" class="select">
                    <option value="">Not assigned</option>
                    @foreach($teachers as $t)<option value="{{ $t->id }}" @selected(old('teacher_id', $subject->teacher_id) == $t->id)>{{ $t->name }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="label">Full Marks <span class="text-red-500">*</span></label>
                <input type="number" name="full_marks" value="{{ old('full_marks', $subject->full_marks) }}" required class="input" min="1">
            </div>
            <div>
                <label class="label">Pass Marks <span class="text-red-500">*</span></label>
                <input type="number" name="pass_marks" value="{{ old('pass_marks', $subject->pass_marks) }}" required class="input" min="1">
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Update Subject</button>
            <a href="{{ route('subjects.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
