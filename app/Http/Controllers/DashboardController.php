<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\FeePayment;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        return view('dashboard', [
            'totalStudents' => Student::where('status', 'active')->count(),
            'totalTeachers' => Teacher::where('status', 'active')->count(),
            'totalClasses' => SchoolClass::count(),
            'todayPresent' => Attendance::where('date', $today)->where('status', 'present')->count(),
            'todayAbsent' => Attendance::where('date', $today)->where('status', 'absent')->count(),
            'monthlyFees' => FeePayment::whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->sum('amount_paid'),
            'recentStudents' => Student::with(['schoolClass', 'section'])
                ->where('status', 'active')
                ->latest()
                ->take(5)
                ->get(),
            'recentPayments' => FeePayment::with(['student', 'feeType'])
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
