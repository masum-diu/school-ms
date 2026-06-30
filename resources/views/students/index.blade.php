@extends('layouts.app')
@section('title', 'Students')
@section('content')
<div class="filter-bar">
    <form method="GET" class="flex flex-wrap items-center gap-3 flex-1">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, admission no..." class="input max-w-xs">
        <select name="class" class="select w-auto min-w-[140px]">
            <option value="">All Classes</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" @selected(request('class') == $class->id)>{{ $class->name }}</option>
            @endforeach
        </select>
        <select name="status" class="select w-auto min-w-[120px]">
            <option value="">All Status</option>
            @foreach(['active','inactive','graduated'] as $s)
                <option value="{{ $s }}" @selected(request('status') == $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-secondary">Filter</button>
    </form>
    <a href="{{ route('students.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Student
    </a>
</div>

<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Admission No</th>
                <th>Name</th>
                <th>Class</th>
                <th>Guardian</th>
                <th>Status</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td><span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded-lg">{{ $student->admission_no }}</span></td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-xs font-bold text-white">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
                            <span class="font-medium text-slate-800">{{ $student->name }}</span>
                        </div>
                    </td>
                    <td>{{ $student->schoolClass->name }} <span class="text-slate-400">·</span> {{ $student->section->name }}</td>
                    <td class="text-slate-500">{{ $student->guardian_name }}</td>
                    <td>
                        <span class="{{ $student->status === 'active' ? 'badge-success' : 'badge-neutral' }}">{{ ucfirst($student->status) }}</span>
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('students.show', $student) }}" class="btn-ghost text-xs">View</a>
                            <a href="{{ route('students.edit', $student) }}" class="btn-ghost text-xs">Edit</a>
                            <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline" onsubmit="return confirm('Delete this student?')">
                                @csrf @method('DELETE')
                                <button class="btn-ghost text-xs text-red-600 hover:text-red-700 hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty-state">No students found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $students->links() }}</div>
@endsection
