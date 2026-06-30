<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::with(['schoolClass', 'teacher']);

        if ($request->filled('class')) {
            $query->where('school_class_id', $request->class);
        }

        return view('subjects.index', [
            'subjects' => $query->orderBy('name')->paginate(15)->withQueryString(),
            'classes' => SchoolClass::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('subjects.create', [
            'classes' => SchoolClass::orderBy('name')->get(),
            'teachers' => Teacher::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:subjects',
            'school_class_id' => 'nullable|exists:school_classes,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'full_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:1',
        ]);

        Subject::create($data);

        return redirect()->route('subjects.index')->with('success', 'Subject added successfully.');
    }

    public function edit(Subject $subject)
    {
        return view('subjects.edit', [
            'subject' => $subject,
            'classes' => SchoolClass::orderBy('name')->get(),
            'teachers' => Teacher::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:subjects,code,'.$subject->id,
            'school_class_id' => 'nullable|exists:school_classes,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'full_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:1',
        ]);

        $subject->update($data);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
