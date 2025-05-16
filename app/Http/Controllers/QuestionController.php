<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Question;
use App\Models\Roll;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $user = Auth::user();

        // Check if user has the 'admin' role
        $adminRole = Roll::where('slug', 'admin')->first();

        // Fetch questions uploaded by the current admin user
        $questions = Question::where('uploaded_by', $user->id)->with('section')->get();

        return view('admin.question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $domains = Domain::all();
        $sections = Section::all();

        return view('admin.question.create', compact('sections', 'domains'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'domain_id' => 'required|exists:domains,id',
            'section_id' => 'required|exists:sections,id',
            'question' => 'required|string|max:1000',
        ]);

        Question::create([
            'domain_id' => $request->domain_id,
            'section_id' => $request->section_id,
            'question' => $request->question,
            'uploaded_by' => Auth::user()->id,
        ]);

        return redirect()->route('question.index')->with('success', 'Question added successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getSections($id)
    {
        $sections = Section::where('domain_id', $id)->pluck('name', 'id');
        return response()->json($sections);
    }
}
