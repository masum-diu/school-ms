<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Models\FeeType;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeController extends Controller
{
    public function types()
    {
        return view('fees.types', [
            'feeTypes' => FeeType::with('schoolClass')->latest()->paginate(15),
            'classes' => SchoolClass::orderBy('name')->get(),
        ]);
    }

    public function storeType(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'school_class_id' => 'nullable|exists:school_classes,id',
            'frequency' => 'required|in:monthly,quarterly,yearly,one_time',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        FeeType::create($data);

        return back()->with('success', 'Fee type created successfully.');
    }

    public function updateType(Request $request, FeeType $feeType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'school_class_id' => 'nullable|exists:school_classes,id',
            'frequency' => 'required|in:monthly,quarterly,yearly,one_time',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $feeType->update($data);

        return back()->with('success', 'Fee type updated successfully.');
    }

    public function destroyType(FeeType $feeType)
    {
        $feeType->delete();

        return back()->with('success', 'Fee type deleted successfully.');
    }

    public function payments(Request $request)
    {
        $query = FeePayment::with(['student.schoolClass', 'feeType', 'collectedBy']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('receipt_no', 'like', "%{$search}%")
                    ->orWhereHas('student', fn ($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        return view('fees.payments', [
            'payments' => $query->latest()->paginate(15)->withQueryString(),
            'students' => Student::where('status', 'active')->orderBy('name')->get(),
            'feeTypes' => FeeType::where('is_active', true)->get(),
        ]);
    }

    public function storePayment(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank,mobile_banking,other',
            'month' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $data['receipt_no'] = 'RCP-'.now()->format('Ymd').'-'.str_pad(FeePayment::count() + 1, 4, '0', STR_PAD_LEFT);
        $data['collected_by'] = Auth::id();

        FeePayment::create($data);

        return back()->with('success', 'Payment recorded successfully. Receipt: '.$data['receipt_no']);
    }
}
