@extends('layouts.app')
@section('title', $teacher->name)
@section('content')
<div class="max-w-2xl">
    <div class="card card-body">
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-xl font-bold text-white">
                {{ strtoupper(substr($teacher->name, 0, 1)) }}
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-900">{{ $teacher->name }}</h3>
                <p class="text-sm font-mono text-slate-400">{{ $teacher->employee_id }}</p>
            </div>
            <span class="ml-auto {{ $teacher->status === 'active' ? 'badge-success' : 'badge-neutral' }}">{{ ucfirst($teacher->status) }}</span>
        </div>
        <dl class="grid grid-cols-2 gap-5 text-sm">
            <div><dt class="text-slate-400 text-xs uppercase tracking-wide mb-1">Email</dt><dd class="font-medium">{{ $teacher->email }}</dd></div>
            <div><dt class="text-slate-400 text-xs uppercase tracking-wide mb-1">Phone</dt><dd>{{ $teacher->phone ?? '—' }}</dd></div>
            <div><dt class="text-slate-400 text-xs uppercase tracking-wide mb-1">Specialization</dt><dd>{{ $teacher->specialization ?? '—' }}</dd></div>
            <div><dt class="text-slate-400 text-xs uppercase tracking-wide mb-1">Qualification</dt><dd>{{ $teacher->qualification ?? '—' }}</dd></div>
            <div><dt class="text-slate-400 text-xs uppercase tracking-wide mb-1">Joining Date</dt><dd>{{ $teacher->joining_date->format('d M Y') }}</dd></div>
            <div><dt class="text-slate-400 text-xs uppercase tracking-wide mb-1">Salary</dt><dd>{{ $teacher->salary ? '৳'.number_format($teacher->salary, 0) : '—' }}</dd></div>
        </dl>
        @if($teacher->subjects->count())
            <div class="mt-6 pt-6 border-t border-slate-100">
                <h4 class="form-section-title">Assigned Subjects</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($teacher->subjects as $subject)
                        <span class="badge-neutral">{{ $subject->name }}@if($subject->schoolClass) · {{ $subject->schoolClass->name }}@endif</span>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="form-actions !border-t-0 !pt-6">
            <a href="{{ route('teachers.edit', $teacher) }}" class="btn-primary">Edit Teacher</a>
            <a href="{{ route('teachers.index') }}" class="btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
