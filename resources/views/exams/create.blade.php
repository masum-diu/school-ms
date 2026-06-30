@extends('layouts.app')
@section('title', 'Add Exam Result')
@section('content')
<div class="max-w-lg">
    <form method="POST" action="{{ route('exams.store') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        @csrf
        <div><label class="block text-sm font-medium mb-1">Exam Name *</label><input type="text" name="exam_name" value="{{ old('exam_name', 'Mid Term') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Student *</label>
            <select name="student_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">Select Student</option>
                @foreach(\App\Models\Student::where('status','active')->with('schoolClass')->orderBy('name')->get() as $s)
                    <option value="{{ $s->id }}">{{ $s->name }} — {{ $s->schoolClass->name }}</option>
                @endforeach
            </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Subject *</label>
            <select name="subject_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                @foreach($subjects as $sub)<option value="{{ $sub->id }}">{{ $sub->name }}</option>@endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium mb-1">Marks Obtained *</label><input type="number" name="marks_obtained" step="0.01" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Total Marks *</label><input type="number" name="total_marks" value="100" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
        </div>
        <div><label class="block text-sm font-medium mb-1">Exam Date *</label><input type="date" name="exam_date" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
        <div class="flex gap-3">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-medium">Save Result</button>
            <a href="{{ route('exams.index') }}" class="bg-gray-100 px-6 py-2 rounded-lg text-sm">Cancel</a>
        </div>
    </form>
</div>
@endsection
