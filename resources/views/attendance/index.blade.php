@extends('layouts.app')
@section('title', 'Mark Attendance')
@section('content')
<form method="GET" class="filter-bar">
    <input type="date" name="date" value="{{ $date }}" class="input w-auto">
    <select name="class" id="class_id" class="select w-auto min-w-[140px]">
        <option value="">Select Class</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}" @selected($classId == $class->id)>{{ $class->name }}</option>
        @endforeach
    </select>
    <select name="section" id="section_id" class="select w-auto min-w-[140px]">
        <option value="">Select Section</option>
    </select>
    <button type="submit" class="btn-primary">Load Students</button>
</form>

@if($students->count())
<form method="POST" action="{{ route('attendance.store') }}" class="table-wrap">
    @csrf
    <input type="hidden" name="date" value="{{ $date }}">
    <input type="hidden" name="school_class_id" value="{{ $classId }}">
    <input type="hidden" name="section_id" value="{{ $sectionId }}">
    <table class="data-table">
        <thead>
            <tr><th>Roll</th><th>Name</th><th>Status</th></tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td class="font-mono text-slate-500">{{ $student->roll_no ?? '—' }}</td>
                    <td class="font-medium text-slate-800">{{ $student->name }}</td>
                    <td>
                        @php $current = $attendances[$student->id] ?? 'present'; @endphp
                        <select name="attendance[{{ $student->id }}]" class="select w-auto min-w-[130px]">
                            @foreach(['present','absent','late','leave'] as $s)
                                <option value="{{ $s }}" @selected($current === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        <button type="submit" class="btn-primary bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500">Save Attendance</button>
    </div>
</form>
@elseif($classId && $sectionId)
    <div class="card card-body empty-state">No active students in this section.</div>
@else
    <div class="card card-body empty-state">Select a class and section to mark attendance.</div>
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
