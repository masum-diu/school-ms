@extends('layouts.app')
@section('title', 'Fee Types')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold mb-4">Add Fee Type</h3>
        <form method="POST" action="{{ route('fees.types.store') }}" class="space-y-3">
            @csrf
            <div><label class="block text-sm font-medium mb-1">Name *</label><input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Amount (৳) *</label><input type="number" name="amount" step="0.01" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Class</label>
                <select name="school_class_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)<option value="{{ $class->id }}">{{ $class->name }}</option>@endforeach
                </select>
            </div>
            <div><label class="block text-sm font-medium mb-1">Frequency</label>
                <select name="frequency" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach(['monthly','quarterly','yearly','one_time'] as $f)<option value="{{ $f }}">{{ ucfirst(str_replace('_', ' ', $f)) }}</option>@endforeach
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm w-full">Add Fee Type</button>
        </form>
    </div>
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b"><tr>
                <th class="text-left px-4 py-3">Name</th><th class="text-left px-4 py-3">Amount</th>
                <th class="text-left px-4 py-3">Class</th><th class="text-left px-4 py-3">Frequency</th>
                <th class="text-right px-4 py-3">Actions</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($feeTypes as $fee)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $fee->name }}</td>
                        <td class="px-4 py-3">৳{{ number_format($fee->amount, 0) }}</td>
                        <td class="px-4 py-3">{{ $fee->schoolClass?->name ?? 'All' }}</td>
                        <td class="px-4 py-3">{{ ucfirst(str_replace('_', ' ', $fee->frequency)) }}</td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('fees.types.destroy', $fee) }}" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline text-sm">Delete</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">No fee types yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $feeTypes->links() }}</div>
    </div>
</div>
@endsection
