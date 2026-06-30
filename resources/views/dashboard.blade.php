@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
    <div class="stat-card group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-500/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-110 transition-transform"></div>
        <div class="stat-icon bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">👨‍🎓</div>
        <div class="text-3xl font-bold text-slate-900 tracking-tight">{{ $totalStudents }}</div>
        <div class="text-sm text-slate-500 mt-1">Active Students</div>
    </div>
    <div class="stat-card group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-110 transition-transform"></div>
        <div class="stat-icon bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100">👨‍🏫</div>
        <div class="text-3xl font-bold text-slate-900 tracking-tight">{{ $totalTeachers }}</div>
        <div class="text-sm text-slate-500 mt-1">Active Teachers</div>
    </div>
    <div class="stat-card group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-violet-500/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-110 transition-transform"></div>
        <div class="stat-icon bg-violet-50 text-violet-600 ring-1 ring-violet-100">🏛️</div>
        <div class="text-3xl font-bold text-slate-900 tracking-tight">{{ $totalClasses }}</div>
        <div class="text-sm text-slate-500 mt-1">Total Classes</div>
    </div>
    <div class="stat-card group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-110 transition-transform"></div>
        <div class="stat-icon bg-amber-50 text-amber-600 ring-1 ring-amber-100">💰</div>
        <div class="text-3xl font-bold text-slate-900 tracking-tight">৳{{ number_format($monthlyFees, 0) }}</div>
        <div class="text-sm text-slate-500 mt-1">Fees This Month</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-slate-800">Today's Attendance</h3>
            <a href="{{ route('attendance.index') }}" class="btn-ghost text-xs">Mark →</a>
        </div>
        <div class="card-body pt-2">
            <div class="flex gap-8">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center ring-1 ring-emerald-100">
                        <span class="text-2xl font-bold text-emerald-600">{{ $todayPresent }}</span>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-700">Present</div>
                        <div class="text-xs text-slate-400">Marked today</div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center ring-1 ring-red-100">
                        <span class="text-2xl font-bold text-red-600">{{ $todayAbsent }}</span>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-700">Absent</div>
                        <div class="text-xs text-slate-400">Marked today</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-slate-800">Quick Actions</h3>
        </div>
        <div class="card-body pt-2">
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('students.create') }}" class="flex items-center gap-3 p-3 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-medium transition-colors ring-1 ring-indigo-100">
                    <span class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-base shadow-sm">+</span>
                    Add Student
                </a>
                <a href="{{ route('teachers.create') }}" class="flex items-center gap-3 p-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-sm font-medium transition-colors ring-1 ring-emerald-100">
                    <span class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-base shadow-sm">+</span>
                    Add Teacher
                </a>
                <a href="{{ route('fees.payments') }}" class="flex items-center gap-3 p-3 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 text-sm font-medium transition-colors ring-1 ring-amber-100">
                    <span class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-base shadow-sm">৳</span>
                    Collect Fee
                </a>
                <a href="{{ route('exams.create') }}" class="flex items-center gap-3 p-3 rounded-xl bg-violet-50 hover:bg-violet-100 text-violet-700 text-sm font-medium transition-colors ring-1 ring-violet-100">
                    <span class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-base shadow-sm">📝</span>
                    Add Result
                </a>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-slate-800">Recent Students</h3>
            <a href="{{ route('students.index') }}" class="btn-ghost text-xs">View all →</a>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($recentStudents as $student)
                <div class="flex items-center justify-between px-6 py-3.5 hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-xs font-bold text-white">
                            {{ strtoupper(substr($student->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-medium text-sm text-slate-800">{{ $student->name }}</div>
                            <div class="text-xs text-slate-400">{{ $student->schoolClass->name }} · Sec {{ $student->section->name }}</div>
                        </div>
                    </div>
                    <span class="badge-success font-mono">{{ $student->admission_no }}</span>
                </div>
            @empty
                <div class="empty-state">No students yet.</div>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-slate-800">Recent Fee Payments</h3>
            <a href="{{ route('fees.payments') }}" class="btn-ghost text-xs">View all →</a>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($recentPayments as $payment)
                <div class="flex items-center justify-between px-6 py-3.5 hover:bg-slate-50/50 transition-colors">
                    <div>
                        <div class="font-medium text-sm text-slate-800">{{ $payment->student->name }}</div>
                        <div class="text-xs text-slate-400">{{ $payment->feeType->name }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-sm text-emerald-600">৳{{ number_format($payment->amount_paid, 0) }}</div>
                        <div class="text-xs text-slate-400">{{ $payment->payment_date->format('d M Y') }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-state">No payments yet.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
