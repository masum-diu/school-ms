@extends('layouts.app')
@section('title', 'Add Subject')
@section('content')
<div class="max-w-lg">
    <form method="POST" action="{{ route('subjects.store') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        @csrf
        <div><label class="block text-sm font-medium mb-1">Subject Name *</label><input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Code *</label><input type="text" name="code" value="{{ old('code') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Class</label>
            <select name="school_class_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">All Classes</option>
                @foreach($classes as $class)<option value="{{ $class->id }}">{{ $class->name }}</option>@endforeach
            </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Teacher</label>
            <select name="teacher_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">Not assigned</option>
                @foreach($teachers as $t)<option value="{{ $t->id }}">{{ $t->name }}</option>@endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium mb-1">Full Marks *</label><input type="number" name="full_marks" value="{{ old('full_marks', 100) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Pass Marks *</label><input type="number" name="pass_marks" value="{{ old('pass_marks', 33) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
        </div>
        <div class="flex gap-3"><button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-medium">Save</button>
            <a href="{{ route('subjects.index') }}" class="bg-gray-100 px-6 py-2 rounded-lg text-sm">Cancel</a></div>
    </form>
</div>
@endsection
