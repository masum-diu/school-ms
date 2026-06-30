@extends('layouts.app')
@section('title', 'Add Class')
@section('content')
<div class="max-w-lg">
    <form method="POST" action="{{ route('classes.store') }}" class="card card-body">
        @csrf
        <div class="space-y-5">
            <div>
                <label class="label">Class Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Class 10" required class="input">
            </div>
            <div>
                <label class="label">Code <span class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="e.g. C10" required class="input font-mono">
            </div>
            <div>
                <label class="label">Description</label>
                <textarea name="description" rows="2" class="textarea">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="label">Sections (comma separated)</label>
                <input type="text" name="sections_input" id="sections_input" value="{{ old('sections_input', 'A, B, C') }}" placeholder="A, B, C" class="input">
                <p class="text-xs text-slate-400 mt-1.5">Enter section names separated by commas</p>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Create Class</button>
            <a href="{{ route('classes.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<script>
document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('sections_input').value.split(',').forEach(s => {
        const hidden = document.createElement('input');
        hidden.type = 'hidden'; hidden.name = 'sections[]'; hidden.value = s.trim();
        this.appendChild(hidden);
    });
});
</script>
@endsection
