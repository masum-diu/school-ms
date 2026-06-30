@extends('layouts.app')
@section('title', 'Add Student')
@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('students.store') }}" class="card card-body max-w-3xl space-y-5">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2 info-banner">
                Admission No will be generated automatically (e.g. ADM-2026-0001)
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Roll No</label>
                <input type="text" name="roll_no" value="{{ old('roll_no') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gender *</label>
                <select name="gender" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach(['male','female','other'] as $g)
                        <option value="{{ $g }}" @selected(old('gender') == $g)>{{ ucfirst($g) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Blood Group</label>
                <input type="text" name="blood_group" value="{{ old('blood_group') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Class *</label>
                <select name="school_class_id" id="class_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected(old('school_class_id') == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Section *</label>
                <select name="section_id" id="section_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Select Section</option>
                </select>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('address') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Guardian Name *</label>
                <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Guardian Phone *</label>
                <input type="text" name="guardian_phone" value="{{ old('guardian_phone') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Relation</label>
                <input type="text" name="guardian_relation" value="{{ old('guardian_relation', 'parent') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Admission Date *</label>
                <input type="date" name="admission_date" value="{{ old('admission_date', date('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach(['active','inactive','graduated'] as $s)
                        <option value="{{ $s }}" @selected(old('status', 'active') == $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Save Student</button>
            <a href="{{ route('students.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
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
if (classSelect.value) loadSections(classSelect.value, '{{ old('section_id') }}');
</script>
@endsection
