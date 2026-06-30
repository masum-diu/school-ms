@extends('layouts.app')
@section('title', 'Add Exam Result')
@section('content')
<div class="max-w-lg">
    <form method="POST" action="{{ route('exams.store') }}" class="card card-body">
        @csrf
        <div class="space-y-5">
            <div>
                <label class="label">Exam Name <span class="text-red-500">*</span></label>
                <input type="text" name="exam_name" value="{{ old('exam_name', 'Mid Term') }}" required class="input">
            </div>
            <div>
                <label class="label">Student <span class="text-red-500">*</span></label>
                <select name="student_id" required class="select">
                    <option value="">Select Student</option>
                    @foreach(\App\Models\Student::where('status','active')->with('schoolClass')->orderBy('name')->get() as $s)
                        <option value="{{ $s->id }}" @selected(old('student_id') == $s->id)>{{ $s->name }} — {{ $s->schoolClass->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Subject <span class="text-red-500">*</span></label>
                <select name="subject_id" required class="select">
                    @foreach($subjects as $sub)
                        <option value="{{ $sub->id }}" @selected(old('subject_id') == $sub->id)>{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-grid !gap-4">
                <div>
                    <label class="label">Marks Obtained <span class="text-red-500">*</span></label>
                    <input type="number" name="marks_obtained" step="0.01" value="{{ old('marks_obtained') }}" required class="input" min="0">
                </div>
                <div>
                    <label class="label">Total Marks <span class="text-red-500">*</span></label>
                    <input type="number" name="total_marks" value="{{ old('total_marks', 100) }}" required class="input" min="1">
                </div>
            </div>
            <div>
                <label class="label">Exam Date <span class="text-red-500">*</span></label>
                <input type="date" name="exam_date" value="{{ old('exam_date', date('Y-m-d')) }}" required class="input">
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Save Result</button>
            <a href="{{ route('exams.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
