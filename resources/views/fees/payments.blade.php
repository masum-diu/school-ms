@extends('layouts.app')
@section('title', 'Fee Payments')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="card card-body">
        <h3 class="form-section-title">Record Payment</h3>
        <form method="POST" action="{{ route('fees.payments.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="label">Student <span class="text-red-500">*</span></label>
                <select name="student_id" required class="select">
                    <option value="">Select Student</option>
                    @foreach($students as $s)<option value="{{ $s->id }}">{{ $s->name }} ({{ $s->admission_no }})</option>@endforeach
                </select>
            </div>
            <div>
                <label class="label">Fee Type <span class="text-red-500">*</span></label>
                <select name="fee_type_id" required class="select">
                    @foreach($feeTypes as $f)<option value="{{ $f->id }}">{{ $f->name }} — ৳{{ number_format($f->amount, 0) }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="label">Amount Paid (৳) <span class="text-red-500">*</span></label>
                <input type="number" name="amount_paid" step="0.01" required class="input" min="0">
            </div>
            <div>
                <label class="label">Payment Date <span class="text-red-500">*</span></label>
                <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required class="input">
            </div>
            <div>
                <label class="label">Method</label>
                <select name="payment_method" class="select">
                    @foreach(['cash','bank','mobile_banking','other'] as $m)
                        <option value="{{ $m }}">{{ ucfirst(str_replace('_', ' ', $m)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Month</label>
                <input type="text" name="month" placeholder="e.g. January 2026" class="input">
            </div>
            <button type="submit" class="btn-primary w-full bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500">Record Payment</button>
        </form>
    </div>
    <div class="lg:col-span-2">
        <form method="GET" class="filter-bar !mb-4 !p-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search receipt or student..." class="input max-w-xs">
            <button type="submit" class="btn-secondary">Search</button>
        </form>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Receipt</th><th>Student</th><th>Fee</th><th>Amount</th><th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td><span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded-lg">{{ $payment->receipt_no }}</span></td>
                            <td class="font-medium text-slate-800">{{ $payment->student->name }}</td>
                            <td class="text-slate-500">{{ $payment->feeType->name }}</td>
                            <td class="font-semibold text-emerald-600">৳{{ number_format($payment->amount_paid, 0) }}</td>
                            <td class="text-slate-400">{{ $payment->payment_date->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty-state">No payments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4 border-t border-slate-100">{{ $payments->links() }}</div>
        </div>
    </div>
</div>
@endsection
