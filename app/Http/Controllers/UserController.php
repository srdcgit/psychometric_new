<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\Roll;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $studentRole = Roll::where('slug', 'student')->first();

        $query = User::where('rolls_id', $studentRole->id)->with('institute');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $students = $query->paginate(10)->appends($request->query());

        return view('admin.student.index', compact('students'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $institutes = Institute::all();
        return view('admin.student.create', compact('institutes'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $getrollid = Roll::where('slug', 'student')->first();

        $request->validate([
            'register_institute_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'age' => ['required', 'integer', 'min:1'],
            'class' => ['required', 'string', 'max:255'],
            'school' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'subjects_stream' => ['required', 'string', 'max:255'],
            'career_aspiration' => ['nullable', 'string', 'max:255'],
            'parental_occupation' => ['nullable', 'string', 'max:255'],

        ]);

        User::create([
            'rolls_id' => $getrollid->id,
            'register_institute_id' => $request->register_institute_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345678'), // Default password
            'age' => $request->age,
            'class' => $request->class,
            'school' => $request->school,
            'location' => $request->location,
            'subjects_stream' => $request->subjects_stream,
            'career_aspiration' => $request->career_aspiration,
            'parental_occupation' => $request->parental_occupation,
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = User::findOrFail($id);
        $institutes = Institute::all();

        return view('admin.student.edit', compact('student', 'institutes'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = User::findOrFail($id);

        $request->validate([
            'register_institute_id' => ['required', 'exists:institutes,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $student->id],
            'age' => ['required', 'integer', 'min:1'],
            'class' => ['required', 'string', 'max:255'],
            'school' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'subjects_stream' => ['required', 'string', 'max:255'],
            'career_aspiration' => ['nullable', 'string', 'max:255'],
            'parental_occupation' => ['nullable', 'string', 'max:255'],
        ]);

        $student->update([
            'register_institute_id' => $request->register_institute_id,
            'name' => $request->name,
            'email' => $request->email,
            'age' => $request->age,
            'class' => $request->class,
            'school' => $request->school,
            'location' => $request->location,
            'subjects_stream' => $request->subjects_stream,
            'career_aspiration' => $request->career_aspiration,
            'parental_occupation' => $request->parental_occupation,
        ]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = User::findOrFail($id);

        $student->delete();

        return redirect()->back()->with('success', 'Student deleted successfully!');
    }
}
