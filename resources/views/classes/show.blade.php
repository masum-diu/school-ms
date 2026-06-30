@extends('layouts.app')
@section('title', $schoolClass->name)
@section('content')
<div class="flex justify-end gap-3 mb-6">
    <a href="{{ route('classes.edit', $schoolClass) }}" class="btn-secondary">Edit Class</a>
    <form method="POST" action="{{ route('classes.destroy', $schoolClass) }}"
          onsubmit="return confirm('Delete {{ $schoolClass->name }}?@if($schoolClass->students->count() > 0)\n\nThis will also delete {{ $schoolClass->students->count() }} student(s).@endif')">
        @csrf @method('DELETE')
        <button type="submit" class="btn-ghost text-red-600 hover:bg-red-50 border border-red-200">Delete Class</button>
    </form>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card card-body">
        <h3 class="form-section-title">Sections</h3>
        <div class="flex flex-wrap gap-2 mb-5">
            @foreach($schoolClass->sections as $section)
                <span class="badge-neutral flex items-center gap-2 py-1.5 px-3">
                    {{ $section->name }}
                    <form method="POST" action="{{ route('classes.sections.destroy', [$schoolClass, $section]) }}" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs leading-none">×</button>
                    </form>
                </span>
            @endforeach
        </div>
        <form method="POST" action="{{ route('classes.sections.store', $schoolClass) }}" class="flex gap-2">
            @csrf
            <input type="text" name="name" placeholder="Section name" required class="input flex-1">
            <button type="submit" class="btn-primary">Add</button>
        </form>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-slate-800">Students</h3>
            <span class="badge-neutral">{{ $schoolClass->students->count() }} total</span>
        </div>
        <div class="divide-y divide-slate-50 max-h-80 overflow-y-auto">
            @forelse($schoolClass->students as $student)
                <div class="flex justify-between items-center px-6 py-3.5 hover:bg-slate-50/50">
                    <span class="text-sm font-medium text-slate-800">{{ $student->name }}</span>
                    <span class="badge-neutral">Sec {{ $student->section->name }}</span>
                </div>
            @empty
                <div class="empty-state">No students in this class.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
