@extends('layouts.app')
@section('title', 'Fee Payments')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold mb-4">Record Payment</h3>
        <form method="POST" action="{{ route('fees.payments.store') }}" class="space-y-3">
            @csrf
            <div><label class="block text-sm font-medium mb-1">Student *</label>
                <select name="student_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Select Student</option>
                    @foreach($students as $s)<option value="{{ $s->id }}">{{ $s->name }} ({{ $s->admission_no }})</option>@endforeach
                </select>
            </div>
            <div><label class="block text-sm font-medium mb-1">Fee Type *</label>
                <select name="fee_type_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach($feeTypes as $f)<option value="{{ $f->id }}">{{ $f->name }} — ৳{{ number_format($f->amount, 0) }}</option>@endforeach
                </select>
            </div>
            <div><label class="block text-sm font-medium mb-1">Amount Paid (৳) *</label><input type="number" name="amount_paid" step="0.01" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Payment Date *</label><input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Method</label>
                <select name="payment_method" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach(['cash','bank','mobile_banking','other'] as $m)<option value="{{ $m }}">{{ ucfirst(str_replace('_', ' ', $m)) }}</option>@endforeach
                </select>
            </div>
            <div><label class="block text-sm font-medium mb-1">Month</label><input type="text" name="month" placeholder="e.g. January 2026" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm w-full font-medium">Record Payment</button>
        </form>
    </div>
    <div class="lg:col-span-2">
        <form method="GET" class="mb-4"><input type="text" name="search" value="{{ request('search') }}" placeholder="Search receipt or student..." class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-64"></form>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b"><tr>
                    <th class="text-left px-4 py-3">Receipt</th><th class="text-left px-4 py-3">Student</th>
                    <th class="text-left px-4 py-3">Fee</th><th class="text-left px-4 py-3">Amount</th>
                    <th class="text-left px-4 py-3">Date</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($payments as $payment)
                        <tr>
                            <td class="px-4 py-3 font-mono text-xs">{{ $payment->receipt_no }}</td>
                            <td class="px-4 py-3 font-medium">{{ $payment->student->name }}</td>
                            <td class="px-4 py-3">{{ $payment->feeType->name }}</td>
                            <td class="px-4 py-3 text-green-600 font-medium">৳{{ number_format($payment->amount_paid, 0) }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $payment->payment_date->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">No payments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">{{ $payments->links() }}</div>
        </div>
    </div>
</div>
@endsection
