@extends('layouts.app')
@section('title', 'Mark Attendance')
@section('content')
<form method="GET" class="flex flex-wrap gap-3 mb-6 bg-white p-4 rounded-xl border border-gray-100">
    <input type="date" name="date" value="{{ $date }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
    <select name="class" id="class_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
        <option value="">Select Class</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}" @selected($classId == $class->id)>{{ $class->name }}</option>
        @endforeach
    </select>
    <select name="section" id="section_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
        <option value="">Select Section</option>
    </select>
    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm">Load Students</button>
</form>

@if($students->count())
<form method="POST" action="{{ route('attendance.store') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @csrf
    <input type="hidden" name="date" value="{{ $date }}">
    <input type="hidden" name="school_class_id" value="{{ $classId }}">
    <input type="hidden" name="section_id" value="{{ $sectionId }}">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3">Roll</th>
                <th class="text-left px-4 py-3">Name</th>
                <th class="text-left px-4 py-3">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($students as $student)
                <tr>
                    <td class="px-4 py-3">{{ $student->roll_no ?? '—' }}</td>
                    <td class="px-4 py-3 font-medium">{{ $student->name }}</td>
                    <td class="px-4 py-3">
                        @php $current = $attendances[$student->id] ?? 'present'; @endphp
                        <select name="attendance[{{ $student->id }}]" class="border border-gray-300 rounded-lg px-2 py-1 text-sm">
                            @foreach(['present','absent','late','leave'] as $s)
                                <option value="{{ $s }}" @selected($current === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4 border-t">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-medium">Save Attendance</button>
    </div>
</form>
@elseif($classId && $sectionId)
    <p class="text-gray-400 text-center py-8">No active students in this section.</p>
@else
    <p class="text-gray-400 text-center py-8">Select a class and section to mark attendance.</p>
@endif

<script>
const classes = @json($classes);
const classSelect = document.getElementById('class_id');
const sectionSelect = document.getElementById('section_id');
function loadSections(classId, selected) {
    sectionSelect.innerHTML = '<option value="">Select Section</option>';
    const cls = classes.find(c => c.id == classId);
    if (cls) cls.sections.forEach(s => {
        const opt = document.createElement('option');
        opt.value = s.id; opt.textContent = s.name;
        if (selected == s.id) opt.selected = true;
        sectionSelect.appendChild(opt);
    });
}
classSelect.addEventListener('change', () => loadSections(classSelect.value));
if (classSelect.value) loadSections(classSelect.value, '{{ $sectionId }}');
</script>
@endsection
