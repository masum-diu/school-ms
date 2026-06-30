@extends('layouts.app')
@section('title', 'Edit Student')
@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('students.update', $student) }}" class="card card-body">
        @csrf @method('PUT')
        <div class="form-grid">
            <div>
                <label class="label">Admission No</label>
                <input type="text" value="{{ $student->admission_no }}" disabled class="input-disabled font-mono">
            </div>
            <div>
                <label class="label">Roll No</label>
                <input type="text" name="roll_no" value="{{ old('roll_no', $student->roll_no) }}" class="input">
            </div>
            <div class="sm:col-span-2">
                <label class="label">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $student->name) }}" required class="input">
            </div>
            <div>
                <label class="label">Email</label>
                <input type="email" name="email" value="{{ old('email', $student->email) }}" class="input">
            </div>
            <div>
                <label class="label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" class="input">
            </div>
            <div>
                <label class="label">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}" class="input">
            </div>
            <div>
                <label class="label">Gender <span class="text-red-500">*</span></label>
                <select name="gender" required class="select">
                    @foreach(['male','female','other'] as $g)
                        <option value="{{ $g }}" @selected(old('gender', $student->gender) == $g)>{{ ucfirst($g) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Class <span class="text-red-500">*</span></label>
                <select name="school_class_id" id="class_id" required class="select">
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected(old('school_class_id', $student->school_class_id) == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Section <span class="text-red-500">*</span></label>
                <select name="section_id" id="section_id" required class="select"></select>
            </div>
            <div>
                <label class="label">Guardian Name <span class="text-red-500">*</span></label>
                <input type="text" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}" required class="input">
            </div>
            <div>
                <label class="label">Guardian Phone <span class="text-red-500">*</span></label>
                <input type="text" name="guardian_phone" value="{{ old('guardian_phone', $student->guardian_phone) }}" required class="input">
            </div>
            <div>
                <label class="label">Relation</label>
                <input type="text" name="guardian_relation" value="{{ old('guardian_relation', $student->guardian_relation) }}" class="input">
            </div>
            <div>
                <label class="label">Admission Date <span class="text-red-500">*</span></label>
                <input type="date" name="admission_date" value="{{ old('admission_date', $student->admission_date->format('Y-m-d')) }}" required class="input">
            </div>
            <div>
                <label class="label">Status</label>
                <select name="status" class="select">
                    @foreach(['active','inactive','graduated'] as $s)
                        <option value="{{ $s }}" @selected(old('status', $student->status) == $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Update Student</button>
            <a href="{{ route('students.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<script>
const classes = @json($classes);
const classSelect = document.getElementById('class_id');
const sectionSelect = document.getElementById('section_id');
function loadSections(classId, selected) {
    sectionSelect.innerHTML = '';
    const cls = classes.find(c => c.id == classId);
    if (cls) cls.sections.forEach(s => {
        const opt = document.createElement('option');
        opt.value = s.id; opt.textContent = s.name;
        if (selected == s.id) opt.selected = true;
        sectionSelect.appendChild(opt);
    });
}
classSelect.addEventListener('change', () => loadSections(classSelect.value));
loadSections(classSelect.value, '{{ old('section_id', $student->section_id) }}');
</script>
@endsection
