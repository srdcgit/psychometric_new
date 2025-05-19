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
        $institutes = Institute::all();

        return view('admin.institute.index', compact('institutes'));
    }
    public function create()
    {


        return view('admin.institute.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:institutes,name',
            'address' => 'required|string|max:255|unique:institutes,name,' ,
            'mobile' => 'required|max:12',
            'allowed_students' => 'required|',
            'contact_person' => 'nullable|string'
        ]);

        Institute::create([
            'name' =>$request->name,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'allowed_students' =>$request->allowed_students,
            'contact_person' => $request->contact_person

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
