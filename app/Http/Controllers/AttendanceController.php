<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::with('sections')->orderBy('name')->get();
        $date = $request->get('date', now()->toDateString());
        $classId = $request->get('class');
        $sectionId = $request->get('section');

        $students = collect();
        $attendances = collect();

        if ($classId && $sectionId) {
            $students = Student::where('school_class_id', $classId)
                ->where('section_id', $sectionId)
                ->where('status', 'active')
                ->orderBy('roll_no')
                ->get();

            $attendances = Attendance::where('date', $date)
                ->whereIn('student_id', $students->pluck('id'))
                ->pluck('status', 'student_id');
        }

        return view('attendance.index', compact('classes', 'date', 'classId', 'sectionId', 'students', 'attendances'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent,late,leave',
        ]);

        foreach ($data['attendance'] as $studentId => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'date' => $data['date']],
                [
                    'school_class_id' => $data['school_class_id'],
                    'section_id' => $data['section_id'],
                    'status' => $status,
                    'marked_by' => Auth::id(),
                ]
            );
        }

        return back()->with('success', 'Attendance saved successfully.');
    }

    public function report(Request $request)
    {
        $classes = SchoolClass::with('sections')->orderBy('name')->get();
        $classId = $request->get('class');
        $sectionId = $request->get('section');
        $month = $request->get('month', now()->format('Y-m'));

        $report = collect();

        if ($classId && $sectionId) {
            $students = Student::where('school_class_id', $classId)
                ->where('section_id', $sectionId)
                ->where('status', 'active')
                ->orderBy('roll_no')
                ->get();

            [$year, $mon] = explode('-', $month);
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, (int) $mon, (int) $year);

            foreach ($students as $student) {
                $attendances = Attendance::where('student_id', $student->id)
                    ->whereYear('date', $year)
                    ->whereMonth('date', $mon)
                    ->get();

                $report->push([
                    'student' => $student,
                    'present' => $attendances->where('status', 'present')->count(),
                    'absent' => $attendances->where('status', 'absent')->count(),
                    'late' => $attendances->where('status', 'late')->count(),
                    'leave' => $attendances->where('status', 'leave')->count(),
                    'total_days' => $daysInMonth,
                ]);
            }
        }

        return view('attendance.report', compact('classes', 'classId', 'sectionId', 'month', 'report'));
    }
}
