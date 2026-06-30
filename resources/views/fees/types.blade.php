@extends('layouts.app')
@section('title', 'Fee Types')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="card card-body">
        <h3 class="form-section-title">Add Fee Type</h3>
        <form method="POST" action="{{ route('fees.types.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="label">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" required class="input" placeholder="Monthly Tuition">
            </div>
            <div>
                <label class="label">Amount (৳) <span class="text-red-500">*</span></label>
                <input type="number" name="amount" step="0.01" required class="input" min="0">
            </div>
            <div>
                <label class="label">Class</label>
                <select name="school_class_id" class="select">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)<option value="{{ $class->id }}">{{ $class->name }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="label">Frequency</label>
                <select name="frequency" class="select">
                    @foreach(['monthly','quarterly','yearly','one_time'] as $f)
                        <option value="{{ $f }}">{{ ucfirst(str_replace('_', ' ', $f)) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-primary w-full">Add Fee Type</button>
        </form>
    </div>
    <div class="lg:col-span-2 table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th><th>Amount</th><th>Class</th><th>Frequency</th><th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feeTypes as $fee)
                    <tr>
                        <td class="font-medium text-slate-800">{{ $fee->name }}</td>
                        <td class="font-semibold text-emerald-600">৳{{ number_format($fee->amount, 0) }}</td>
                        <td>{{ $fee->schoolClass?->name ?? 'All' }}</td>
                        <td><span class="badge-neutral">{{ ucfirst(str_replace('_', ' ', $fee->frequency)) }}</span></td>
                        <td class="text-right">
                            <form method="POST" action="{{ route('fees.types.destroy', $fee) }}" class="inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="btn-ghost text-xs text-red-600 hover:bg-red-50">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty-state">No fee types yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">{{ $feeTypes->links() }}</div>
    </div>
</div>
@endsection
