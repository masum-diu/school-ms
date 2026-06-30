@extends('layouts.app')
@section('title', 'Attendance Report')
@section('content')
<form method="GET" class="filter-bar">
    <input type="month" name="month" value="{{ $month }}" class="input w-auto">
    <select name="class" id="class_id" class="select w-auto min-w-[140px]">
        <option value="">Select Class</option>
        @foreach($classes as $class)<option value="{{ $class->id }}" @selected($classId == $class->id)>{{ $class->name }}</option>@endforeach
    </select>
    <select name="section" id="section_id" class="select w-auto min-w-[140px]">
        <option value="">Select Section</option>
    </select>
    <button type="submit" class="btn-primary">Generate Report</button>
</form>

@if($report->count())
<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Student</th>
                <th class="text-center text-emerald-600">Present</th>
                <th class="text-center text-red-600">Absent</th>
                <th class="text-center text-amber-600">Late</th>
                <th class="text-center text-blue-600">Leave</th>
                <th class="text-center">%</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report as $row)
                @php $total = $row['present'] + $row['absent'] + $row['late'] + $row['leave']; $pct = $total > 0 ? round(($row['present'] / $total) * 100) : 0; @endphp
                <tr>
                    <td class="font-medium text-slate-800">{{ $row['student']->name }}</td>
                    <td class="text-center text-emerald-600 font-medium">{{ $row['present'] }}</td>
                    <td class="text-center text-red-600 font-medium">{{ $row['absent'] }}</td>
                    <td class="text-center text-amber-600 font-medium">{{ $row['late'] }}</td>
                    <td class="text-center text-blue-600 font-medium">{{ $row['leave'] }}</td>
                    <td class="text-center">
                        <span class="badge {{ $pct >= 75 ? 'badge-success' : ($pct >= 50 ? 'badge-warning' : 'badge-danger') }}">{{ $pct }}%</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@elseif($classId && $sectionId)
    <div class="card card-body empty-state">No attendance data for this period.</div>
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
