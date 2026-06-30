@extends('layouts.app')
@section('title', 'Add Student')
@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('students.store') }}" class="card card-body">
        @csrf
        <div class="info-banner mb-6">
            Admission No will be generated automatically (e.g. ADM-2026-0001)
        </div>
        <p class="form-section-title">Personal Information</p>
        <div class="form-grid mb-6">
            <div>
                <label class="label">Roll No</label>
                <input type="text" name="roll_no" value="{{ old('roll_no') }}" class="input" placeholder="e.g. 1">
            </div>
            <div>
                <label class="label">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="input" placeholder="Student full name">
            </div>
            <div>
                <label class="label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="input" placeholder="student@email.com">
            </div>
            <div>
                <label class="label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="input" placeholder="01XXXXXXXXX">
            </div>
            <div>
                <label class="label">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="input">
            </div>
            <div>
                <label class="label">Gender <span class="text-red-500">*</span></label>
                <select name="gender" required class="select">
                    @foreach(['male','female','other'] as $g)
                        <option value="{{ $g }}" @selected(old('gender', 'male') == $g)>{{ ucfirst($g) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Blood Group</label>
                <input type="text" name="blood_group" value="{{ old('blood_group') }}" class="input" placeholder="e.g. B+">
            </div>
            <div class="sm:col-span-2">
                <label class="label">Address</label>
                <textarea name="address" rows="2" class="textarea" placeholder="Full address">{{ old('address') }}</textarea>
            </div>
        </div>

        <p class="form-section-title">Academic Information</p>
        <div class="form-grid mb-6">
            <div>
                <label class="label">Class <span class="text-red-500">*</span></label>
                <select name="school_class_id" id="class_id" required class="select">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected(old('school_class_id') == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Section <span class="text-red-500">*</span></label>
                <select name="section_id" id="section_id" required class="select">
                    <option value="">Select Section</option>
                </select>
            </div>
            <div>
                <label class="label">Admission Date <span class="text-red-500">*</span></label>
                <input type="date" name="admission_date" value="{{ old('admission_date', date('Y-m-d')) }}" required class="input">
            </div>
            <div>
                <label class="label">Status</label>
                <select name="status" class="select">
                    @foreach(['active','inactive','graduated'] as $s)
                        <option value="{{ $s }}" @selected(old('status', 'active') == $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <p class="form-section-title">Guardian Information</p>
        <div class="form-grid">
            <div>
                <label class="label">Guardian Name <span class="text-red-500">*</span></label>
                <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" required class="input">
            </div>
            <div>
                <label class="label">Guardian Phone <span class="text-red-500">*</span></label>
                <input type="text" name="guardian_phone" value="{{ old('guardian_phone') }}" required class="input">
            </div>
            <div>
                <label class="label">Relation</label>
                <input type="text" name="guardian_relation" value="{{ old('guardian_relation', 'parent') }}" class="input">
            </div>
        </div>

        <div class="form-actions">
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
