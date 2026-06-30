@extends('layouts.app')
@section('title', 'Edit Class')
@section('content')
<div class="max-w-lg">
    <form method="POST" action="{{ route('classes.update', $schoolClass) }}" class="card card-body">
        @csrf @method('PUT')
        <div class="space-y-5">
            <div>
                <label class="label">Class Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $schoolClass->name) }}" required class="input">
            </div>
            <div>
                <label class="label">Code <span class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code', $schoolClass->code) }}" required class="input font-mono">
            </div>
            <div>
                <label class="label">Description</label>
                <textarea name="description" rows="2" class="textarea">{{ old('description', $schoolClass->description) }}</textarea>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Update Class</button>
            <a href="{{ route('classes.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
    <form method="POST" action="{{ route('classes.destroy', $schoolClass) }}" class="mt-4 text-right"
          onsubmit="return confirm('Delete {{ $schoolClass->name }}?@if($schoolClass->students()->count() > 0)\n\nThis will also delete {{ $schoolClass->students()->count() }} student(s).@endif')">
        @csrf @method('DELETE')
        <button type="submit" class="btn-ghost text-red-600 hover:bg-red-50">Delete Class</button>
    </form>
</div>
@endsection
