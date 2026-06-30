@extends('layouts.app')
@section('title', 'Edit Class')
@section('content')
<div class="max-w-lg">
    <form method="POST" action="{{ route('classes.update', $schoolClass) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        @csrf @method('PUT')
        <div><label class="block text-sm font-medium mb-1">Class Name *</label><input type="text" name="name" value="{{ old('name', $schoolClass->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Code *</label><input type="text" name="code" value="{{ old('code', $schoolClass->code) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description', $schoolClass->description) }}</textarea></div>
        <div class="flex gap-3 items-center">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg text-sm font-medium">Update</button>
            <a href="{{ route('classes.index') }}" class="bg-gray-100 hover:bg-gray-200 px-6 py-2 rounded-lg text-sm">Cancel</a>
            @if($schoolClass->students()->count() === 0)
                <form method="POST" action="{{ route('classes.destroy', $schoolClass) }}" class="inline ml-auto" onsubmit="return confirm('Delete {{ $schoolClass->name }}? All sections will be removed.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">Delete Class</button>
                </form>
            @endif
        </div>
    </form>
</div>
@endsection
