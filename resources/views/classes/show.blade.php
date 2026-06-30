@extends('layouts.app')
@section('title', $schoolClass->name)
@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('classes.edit', $schoolClass) }}" class="text-sm text-amber-600 hover:underline mr-4">Edit Class</a>
    @if($schoolClass->students->isEmpty())
        <form method="POST" action="{{ route('classes.destroy', $schoolClass) }}" class="inline" onsubmit="return confirm('Delete {{ $schoolClass->name }}? All sections will be removed.')">
            @csrf @method('DELETE')
            <button type="submit" class="text-sm text-red-600 hover:underline">Delete Class</button>
        </form>
    @endif
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold mb-4">Sections</h3>
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach($schoolClass->sections as $section)
                <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm flex items-center gap-2">
                    {{ $section->name }}
                    <form method="POST" action="{{ route('classes.sections.destroy', [$schoolClass, $section]) }}" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs">×</button>
                    </form>
                </span>
            @endforeach
        </div>
        <form method="POST" action="{{ route('classes.sections.store', $schoolClass) }}" class="flex gap-2">
            @csrf
            <input type="text" name="name" placeholder="Section name" required class="border border-gray-300 rounded-lg px-3 py-2 text-sm flex-1">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm">Add</button>
        </form>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold mb-4">Students ({{ $schoolClass->students->count() }})</h3>
        <div class="space-y-2 text-sm max-h-64 overflow-y-auto">
            @forelse($schoolClass->students as $student)
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span>{{ $student->name }}</span>
                    <span class="text-gray-400">Sec {{ $student->section->name }}</span>
                </div>
            @empty
                <p class="text-gray-400">No students in this class.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
