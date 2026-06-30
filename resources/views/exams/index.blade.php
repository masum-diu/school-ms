@extends('layouts.app')
@section('title', 'Exam Results')
@section('content')
<div class="filter-bar">
    <form method="GET" class="flex items-center gap-3 flex-1">
        <select name="exam" class="select w-auto min-w-[180px]">
            <option value="">All Exams</option>
            @foreach($examNames as $name)<option value="{{ $name }}" @selected(request('exam') == $name)>{{ $name }}</option>@endforeach
        </select>
        <button type="submit" class="btn-secondary">Filter</button>
    </form>
    <a href="{{ route('exams.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Result
    </a>
</div>
<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Student</th><th>Subject</th><th>Exam</th><th>Marks</th><th>Grade</th><th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($results as $result)
                <tr>
                    <td class="font-medium text-slate-800">{{ $result->student->name }}</td>
                    <td>{{ $result->subject->name }}</td>
                    <td class="text-slate-500">{{ $result->exam_name }}</td>
                    <td>{{ $result->marks_obtained }}/{{ $result->total_marks }}</td>
                    <td>
                        <span class="{{ in_array($result->grade, ['A+','A','A-']) ? 'badge-success' : ($result->grade === 'F' ? 'badge-danger' : 'badge-warning') }}">{{ $result->grade }}</span>
                    </td>
                    <td class="text-right">
                        <form method="POST" action="{{ route('exams.destroy', $result) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn-ghost text-xs text-red-600 hover:bg-red-50">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty-state">No results yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $results->links() }}</div>
@endsection
