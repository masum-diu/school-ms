<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['schoolClass', 'section']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('admission_no', 'like', "%{$search}%")
                    ->orWhere('roll_no', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class')) {
            $query->where('school_class_id', $request->class);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return view('students.index', [
            'students' => $query->latest()->paginate(15)->withQueryString(),
            'classes' => SchoolClass::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('students.create', [
            'classes' => SchoolClass::with('sections')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'roll_no' => 'nullable|string',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string',
            'address' => 'nullable|string',
            'guardian_name' => 'required|string',
            'guardian_phone' => 'required|string',
            'guardian_relation' => 'required|string',
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'admission_date' => 'required|date',
            'status' => 'required|in:active,inactive,graduated',
        ]);

        $student = Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student added successfully. Admission No: '.$student->admission_no);
    }

    public function show(Student $student)
    {
        $student->load(['schoolClass', 'section', 'attendances', 'feePayments.feeType', 'examResults.subject']);

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', [
            'student' => $student,
            'classes' => SchoolClass::with('sections')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'roll_no' => 'nullable|string',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string',
            'address' => 'nullable|string',
            'guardian_name' => 'required|string',
            'guardian_phone' => 'required|string',
            'guardian_relation' => 'required|string',
            'school_class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'admission_date' => 'required|date',
            'status' => 'required|in:active,inactive,graduated',
        ]);

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function sections(SchoolClass $schoolClass)
    {
        return response()->json($schoolClass->sections);
    }
}
