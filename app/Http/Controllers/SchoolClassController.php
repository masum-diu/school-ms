<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index()
    {
        return view('classes.index', [
            'classes' => SchoolClass::withCount(['students', 'sections'])->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:school_classes',
            'description' => 'nullable|string',
            'sections' => 'nullable|array',
            'sections.*' => 'string|max:10',
        ]);

        $class = SchoolClass::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'description' => $data['description'] ?? null,
        ]);

        if (! empty($data['sections'])) {
            foreach ($data['sections'] as $sectionName) {
                if (trim($sectionName)) {
                    $class->sections()->create(['name' => trim($sectionName)]);
                }
            }
        }

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    }

    public function show(SchoolClass $schoolClass)
    {
        $schoolClass->load(['sections', 'students.section', 'subjects.teacher']);

        return view('classes.show', ['schoolClass' => $schoolClass]);
    }

    public function edit(SchoolClass $schoolClass)
    {
        $schoolClass->load('sections');

        return view('classes.edit', ['schoolClass' => $schoolClass]);
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:school_classes,code,'.$schoolClass->id,
            'description' => 'nullable|string',
        ]);

        $schoolClass->update($data);

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(SchoolClass $schoolClass)
    {
        if ($schoolClass->students()->exists()) {
            return back()->withErrors([
                'delete' => 'Cannot delete this class while it has students. Move or remove students first.',
            ]);
        }

        $schoolClass->delete();

        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }
}
