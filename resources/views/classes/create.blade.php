@extends('layouts.app')
@section('title', 'Add Class')
@section('content')
<div class="max-w-lg">
    <form method="POST" action="{{ route('classes.store') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        @csrf
        <div><label class="block text-sm font-medium mb-1">Class Name *</label><input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Class 10" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Code *</label><input type="text" name="code" value="{{ old('code') }}" placeholder="e.g. C10" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description') }}</textarea></div>
        <div>
            <label class="block text-sm font-medium mb-1">Sections (comma separated)</label>
            <input type="text" name="sections_input" id="sections_input" value="{{ old('sections_input', 'A, B, C') }}" placeholder="A, B, C" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <p class="text-xs text-gray-400 mt-1">Enter section names separated by commas</p>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg text-sm font-medium">Create Class</button>
            <a href="{{ route('classes.index') }}" class="bg-gray-100 px-6 py-2 rounded-lg text-sm">Cancel</a>
        </div>
    </form>
</div>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const input = document.getElementById('sections_input').value;
    input.split(',').forEach(s => {
        const hidden = document.createElement('input');
        hidden.type = 'hidden'; hidden.name = 'sections[]'; hidden.value = s.trim();
        this.appendChild(hidden);
    });
});
</script>
@endsection
