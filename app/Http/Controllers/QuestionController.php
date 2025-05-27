<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Roll;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // $questions = Question::where('uploaded_by', $user->id)->with('section')->get();
        $questions = Question::where('uploaded_by', $user->id)->with('section')->paginate(10); // Adjust per-page as needed


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
        // Get the domain's scoring type
        $domain = Domain::findOrFail($request->domain_id);
        
        $validationRules = [
            'domain_id' => 'required|exists:domains,id',
            'section_id' => 'required|exists:sections,id',
            'question' => 'required|string|max:1000',
            'is_reverse' => 'required|boolean',
        ];

        // Add options validation only for MCQ type domains
        if ($domain->scoring_type === 'mcq') {
            $validationRules['options'] = 'required|array';
            $validationRules['options.*'] = 'required|string';
            $validationRules['correct_option'] = 'required|numeric';
        }

        $validatedData = $request->validate($validationRules);

        DB::beginTransaction();
        try {
            // Create the question
            $question = Question::create([
                'domain_id' => $validatedData['domain_id'],
                'section_id' => $validatedData['section_id'],
                'question' => $validatedData['question'],
                'uploaded_by' => Auth::user()->id,
                'is_reverse' => $validatedData['is_reverse']
            ]);

            // If this is an MCA question and options are provided, store them
            if ($domain->scoring_type === 'mcq' && isset($validatedData['options'])) {
                foreach ($validatedData['options'] as $index => $optionText) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $optionText,
                        'is_correct' => $index == $validatedData['correct_option']
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('question.index')->with('success', 'Question added successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to create question. ' . $e->getMessage());
        }
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
        $question = Question::with('options')->findOrFail($id);
        $domains = Domain::all();
        $sections = Section::where('domain_id', $question->domain_id)->get();

        return view('admin.question.edit', compact('question', 'domains', 'sections'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Get the domain's scoring type
        $domain = Domain::findOrFail($request->domain_id);
        
        $validationRules = [
            'domain_id' => 'required|exists:domains,id',
            'section_id' => 'required|exists:sections,id',
            'question' => 'required|string|max:1000',
            'is_reverse' => 'required|boolean',
        ];

        // Add options validation only for MCQ type domains
        if ($domain->scoring_type === 'mcq') {
            $validationRules['options'] = 'required|array';
            $validationRules['options.*'] = 'required|string';
            $validationRules['correct_option'] = 'required|numeric';
        }

        $validatedData = $request->validate($validationRules);

        DB::beginTransaction();
        try {
            $question = Question::findOrFail($id);
            
            // Update question
            $question->update([
                'domain_id' => $validatedData['domain_id'],
                'section_id' => $validatedData['section_id'],
                'question' => $validatedData['question'],
                'is_reverse' => $validatedData['is_reverse']
            ]);

            // If this is an MCA question and options are provided, update them
            if ($domain->scoring_type === 'mcq') {
                // Delete existing options
                $question->options()->delete();
                
                // Create new options
                foreach ($validatedData['options'] as $index => $optionText) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $optionText,
                        'is_correct' => $index == $validatedData['correct_option']
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('question.index')->with('success', 'Question updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to update question. ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('question.index')->with('success', 'Question deleted successfully.');
    }


    public function getSections($id)
    {
        $sections = Section::where('domain_id', $id)->pluck('name', 'id');
        return response()->json($sections);
    }
}
