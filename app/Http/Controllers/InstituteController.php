<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\Roll;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function index()
    {
        // $institutes = Institute::with('sections')->get();
        $institutes = Institute::with('section', 'student')->get();

        return view('admin.institute.index', compact('institutes'));
    }
    public function create()
    {
        $sections = Section::with('institute')->get();

        $checkstudent = Roll::where('slug', 'student')->first();

        $users =User::where('rolls_id', $checkstudent->id)->with('institute')->get();
        return view('admin.institute.create', compact('sections','users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:institutes,name',
            'address' => 'required|string|max:255|unique:institutes,name,' ,
            'mobile' => 'required|max:12',
            'description' => 'nullable|string',
            'section_id' => 'required|exists:sections,id',
            'student_id' => 'required|exists:users,id'
        ]);

        Institute::create([
            'name' =>$request->name,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'description' => $request->description,
            'section_id' => $request->section_id,
            'student_id' => $request->student_id
        ]);

        return redirect()->route('institute.index')->with('success', 'Institute created successfully!');
    }

    public function edit(string $id)
    {
        $institute = Institute::findOrFail($id);
        return view('admin.institute.edit', compact('institute'));
    }

    public function update(Request $request, string $id)
    {
        $institute = Institute::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:institutes,name,' . $institute->id,
            'address' => 'required|string|max:255|unique:institutes,name,' ,
            'mobile' => 'required|',
            'description' => 'nullable|string',
            'section_id' => 'required|exists:sections,id',
            'student_id' => 'required|exists:users,id'
        ]);

       $institute->update([
            'name' => $request->name,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'description' => $request->description,
            'section_id' => $request->section_id,
            'student_id' => $request->student_id
        ]);

        return redirect()->route('institute.index')->with('success', 'Institute updated successfully!');
    }
}
