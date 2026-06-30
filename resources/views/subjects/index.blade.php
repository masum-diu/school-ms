@extends('layouts.app')
@section('title', 'Subjects')
@section('content')
<div class="flex items-center justify-between mb-6">
    <form method="GET"><select name="class" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
        <option value="">All Classes</option>
        @foreach($classes as $class)<option value="{{ $class->id }}" @selected(request('class') == $class->id)>{{ $class->name }}</option>@endforeach
    </select></form>
    <a href="{{ route('subjects.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Subject</a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b"><tr>
            <th class="text-left px-4 py-3">Code</th><th class="text-left px-4 py-3">Name</th>
            <th class="text-left px-4 py-3">Class</th><th class="text-left px-4 py-3">Teacher</th>
            <th class="text-left px-4 py-3">Marks</th><th class="text-right px-4 py-3">Actions</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($subjects as $subject)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono text-xs">{{ $subject->code }}</td>
                    <td class="px-4 py-3 font-medium">{{ $subject->name }}</td>
                    <td class="px-4 py-3">{{ $subject->schoolClass?->name ?? 'All' }}</td>
                    <td class="px-4 py-3">{{ $subject->teacher?->name ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $subject->full_marks }} (pass: {{ $subject->pass_marks }})</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('subjects.edit', $subject) }}" class="text-amber-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('subjects.destroy', $subject) }}" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline">Delete</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No subjects found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $subjects->links() }}</div>
@endsection
