@extends('layouts.app')
@section('title', $teacher->name)
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
    <h3 class="text-lg font-semibold mb-4">{{ $teacher->name }}</h3>
    <dl class="grid grid-cols-2 gap-4 text-sm">
        <div><dt class="text-gray-500">Employee ID</dt><dd class="font-medium">{{ $teacher->employee_id }}</dd></div>
        <div><dt class="text-gray-500">Email</dt><dd>{{ $teacher->email }}</dd></div>
        <div><dt class="text-gray-500">Phone</dt><dd>{{ $teacher->phone ?? '—' }}</dd></div>
        <div><dt class="text-gray-500">Specialization</dt><dd>{{ $teacher->specialization ?? '—' }}</dd></div>
        <div><dt class="text-gray-500">Qualification</dt><dd>{{ $teacher->qualification ?? '—' }}</dd></div>
        <div><dt class="text-gray-500">Joining Date</dt><dd>{{ $teacher->joining_date->format('d M Y') }}</dd></div>
    </dl>
    @if($teacher->subjects->count())
        <h4 class="font-semibold mt-6 mb-2">Assigned Subjects</h4>
        <ul class="text-sm space-y-1">
            @foreach($teacher->subjects as $subject)
                <li>{{ $subject->name }} @if($subject->schoolClass)({{ $subject->schoolClass->name }})@endif</li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
