@extends('layouts.app')
@section('title', 'Attendance Report')
@section('content')
<form method="GET" class="flex flex-wrap gap-3 mb-6 bg-white p-4 rounded-xl border border-gray-100">
    <input type="month" name="month" value="{{ $month }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
    <select name="class" id="class_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
        <option value="">Select Class</option>
        @foreach($classes as $class)<option value="{{ $class->id }}" @selected($classId == $class->id)>{{ $class->name }}</option>@endforeach
    </select>
    <select name="section" id="section_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
        <option value="">Select Section</option>
    </select>
    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm">Generate Report</button>
</form>

@if($report->count())
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3">Student</th>
                <th class="text-center px-4 py-3 text-green-600">Present</th>
                <th class="text-center px-4 py-3 text-red-600">Absent</th>
                <th class="text-center px-4 py-3 text-amber-600">Late</th>
                <th class="text-center px-4 py-3 text-blue-600">Leave</th>
                <th class="text-center px-4 py-3">%</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($report as $row)
                @php $total = $row['present'] + $row['absent'] + $row['late'] + $row['leave']; $pct = $total > 0 ? round(($row['present'] / $total) * 100) : 0; @endphp
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $row['student']->name }}</td>
                    <td class="px-4 py-3 text-center text-green-600">{{ $row['present'] }}</td>
                    <td class="px-4 py-3 text-center text-red-600">{{ $row['absent'] }}</td>
                    <td class="px-4 py-3 text-center text-amber-600">{{ $row['late'] }}</td>
                    <td class="px-4 py-3 text-center text-blue-600">{{ $row['leave'] }}</td>
                    <td class="px-4 py-3 text-center font-medium">{{ $pct }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
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
