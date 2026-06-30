<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    public function index(Request $request)
    {
        $query = ExamResult::with(['student.schoolClass', 'subject']);

        if ($request->filled('exam')) {
            $query->where('exam_name', $request->exam);
        }

        if ($request->filled('class')) {
            $query->whereHas('student', fn ($q) => $q->where('school_class_id', $request->class));
        }

        return view('exams.index', [
            'results' => $query->latest('exam_date')->paginate(20)->withQueryString(),
            'classes' => SchoolClass::orderBy('name')->get(),
            'examNames' => ExamResult::distinct()->pluck('exam_name'),
        ]);
    }

    public function create()
    {
        return view('exams.create', [
            'classes' => SchoolClass::with('sections')->orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_name' => 'required|string|max:255',
            'marks_obtained' => 'required|numeric|min:0',
            'total_marks' => 'required|integer|min:1',
            'exam_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $data['grade'] = ExamResult::calculateGrade($data['marks_obtained'], $data['total_marks']);

        ExamResult::updateOrCreate(
            [
                'student_id' => $data['student_id'],
                'subject_id' => $data['subject_id'],
                'exam_name' => $data['exam_name'],
            ],
            $data
        );

        return redirect()->route('exams.index')->with('success', 'Exam result saved successfully.');
    }

    public function destroy(ExamResult $exam)
    {
        $exam->delete();

        return back()->with('success', 'Exam result deleted successfully.');
    }

    public function students(SchoolClass $schoolClass)
    {
        return response()->json(
            Student::where('school_class_id', $schoolClass->id)
                ->where('status', 'active')
                ->orderBy('roll_no')
                ->get(['id', 'name', 'roll_no', 'section_id'])
        );
    }
}
