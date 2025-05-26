<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\CareerPath;
use App\Models\Domain;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    public function index($id = null)
    {
        $user = Auth::user();

        // Ensure user is a student
        if (!$user || !$user->rolls || $user->rolls->slug !== 'student') {
            abort(403, 'Only students can access this page.');
        }

        if ($user->is_submitted) {
            return redirect()->route('assessment.result')->with('error', 'You have already submitted the assessment.');
        }

        $domains = Domain::orderBy('id')->get();
        // If no specific domain is passed, use the first one
        $domain = $id
            ? Domain::with(['sections.questions.options'])->findOrFail($id)
            : Domain::with(['sections.questions.options'])->orderBy('id')->first();

        $isLastDomain = $domain && $domains->last()->id === $domain->id;

        // Get the sections from the selected domain only
        $sections = $domain->sections ?? [];

        return view('student.assessment.index', compact('sections', 'domain', 'isLastDomain'));
    }

    public function store(Request $request)
    {
        $studentId = Auth::user()->id;
        $domainId = $request->domain_id;
        $responses = $request->responses;
        $sectionIds = $request->section_ids;

        foreach ($responses as $questionId => $value) {
            $question = Question::with(['domain', 'options'])->find($questionId);
            
            if (!$question) {
                continue;
            }

            // Handle MCA scoring
            if ($question->domain->scoring_type === 'mcq') {
                $selectedOption = QuestionOption::find($value);
                if ($selectedOption) {
                    $value = $selectedOption->is_correct ? 1 : 0;
                }
            } else if ($question->is_reverse) {
                // Reverse the value if it's within 1-5 for non-MCA questions
                if (in_array($value, [1, 2, 3, 4, 5])) {
                    $value = 6 - $value;
                }
            }

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

    public function result()
    {
        $user = Auth::user();

        // If already submitted, just show the result
        if ($user->is_submitted) {
            return $this->renderResult($user->id);
        }

        // Mark user as submitted
        User::where('id', $user->id)->update(['is_submitted' => true]);

        return $this->renderResult($user->id);
    }

    private function renderResult($userId)
    {
        $careerpaths = CareerPath::with('section')->get()->groupBy('section_id');

        $responses = DB::table('assessments')
            ->join('sections', 'assessments.section_id', '=', 'sections.id')
            ->join('domains', 'sections.domain_id', '=', 'domains.id')
            ->select(
                'assessments.section_id',
                'sections.name as section_name',
                'sections.description as section_description',
                'sections.keytraits as section_keytraits',
                'sections.enjoys as section_enjoys',
                'sections.idealenvironments as section_idealenvironments',
                'sections.domain_id',
                'domains.name as domain_name',
                'domains.description as domain_description',
                DB::raw('SUM(response_value) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->where('assessments.student_id', $userId)
            ->groupBy('assessments.section_id', 'sections.name', 'section_description', 'section_keytraits', 'section_enjoys', 'section_idealenvironments', 'sections.domain_id', 'domains.name', 'domains.description')
            ->get();

        $flatResults = [];

        foreach ($responses as $response) {
            $flatResults[] = [
                'domain_name' => $response->domain_name,
                'domain_description' => $response->domain_description,
                'domain_id' => $response->domain_id,
                'section_id' => $response->section_id,
                'section_name' => $response->section_name,
                'section_description' => $response->section_description,
                'section_keytraits' => $response->section_keytraits,
                'section_enjoys' => $response->section_enjoys,
                'section_idealenvironments' => $response->section_idealenvironments,
                'average' => round($response->total / $response->count, 2),
            ];
        }

        $grouped = collect($flatResults)->groupBy('domain_name');

        $groupedResults = $grouped->map(function ($sections) {
            $sorted = $sections->sortByDesc('average')->values();

            foreach ($sorted as $index => $section) {
                $label = $index === 0 ? 'Dominant Trait' : 'Supportive Trait';
                $section['average_value'] = $section['average']; // keep original number for chart
                $section['label'] = $label;
                $sorted[$index] = $section;
            }

            return $sorted->take(3); // Only take top 3 if needed
        });

        return view('student.assessment.result', compact('careerpaths'), [
            'groupedResults' => $groupedResults->toArray()
        ]);
    }
}
