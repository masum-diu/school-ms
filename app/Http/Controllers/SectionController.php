<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function store(Request $request, SchoolClass $schoolClass)
    {
        $data = $request->validate([
            'name' => 'required|string|max:10',
            'capacity' => 'nullable|integer|min:1',
        ]);

        $schoolClass->sections()->create($data);

        return back()->with('success', 'Section added successfully.');
    }

    public function destroy(SchoolClass $schoolClass, Section $section)
    {
        $section->delete();

        return back()->with('success', 'Section deleted successfully.');
    }
}
