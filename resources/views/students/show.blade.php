@extends('layouts.app')
@section('title', $student->name)
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="card card-body lg:col-span-1">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-xl font-bold text-white">
                {{ strtoupper(substr($student->name, 0, 1)) }}
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-900">{{ $student->name }}</h3>
                <p class="text-sm font-mono text-slate-400">{{ $student->admission_no }}</p>
            </div>
        </div>
        <dl class="space-y-4 text-sm">
            <div><dt class="text-slate-400 text-xs uppercase tracking-wide mb-0.5">Class</dt><dd class="font-medium">{{ $student->schoolClass->name }} · {{ $student->section->name }}</dd></div>
            <div><dt class="text-slate-400 text-xs uppercase tracking-wide mb-0.5">Roll No</dt><dd>{{ $student->roll_no ?? '—' }}</dd></div>
            <div><dt class="text-slate-400 text-xs uppercase tracking-wide mb-0.5">Gender</dt><dd>{{ ucfirst($student->gender) }}</dd></div>
            <div><dt class="text-slate-400 text-xs uppercase tracking-wide mb-0.5">DOB</dt><dd>{{ $student->date_of_birth?->format('d M Y') ?? '—' }}</dd></div>
            <div><dt class="text-slate-400 text-xs uppercase tracking-wide mb-0.5">Guardian</dt><dd>{{ $student->guardian_name }}<br><span class="text-slate-500">{{ $student->guardian_phone }}</span></dd></div>
            <div><dt class="text-slate-400 text-xs uppercase tracking-wide mb-0.5">Status</dt><dd><span class="badge-success">{{ ucfirst($student->status) }}</span></dd></div>
        </dl>
        <a href="{{ route('students.edit', $student) }}" class="btn-secondary w-full mt-6 justify-center">Edit Student</a>
    </div>
    <div class="lg:col-span-2 space-y-6">
        <div class="card">
            <div class="card-header"><h4 class="font-semibold text-slate-800">Recent Attendance</h4></div>
            <div class="divide-y divide-slate-50">
                @forelse($student->attendances->take(10) as $att)
                    <div class="flex justify-between items-center px-6 py-3 text-sm">
                        <span class="text-slate-600">{{ $att->date->format('d M Y') }}</span>
                        <span class="{{ $att->status === 'present' ? 'badge-success' : ($att->status === 'absent' ? 'badge-danger' : 'badge-warning') }}">{{ ucfirst($att->status) }}</span>
                    </div>
                @empty
                    <div class="empty-state !py-8">No attendance records.</div>
                @endforelse
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h4 class="font-semibold text-slate-800">Fee Payments</h4></div>
            <div class="divide-y divide-slate-50">
                @forelse($student->feePayments as $payment)
                    <div class="flex justify-between items-center px-6 py-3 text-sm">
                        <div>
                            <div class="font-medium text-slate-800">{{ $payment->feeType->name }}</div>
                            <div class="text-xs text-slate-400 font-mono">{{ $payment->receipt_no }}</div>
                        </div>
                        <span class="font-semibold text-emerald-600">৳{{ number_format($payment->amount_paid, 0) }}</span>
                    </div>
                @empty
                    <div class="empty-state !py-8">No fee payments.</div>
                @endforelse
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h4 class="font-semibold text-slate-800">Exam Results</h4></div>
            <div class="divide-y divide-slate-50">
                @forelse($student->examResults as $result)
                    <div class="flex justify-between items-center px-6 py-3 text-sm">
                        <div>
                            <div class="font-medium text-slate-800">{{ $result->subject->name }}</div>
                            <div class="text-xs text-slate-400">{{ $result->exam_name }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-medium">{{ $result->marks_obtained }}/{{ $result->total_marks }}</div>
                            <span class="{{ in_array($result->grade, ['A+','A','A-']) ? 'badge-success' : 'badge-warning' }}">{{ $result->grade }}</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state !py-8">No exam results.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
