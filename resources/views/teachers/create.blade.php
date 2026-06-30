@extends('layouts.app')
@section('title', 'Add Teacher')
@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('teachers.store') }}" class="card card-body max-w-2xl">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2 info-banner">
                Employee ID will be generated automatically (e.g. EMP-2026-0001)
            </div>
            <div><label class="block text-sm font-medium mb-1">Full Name *</label><input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Email *</label><input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Phone</label><input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Gender *</label>
                <select name="gender" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach(['male','female','other'] as $g)<option value="{{ $g }}">{{ ucfirst($g) }}</option>@endforeach
                </select>
            </div>
            <div><label class="block text-sm font-medium mb-1">Qualification</label><input type="text" name="qualification" value="{{ old('qualification') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Specialization</label><input type="text" name="specialization" value="{{ old('specialization') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Joining Date *</label><input type="date" name="joining_date" value="{{ old('joining_date', date('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Salary</label><input type="number" name="salary" value="{{ old('salary') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="active">Active</option><option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="flex gap-3 mt-5">
            <button type="submit" class="btn-primary">Save</button>
            <a href="{{ route('teachers.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
