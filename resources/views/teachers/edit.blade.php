@extends('layouts.app')
@section('title', 'Edit Teacher')
@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('teachers.update', $teacher) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Employee ID</label>
                <input type="text" value="{{ $teacher->employee_id }}" disabled class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-600">
            </div>
            <div><label class="block text-sm font-medium mb-1">Full Name *</label><input type="text" name="name" value="{{ old('name', $teacher->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Email *</label><input type="email" name="email" value="{{ old('email', $teacher->email) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Phone</label><input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Gender *</label>
                <select name="gender" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach(['male','female','other'] as $g)<option value="{{ $g }}" @selected(old('gender', $teacher->gender) == $g)>{{ ucfirst($g) }}</option>@endforeach
                </select>
            </div>
            <div><label class="block text-sm font-medium mb-1">Specialization</label><input type="text" name="specialization" value="{{ old('specialization', $teacher->specialization) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Joining Date *</label><input type="date" name="joining_date" value="{{ old('joining_date', $teacher->joining_date->format('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Salary</label><input type="number" name="salary" value="{{ old('salary', $teacher->salary) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="active" @selected($teacher->status === 'active')>Active</option>
                    <option value="inactive" @selected($teacher->status === 'inactive')>Inactive</option>
                </select>
            </div>
        </div>
        <div class="flex gap-3 mt-5">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg text-sm font-medium">Update</button>
            <a href="{{ route('teachers.index') }}" class="bg-gray-100 px-6 py-2 rounded-lg text-sm">Cancel</a>
        </div>
    </form>
</div>
@endsection
