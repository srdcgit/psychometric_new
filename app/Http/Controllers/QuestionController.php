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
    public function index(Request $request)
    {
        $query = Question::with(['domain', 'section', 'options'])
            ->when($request->filled('domain'), function ($q) use ($request) {
                return $q->where('domain_id', $request->domain);
            })
            ->when($request->filled('section'), function ($q) use ($request) {
                return $q->where('section_id', $request->section);
            })
            ->when($request->filled('type'), function ($q) use ($request) {
                return $q->whereHas('domain', function($query) use ($request) {
                    $query->where('scoring_type', $request->type);
                });
            })
            ->when($request->filled('date_from'), function ($q) use ($request) {
                return $q->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($q) use ($request) {
                return $q->whereDate('created_at', '<=', $request->date_to);
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $searchTerm = $request->search;
                return $q->where(function($query) use ($searchTerm) {
                    $query->where('question', 'like', '%' . $searchTerm . '%')
                          ->orWhereHas('domain', function($q) use ($searchTerm) {
                              $q->where('name', 'like', '%' . $searchTerm . '%');
                          })
                          ->orWhereHas('section', function($q) use ($searchTerm) {
                              $q->where('name', 'like', '%' . $searchTerm . '%');
                          });
                });
            })
            ->latest();

        $perPage = $request->input('per_page', 10);
        $questions = $query->paginate($perPage);

        if ($request->ajax()) {
            return view('admin.question.partials.questions-table', compact('questions'))->render();
        }

        $domains = Domain::all();
        $sections = collect(); // Empty collection by default
        
        // If domain is selected, get its sections
        if ($request->filled('domain')) {
            $sections = Section::where('domain_id', $request->domain)->get();
        }

        return view('admin.question.index', compact('questions', 'domains', 'sections'));
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
        $sections = Section::where('domain_id', $id)->get(['id', 'name']);
        return response()->json($sections);
    }

    /**
     * Handle bulk actions on questions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'questions' => 'required|array',
            'questions.*' => 'exists:questions,id'
        ]);

        try {
            DB::beginTransaction();

            $questions = Question::whereIn('id', $request->questions);
            $questions->delete();
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Questions deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
