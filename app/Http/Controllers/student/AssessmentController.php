<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Section;

class AssessmentController extends Controller
{
    public function index($id = null)
    {
        $user = Auth::user();

        // Ensure user is a student
        if (!$user || !$user->rolls || $user->rolls->slug !== 'student') {
            abort(403, 'Only students can access this page.');
        }

        // If no specific domain is passed, use the first one
        $domain = $id
            ? Domain::with(['sections.questions'])->findOrFail($id)
            : Domain::with(['sections.questions'])->orderBy('id')->first();

        // Get the sections from the selected domain only
        $sections = $domain->sections;

        return view('student.assessment.index', compact('sections', 'domain'));
    }


    public function store(Request $request)
    {
        $studentId = Auth::user()->id; // Or use auth()->id()
        $domainId = $request->domain_id;
        $responses = $request->responses;
        $sectionIds = $request->section_ids;

        foreach ($responses as $questionId => $value) {
            Assessment::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'question_id' => $questionId,
                ],
                [
                    'domain_id' => $domainId,
                    'section_id' => $sectionIds[$questionId] ?? null,
                    'response_value' => $value,
                ]
            );
        }

        // Determine next domain
        $nextDomain = Domain::where('id', '>', $domainId)->orderBy('id')->first();

        return response()->json([
            'message' => 'Saved',
            'next_domain_url' => $nextDomain
                ? route('assessment.domain.view', $nextDomain->id)
                : null
        ]);
    }


    public function submit(Request $request)
    {
        $responses = $request->input('responses');

        foreach ($responses as $questionId => $answer) {
            // Save to DB, e.g., AssessmentAnswer::create([...])
        }

        return redirect()->route('assessment.index')->with('success', 'Assessment submitted successfully!');
    }

    public function partialSave(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'responses' => 'required|array',
        ]);

        $studentId = Auth::user()->id; // or hardcoded if not using auth

        foreach ($request->responses as $questionId => $value) {
            StudentAnswer::updateOrCreate(
                ['student_id' => $studentId, 'question_id' => $questionId],
                ['value' => $value]
            );
        }

        return response()->json(['success' => true]);
    }
}
