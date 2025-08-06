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
        $isFirstDomain = $domain && $domains->first()->id === $domain->id;

        // Get previous domain for back button
        $previousDomain = null;
        if ($domain) {
            $previousDomain = Domain::where('id', '<', $domain->id)->orderBy('id', 'desc')->first();
        }

        // Get the sections from the selected domain only
        $sections = $domain->sections ?? [];

        // Fetch previously submitted answers for this domain
        $previousAnswers = [];
        if ($domain) {
            $assessments = Assessment::where('student_id', $user->id)
                ->where('domain_id', $domain->id)
                ->get();

            foreach ($assessments as $assessment) {
                if ($assessment->question->domain->scoring_type === 'mcq') {
                    // For MCQ, store the selected option ID
                    $option = QuestionOption::where('question_id', $assessment->question_id)
                        ->where(function($query) use ($assessment) {
                            $query->where('is_correct', $assessment->response_value == 1);
                        })
                        ->first();
                    if ($option) {
                        $previousAnswers[$assessment->question_id] = $option->id;
                    }
                } else {
                    // For Likert scales, handle reverse scoring
                    $value = $assessment->response_value;
                    if ($assessment->question->is_reverse) {
                        $value = 6 - $value;
                    }
                    $previousAnswers[$assessment->question_id] = $value;
                }
            }
        }

        return view('student.assessment.index', compact('sections', 'domain', 'isLastDomain', 'isFirstDomain', 'previousDomain', 'previousAnswers'));
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

        // Store form data in session
        $request->flash();

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
        $careerpaths = CareerPath::with(['section', 'careers'])->get()->groupBy('section_id');

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
                'low' => optional(\App\Models\Section::find($response->section_id))->low,
                'mid' => optional(\App\Models\Section::find($response->section_id))->mid,
                'high' => optional(\App\Models\Section::find($response->section_id))->high,
                'average' => round($response->total / $response->count, 2),
            ];
        }

        $grouped = collect($flatResults)->groupBy('domain_name');

        $groupedResults = $grouped->map(function ($sections, $domainName) {
            $sorted = $sections->sortByDesc('average')->values();

            // For OCEAN domain, assign High/Mid/Low labels based on score ranges
            if ($domainName === 'OCEAN') {
                foreach ($sorted as $index => $section) {
                    $average = $section['average'];
                    
                    // Assign label based on score ranges
                    if ($average >= 1 && $average <= 2) {
                        $label = 'Low';
                        $relevantDescription = $section['low'];
                    } elseif ($average >= 2.1 && $average <= 3.9) {
                        $label = 'Mid';
                        $relevantDescription = $section['mid'];
                    } elseif ($average >= 4 && $average <= 5) {
                        $label = 'High';
                        $relevantDescription = $section['high'];
                    } else {
                        // Fallback for scores outside expected ranges
                        $label = 'Mid';
                        $relevantDescription = $section['mid'];
                    }
                    
                    $section['average_value'] = $average;
                    $section['label'] = $label;
                    $section['relevant_description'] = $relevantDescription;
                    $sorted[$index] = $section;
                }
                
                // Return all sections for OCEAN domain (no limit)
                return $sorted;
            } 
            // For Work Values, keep existing ranking-based logic
            elseif ($domainName === 'Work Values' && $sorted->count() >= 1) {
                $labels = ['High', 'Mid', 'Low'];
                $count = $sorted->count();
                for ($i = 0; $i < $count; $i++) {
                    // Assign label based on position: 0=High, 1=Mid, 2=Low (if only 2, 0=High, 1=Low)
                    $label = $labels[$i] ?? 'Low';
                    if ($count == 2) {
                        $label = $i == 0 ? 'High' : 'Low';
                    }
                    $section = $sorted[$i];
                    $section['average_value'] = $section['average'];
                    $section['label'] = $label;
                    $sorted[$i] = $section;
                }
                
                // Store all sections (including Low) for chart display
                $allSectionsForChart = $sorted;
                
                // Filter out sections with label 'Low' for card display
                $filteredForCards = $sorted->filter(function($section) {
                    return $section['label'] !== 'Low';
                })->values();
                
                // Return filtered sections for cards, but include all sections for chart
                return [
                    'cards' => $filteredForCards,
                    'chart' => $allSectionsForChart
                ];
            } else {
                foreach ($sorted as $index => $section) {
                    // For VARK domain, use Primary/Secondary labels, for others use Dominant/Supportive
                    if ($domainName === 'VARK') {
                        $label = $index === 0 ? 'Primary' : 'Secondary';
                    } else {
                        $label = $index === 0 ? 'Dominant Trait' : 'Supportive Trait';
                    }
                    $section['average_value'] = $section['average'];
                    $section['label'] = $label;
                    $sorted[$index] = $section;
                }
            }

            // For non-OCEAN domains, keep the top 3 limit
            return $domainName === 'OCEAN' ? $sorted : $sorted->take(3);
        });

        return view('student.assessment.result', compact('careerpaths'), [
            'groupedResults' => $groupedResults->toArray()
        ]);
    }
}
