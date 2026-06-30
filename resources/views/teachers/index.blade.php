@extends('layouts.app')
@section('title', 'Teachers')
@section('content')
<div class="filter-bar">
    <form method="GET" class="flex flex-wrap items-center gap-3 flex-1">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, employee ID..." class="input max-w-xs">
        <button type="submit" class="btn-secondary">Search</button>
    </form>
    <a href="{{ route('teachers.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Teacher
    </a>
</div>

<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Specialization</th>
                <th>Status</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teachers as $teacher)
                <tr>
                    <td><span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded-lg">{{ $teacher->employee_id }}</span></td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-xs font-bold text-white">{{ strtoupper(substr($teacher->name, 0, 1)) }}</div>
                            <span class="font-medium text-slate-800">{{ $teacher->name }}</span>
                        </div>
                    </td>
                    <td class="text-slate-500">{{ $teacher->email }}</td>
                    <td>{{ $teacher->specialization ?? '—' }}</td>
                    <td><span class="{{ $teacher->status === 'active' ? 'badge-success' : 'badge-neutral' }}">{{ ucfirst($teacher->status) }}</span></td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('teachers.show', $teacher) }}" class="btn-ghost text-xs">View</a>
                            <a href="{{ route('teachers.edit', $teacher) }}" class="btn-ghost text-xs">Edit</a>
                            <form method="POST" action="{{ route('teachers.destroy', $teacher) }}" class="inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="btn-ghost text-xs text-red-600 hover:text-red-700 hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty-state">No teachers found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $teachers->links() }}</div>
@endsection
