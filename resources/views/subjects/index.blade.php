@extends('layouts.app')
@section('title', 'Subjects')
@section('content')
<div class="filter-bar">
    <form method="GET" class="flex items-center gap-3 flex-1">
        <select name="class" onchange="this.form.submit()" class="select w-auto min-w-[160px]">
            <option value="">All Classes</option>
            @foreach($classes as $class)<option value="{{ $class->id }}" @selected(request('class') == $class->id)>{{ $class->name }}</option>@endforeach
        </select>
    </form>
    <a href="{{ route('subjects.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Subject
    </a>
</div>
<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Code</th><th>Name</th><th>Class</th><th>Teacher</th><th>Marks</th><th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjects as $subject)
                <tr>
                    <td><span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded-lg">{{ $subject->code }}</span></td>
                    <td class="font-medium text-slate-800">{{ $subject->name }}</td>
                    <td>{{ $subject->schoolClass?->name ?? 'All' }}</td>
                    <td class="text-slate-500">{{ $subject->teacher?->name ?? '—' }}</td>
                    <td>{{ $subject->full_marks }} <span class="text-slate-400">(pass: {{ $subject->pass_marks }})</span></td>
                    <td class="text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('subjects.edit', $subject) }}" class="btn-ghost text-xs">Edit</a>
                            <form method="POST" action="{{ route('subjects.destroy', $subject) }}" class="inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="btn-ghost text-xs text-red-600 hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty-state">No subjects found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $subjects->links() }}</div>
@endsection
