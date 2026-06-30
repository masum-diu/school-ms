@extends('layouts.app')
@section('title', $student->name)
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold mb-1">{{ $student->name }}</h3>
        <p class="text-sm text-gray-500 mb-4">{{ $student->admission_no }}</p>
        <dl class="space-y-2 text-sm">
            <div><dt class="text-gray-500">Class</dt><dd class="font-medium">{{ $student->schoolClass->name }} - {{ $student->section->name }}</dd></div>
            <div><dt class="text-gray-500">Roll No</dt><dd>{{ $student->roll_no ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">Gender</dt><dd>{{ ucfirst($student->gender) }}</dd></div>
            <div><dt class="text-gray-500">DOB</dt><dd>{{ $student->date_of_birth?->format('d M Y') ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">Guardian</dt><dd>{{ $student->guardian_name }} ({{ $student->guardian_phone }})</dd></div>
            <div><dt class="text-gray-500">Status</dt><dd><span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">{{ ucfirst($student->status) }}</span></dd></div>
        </dl>
        <a href="{{ route('students.edit', $student) }}" class="mt-4 inline-block text-sm text-indigo-600 hover:underline">Edit Student</a>
    </div>
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold mb-3">Recent Attendance</h4>
            @forelse($student->attendances->take(10) as $att)
                <div class="flex justify-between text-sm py-1 border-b border-gray-50">
                    <span>{{ $att->date->format('d M Y') }}</span>
                    <span class="{{ $att->status === 'present' ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($att->status) }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-400">No attendance records.</p>
            @endforelse
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold mb-3">Fee Payments</h4>
            @forelse($student->feePayments as $payment)
                <div class="flex justify-between text-sm py-1 border-b border-gray-50">
                    <span>{{ $payment->feeType->name }} ({{ $payment->receipt_no }})</span>
                    <span class="text-green-600 font-medium">৳{{ number_format($payment->amount_paid, 0) }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-400">No fee payments.</p>
            @endforelse
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold mb-3">Exam Results</h4>
            @forelse($student->examResults as $result)
                <div class="flex justify-between text-sm py-1 border-b border-gray-50">
                    <span>{{ $result->subject->name }} — {{ $result->exam_name }}</span>
                    <span class="font-medium">{{ $result->marks_obtained }}/{{ $result->total_marks }} ({{ $result->grade }})</span>
                </div>
            @empty
                <p class="text-sm text-gray-400">No exam results.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
