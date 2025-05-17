<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Domain;
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
            ? Domain::with(['sections.questions'])->findOrFail($id)
            : Domain::with(['sections.questions'])->orderBy('id')->first();

        $isLastDomain = $domain && $domains->last()->id === $domain->id;

        // Get the sections from the selected domain only
        $sections = $domain->sections ?? [];

        return view('student.assessment.index', compact('sections', 'domain', 'isLastDomain'));
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



    // public function result()
    // {
    //     $userId = Auth::id();

    //     $responses = DB::table('assessments')
    //         ->join('sections', 'assessments.section_id', '=', 'sections.id')
    //         ->join('domains', 'sections.domain_id', '=', 'domains.id')
    //         ->select(
    //             'assessments.section_id',
    //             'sections.name as section_name',
    //             'sections.domain_id',
    //             'domains.name as domain_name',
    //             DB::raw('SUM(response_value) as total'),
    //             DB::raw('COUNT(*) as count')
    //         )
    //         ->where('assessments.student_id', $userId)
    //         ->groupBy('assessments.section_id', 'sections.name', 'sections.domain_id', 'domains.name')
    //         ->get();

    //     // Step 1: Prepare flat results with averages
    //     $flatResults = [];

    //     foreach ($responses as $response) {
    //         $flatResults[] = [
    //             'domain_name' => $response->domain_name,
    //             'domain_id' => $response->domain_id,
    //             'section_name' => $response->section_name,
    //             'average' => round($response->total / $response->count, 2),
    //         ];
    //     }

    //     // Step 2: Group by domain_name
    //     $grouped = collect($flatResults)->groupBy('domain_name');

    //     // Step 3: Take top 3 sections per domain
    //     $groupedResults = $grouped->map(function ($sections) {
    //         return $sections->sortByDesc('average')->take(3);
    //     });

    //     // return view('student.assessment.result', compact('groupedResults'));

    //     return view('student.assessment.result', [
    //         'groupedResults' => $groupedResults->map(fn($items) => $items->values())->toArray()
    //     ]);
    // }




    // testing code 
    public function result()
    {
        $user = Auth::user();

        // If already submitted, just show the result
        if ($user->is_submitted) {
            return $this->renderResult($user->id);
        }

        // ✅ Mark user as submitted
        $user->is_submitted = true;
        $user->save();

        return $this->renderResult($user->id);
    }

    private function renderResult($userId)
    {
        $responses = DB::table('assessments')
            ->join('sections', 'assessments.section_id', '=', 'sections.id')
            ->join('domains', 'sections.domain_id', '=', 'domains.id')
            ->select(
                'assessments.section_id',
                'sections.name as section_name',
                'sections.domain_id',
                'domains.name as domain_name',
                DB::raw('SUM(response_value) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->where('assessments.student_id', $userId)
            ->groupBy('assessments.section_id', 'sections.name', 'sections.domain_id', 'domains.name')
            ->get();

        $flatResults = [];

        foreach ($responses as $response) {
            $flatResults[] = [
                'domain_name' => $response->domain_name,
                'domain_id' => $response->domain_id,
                'section_name' => $response->section_name,
                'average' => round($response->total / $response->count, 2),
            ];
        }

        $grouped = collect($flatResults)->groupBy('domain_name');
        $groupedResults = $grouped->map(fn($sections) => $sections->sortByDesc('average')->take(3)->values());

        return view('student.assessment.result', [
            'groupedResults' => $groupedResults->toArray()
        ]);
    }
}
