<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\Roll;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InstituteController extends Controller
{
    public function index()
    {
        // $institutes = Institute::with('sections')->get();
        //$institutes = Institute::all();
        $institutes = Institute::withCount('registeredStudents')->get();

        return view('admin.institute.index', compact('institutes'));
    }
    public function create()
    {
        return view('admin.institute.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $getrollid = Roll::where('slug', 'institute')->first();

        $request->validate([
            'name' => 'required|string|max:255|unique:institutes,name',
            'email' => 'required|string|email|max:255|unique:institutes,email|unique:users,email',
            'address' => 'required|string|max:255',
            'mobile' => 'required|string|max:12',
            'allowed_students' => 'required|integer|min:1',
            'contact_person' => 'nullable|string|max:255',

            // // Student-specific validation
            // 'age' => 'required|integer|min:1',
            // 'class' => 'required|string|max:255',
            // 'school' => 'required|string|max:255',
            // 'location' => 'required|string|max:255',
            // 'subjects_stream' => 'required|string|max:255',
            // 'career_aspiration' => 'nullable|string|max:255',
            // 'parental_occupation' => 'nullable|string|max:255',
        ]);

        // Create Institute
        $institute = Institute::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345678'), // Default password
            'address' => $request->address,
            'mobile' => $request->mobile,
            'allowed_students' => $request->allowed_students,
            'contact_person' => $request->contact_person,
        ]);

        // Create initial student user for that institute
        User::create([
            'rolls_id' => $getrollid->id,
            // 'register_institute_id' => $institute->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345678'), // Default password
            'age' => 01,
            'class' => 'null',
            'school' => 'null',
            'location' => 'null',
            'subjects_stream' => 'null',
            'career_aspiration' => 'null',
            'parental_occupation' => 'null',
        ]);

        return redirect()->route('institute.index')->with('success', 'Institute and student created successfully!');
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
            'address' => 'required|string|max:255|unique:institutes,name,',
            'mobile' => 'required|',
            'allowed_students' => 'required|',
            'contact_person' => 'nullable|string'
        ]);

        $institute->update([
            'name' => $request->name,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'allowed_students' => $request->allowed_students,
            'contact_person' => $request->description

        ]);

        return redirect()->route('institute.index')->with('success', 'Institute updated successfully!');
    }
}
