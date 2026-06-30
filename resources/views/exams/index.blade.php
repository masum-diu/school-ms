@extends('layouts.app')
@section('title', 'Exam Results')
@section('content')
<div class="flex items-center justify-between mb-6">
    <form method="GET" class="flex gap-3">
        <select name="exam" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <option value="">All Exams</option>
            @foreach($examNames as $name)<option value="{{ $name }}" @selected(request('exam') == $name)>{{ $name }}</option>@endforeach
        </select>
        <button type="submit" class="bg-gray-100 px-4 py-2 rounded-lg text-sm">Filter</button>
    </form>
    <a href="{{ route('exams.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Result</a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b"><tr>
            <th class="text-left px-4 py-3">Student</th><th class="text-left px-4 py-3">Subject</th>
            <th class="text-left px-4 py-3">Exam</th><th class="text-left px-4 py-3">Marks</th>
            <th class="text-left px-4 py-3">Grade</th><th class="text-right px-4 py-3">Actions</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($results as $result)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $result->student->name }}</td>
                    <td class="px-4 py-3">{{ $result->subject->name }}</td>
                    <td class="px-4 py-3">{{ $result->exam_name }}</td>
                    <td class="px-4 py-3">{{ $result->marks_obtained }}/{{ $result->total_marks }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ in_array($result->grade, ['A+','A','A-']) ? 'bg-green-100 text-green-700' : ($result->grade === 'F' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">{{ $result->grade }}</span></td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="{{ route('exams.destroy', $result) }}" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline text-sm">Delete</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No results yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $results->links() }}</div>
@endsection
