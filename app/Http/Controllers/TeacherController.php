<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('employee_id', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return view('teachers.index', [
            'teachers' => $query->latest()->paginate(15)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers',
            'phone' => 'nullable|string',
            'gender' => 'required|in:male,female,other',
            'qualification' => 'nullable|string',
            'specialization' => 'nullable|string',
            'joining_date' => 'required|date',
            'salary' => 'nullable|numeric|min:0',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $teacher = Teacher::create($data);

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully. Employee ID: '.$teacher->employee_id);
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('subjects.schoolClass');

        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,'.$teacher->id,
            'phone' => 'nullable|string',
            'gender' => 'required|in:male,female,other',
            'qualification' => 'nullable|string',
            'specialization' => 'nullable|string',
            'joining_date' => 'required|date',
            'salary' => 'nullable|numeric|min:0',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $teacher->update($data);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
