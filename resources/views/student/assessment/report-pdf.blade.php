<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assessment Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
        }

        h1 {
            color: #4338ca;
            font-size: 22px;
            margin-bottom: 10px;
        }

        h2 {
            color: #111827;
            font-size: 18px;
            margin: 16px 0 8px;
        }

        h3 {
            font-size: 14px;
            margin: 8px 0 4px;
        }

        .section {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 8px;
        }

        .meta {
            font-size: 12px;
            color: #374151;
        }

        .row {
            display: flex;
            gap: 10px;
        }

        .col {
            flex: 1;
        }

        .badge {
            background: #dbeafe;
            color: #1e40af;
            border-radius: 4px;
            padding: 2px 6px;
            font-size: 11px;
            display: inline-block;
            margin: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #e5e7eb;
            padding: 6px;
            font-size: 12px;
        }

        /* Static bar chart styles for PDF */
        .barRow {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 6px 0;
        }

        .barLabel {
            width: 35%;
            font-size: 12px;
            color: #374151;
        }

        .barTrack {
            flex: 1;
            height: 10px;
            background: #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }

        .barFill {
            height: 100%;
            background: #6366f1;
        }
    </style>
    @php use Illuminate\Support\Str; @endphp
    @php $student = $student ?? auth()->user(); @endphp
</head>

<body>
    <h1>Comprehensive Psychometric Assessment Report</h1>
    <div>
        <h2>Student Information</h2>
        <div>
            <div class="meta">
                <p class="meta">Name: {{ $student->name }}</p>
                <p class="meta">Class: {{ $student->class }} ({{ $student->subjects_stream }})
                </p>
                <p class="meta">Date: {{ date('d M Y') }}</p>
                <p class="meta">Conducted by: Career Guidance & Psychological Assessment Cell,
                    Career Map</p>
            </div>
        </div>
    </div>

    <div>
        <div>
            <h4>Comprehensive Career Guidance and Personality
                Assessment</h4>
            <p class="meta">An Integrated Report Based on Multiple Psychometric Tools:</p>
            <div class="meta">
                <style>
                    ol,
                    ul,
                    menu {
                        list-style: disc !important;
                        margin: 0 !important;
                        padding: 0 !important;
                    }
                </style>
                <ul class="meta">
                    <li>Holland Code (RIASEC)</li>
                    <li>NEO FFI (Big Five Personality)</li>
                    <li>VARK Learning Style</li>
                    <li>Work Values Inventory</li>
                    <li>Goal Orientation (Short-Term vs Long-Term)</li>
                    <li>Aptitude Profile</li>
                </ul>
            </div>

            <div class="meta">
                <h2>Introduction</h2>
                <p>This report is a comprehensive analysis of {{ $student->name }}'s personality traits, career
                    interests, learning preferences, work values, future orientation, and cognitive aptitude. The aim is
                    to provide holistic guidance to support academic planning, skill development, and long-term career
                    alignment.</p>
            </div>

            <div class="meta">
                <h2>Overview of Tools</h2>
                <ul class="meta">
                    <li><strong>Holland Code (RIASEC): </strong>Explores personality-job match across six vocational
                        types.</li>
                    <li><strong>NEO FFI: </strong>Assesses Big Five personality dimensions.</li>
                    <li><strong>VARK: </strong>Identifies preferred learning style.</li>
                    <li><strong>Work Values Inventory: </strong>Measures motivational drivers in professional settings.
                    </li>
                    <li><strong>Goal Orientation: </strong>Evaluates temporal preference (long vs short-term goals).
                    </li>
                    <li><strong>Aptitude Profile: </strong>Analyzes reasoning and cognitive abilities.</li>
                </ul>
            </div>

        </div>


    </div>

    @foreach ($groupedResults as $domainName => $sections)
        @php $slug = Str::slug($domainName); @endphp
        <h2>{{ $domainName }}</h2>

        <div>
            @if (isset($sections['description']) && $sections['description'])
                <div class="meta">
                    <div class="meta">
                        <div class="meta">
                            <p class="meta">
                                <strong>Description:</strong> {!! $sections['description'] !!}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @foreach ($sections['cards'] ?? [] as $section)
            <div class="section">
                <h3>{{ $section['section_name'] }} @if (isset($section['label']))
                        - {{ $section['label'] }}
                    @endif
                </h3>
                <div class="meta">{{ $domainName === 'APTITUDE' ? 'Total Score:' : 'Average Score:' }}
                    {{ $section['average'] }}</div>
                <div class="meta">{!! strip_tags($section['section_description']) !!}</div>
                @if ($domainName === 'OCEAN')
                    <div class="meta"><strong>{{ $section['label'] }}:</strong>
                        {{ $section['relevant_description'] }}</div>
                @elseif ($domainName === 'WORK VALUES')
                    @if ($section['label'] === 'Low')
                        <div class="meta"><strong>Low:</strong> {{ $section['low'] }}</div>
                    @elseif ($section['label'] === 'Mid')
                        <div class="meta"><strong>Mid:</strong> {{ $section['mid'] }}</div>
                    @elseif ($section['label'] === 'High')
                        <div class="meta"><strong>High:</strong> {{ $section['high'] }}</div>
                    @endif
                @else
                    <div class="meta"><strong>Key Traits:</strong> {{ $section['section_keytraits'] }}</div>
                    <div class="meta"><strong>Enjoys:</strong> {{ $section['section_enjoys'] }}</div>
                    <div class="meta"><strong>Ideal Environments:</strong>
                        {{ $section['section_idealenvironments'] }}</div>
                @endif
            </div>
        @endforeach

        @if (!empty($sections['cards']) && $domainName !== 'GOAL ORIENTATION')
            @php
                $careerPathSections = $sections['cards'];
            @endphp
            <h3>Suggested Career Paths</h3>
            <table>
                <tbody>
                    @foreach ($careerPathSections as $sec)
                        @php
                            $sectionId = $sec['section_id'] ?? null;
                            $paths = ($careerpaths[$sectionId] ?? collect())
                                ->filter(function ($p) {
                                    return $p->sections && $p->sections->count() === 1;
                                })
                                ->values();
                            $combinedCareers = collect();
                            foreach ($paths as $p) {
                                // Ensure career categories are loaded before merging
                                $careersWithCategories = $p->careers->load('careerCategory');
                                $combinedCareers = $combinedCareers->merge($careersWithCategories);
                            }
                            $combinedCareers = $combinedCareers->unique('id')->values();
                        @endphp
                        @if ($paths->isNotEmpty())
                            <tr>
                                <td style="width: 30%">{{ $sec['section_name'] }}</td>
                                <td>
                                    @if ($combinedCareers->count() > 0)
                                        @foreach ($combinedCareers as $career)
                                            <span class="badge">
                                                {!! $career->name !!}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="meta">No careers assigned</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- Static bar chart (PDF-friendly, mirrors Result page data) --}}
        @if (!empty($sections['chart']))
            <h3>Visual Representation of your Score</h3>
            <div>
                @foreach ($sections['chart'] as $sec)
                    @php
                        $value = (float) ($sec['average_value'] ?? 0);
                        $clamped = max(0, min(10, $value));
                        $percent = $clamped * 10; // 0-100
                    @endphp
                    <div class="barRow">
                        <div class="barLabel">{{ $sec['section_name'] }} ({{ $value }})</div>
                        <div class="barTrack">
                            <div class="barFill" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach

    <br><br>





    <div class="meta">
        <h2>Integrated Analysis</h2>
        <p>{{ $student->name }} demonstrates high emotional stability, creativity, conscientiousness, and social
            engagement. His preference for autonomy and long-term orientation aligns well with careers requiring deep
            engagement and self-direction.</p>
    </div>

    @php
        $allCategoryCountsBySection = [];
        foreach ($groupedResults as $domainName => $sections) {
            $careerPathSections = $sections['cards'] ?? [];
            foreach ($careerPathSections as $sec) {
                $sectionId = $sec['section_id'] ?? null;
                $paths = ($careerpaths[$sectionId] ?? collect())
                    ->filter(function ($p) {
                        return $p->sections && $p->sections->count() === 1;
                    })
                    ->values();

                if ($paths->isEmpty()) {
                    continue;
                }

                $combinedCareers = collect();
                foreach ($paths as $p) {
                    $combinedCareers = $combinedCareers->merge($p->careers->load('careerCategory'));
                }
                $combinedCareers = $combinedCareers->unique('id')->values();

                $counts = $combinedCareers
                    ->map(function ($career) {
                        return optional($career->careerCategory)->name;
                    })
                    ->filter()
                    ->countBy()
                    // ->filter(function ($count) {
                    //     return $count > 1;
                    // })
                    ->sortDesc();

                if ($counts->isNotEmpty()) {
                    $allCategoryCountsBySection[] = [
                        'domain' => $domainName,
                        'section' => $sec['section_name'],
                        'counts' => $counts,
                    ];
                }
            }
        }
    @endphp

   

    <div class="meta">
        <h2>Career Clusters with Total Weightage</h2>
        @php
            // Group previously computed counts by domain
            $repeatedByDomain = collect($allCategoryCountsBySection ?? [])->groupBy('domain');

            // Compute overall weighted totals per career cluster across all domains
            $overallCategoryWeightages = [];
            foreach ($groupedResults as $domainName => $sections) {
                $weight = (float) ($sections['domain_weightage'] ?? 0);
                if ($weight === 0) { continue; }

                $entries = $repeatedByDomain->get($domainName, collect());
                foreach ($entries as $e) {
                    $counts = $e['counts'];
                    $arr = (is_object($counts) && method_exists($counts, 'all')) ? $counts->all() : (array) $counts;
                    foreach ($arr as $cat => $cnt) {
                        if (!isset($overallCategoryWeightages[$cat])) { $overallCategoryWeightages[$cat] = 0; }
                        $overallCategoryWeightages[$cat] += ((int) $cnt) * $weight;
                    }
                }
            }

            arsort($overallCategoryWeightages);
        @endphp

        @if (!empty($overallCategoryWeightages))
            <table>
                <thead>
                    <tr>
                        <th>Career Cluster</th>
                        <th style="text-align: right;">Total Weightage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($overallCategoryWeightages as $catName => $totalWeighted)
                        <tr>
                            <td><strong>{!! $catName !!}</strong></td>
                            <td style="text-align: right;">{{ rtrim(rtrim(number_format($totalWeighted, 2, '.', ''), '0'), '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="meta">No career clusters to display.</div>
        @endif
    </div>

    <div class="meta" style="margin-top: 10px;">
        <h2>Customized Career Recommendation</h2>
        @php
            $categoryDetails = \App\Models\CareerCategory::whereIn('name', array_keys($overallCategoryWeightages ?? []))
                ->get()
                ->keyBy('name');
        @endphp
        @foreach (($overallCategoryWeightages ?? []) as $catName => $totalWeighted)
            @php
                $roles = optional($categoryDetails->get($catName))->example_roles;
                $hook = optional($categoryDetails->get($catName))->hook;
                $what_is_it = optional($categoryDetails->get($catName))->what_is_it;
                $subjects = optional($categoryDetails->get($catName))->subjects;
                $core_apptitudes_to_highlight = optional($categoryDetails->get($catName))->core_apptitudes_to_highlight;
                $value_and_personality_edge = optional($categoryDetails->get($catName))->value_and_personality_edge;
                $why_it_could_fit_you = optional($categoryDetails->get($catName))->why_it_could_fit_you;
                $early_actions = optional($categoryDetails->get($catName))->early_actions;
                $india_study_pathways = optional($categoryDetails->get($catName))->india_study_pathways;
                $future_trends = optional($categoryDetails->get($catName))->future_trends;
            @endphp
            <div class="section" style="margin-bottom: 10px;">
                <div class="row" style="justify-content: space-between; align-items: center;">
                    <div class="col" style="flex: none;">
                        <h3 style="margin:0; font-size: 14px;">{!! $catName !!}@if(!empty($hook)) - {!! $hook !!}@endif</h3>
                    </div>
                   
                </div>

                <div class="meta" style="margin-top: 6px;">
                    @if(!empty($what_is_it))
                        <div style="margin-bottom:6px;">{!! $what_is_it !!}</div>
                    @endif

                    @if(!empty($roles))
                        <div style="margin-bottom:6px;"><strong>Example Roles</strong> - <span>{!! $roles !!}</span></div>
                    @endif

                    @if(!empty($subjects))
                        <div style="margin-bottom:6px;"><strong>Subjects</strong> - <span>{!! $subjects !!}</span></div>
                    @endif

                    @if(!empty($core_apptitudes_to_highlight))
                        <div style="margin-bottom:6px;"><strong>Core aptitudes to highlight</strong> - <span>{!! $core_apptitudes_to_highlight !!}</span></div>
                    @endif

                    @if(!empty($value_and_personality_edge))
                        <div style="margin-bottom:6px;"><strong>Value and personality edge</strong> - <span>{!! $value_and_personality_edge !!}</span></div>
                    @endif

                    @if(!empty($why_it_could_fit_you))
                        <div style="margin-bottom:6px;"><strong>Why it could fit you</strong> - <span>{!! $why_it_could_fit_you !!}</span></div>
                    @endif

                    @if(!empty($early_actions))
                        <div style="margin-bottom:6px;"><strong>Early actions</strong> - <span>{!! $early_actions !!}</span></div>
                    @endif

                    @if(!empty($india_study_pathways))
                        <div style="margin-bottom:6px;"><strong>India study pathways</strong> - <span>{!! $india_study_pathways !!}</span></div>
                    @endif

                    @if(!empty($future_trends))
                        <div style="margin-bottom:6px;"><strong>Future trends</strong> - <span>{!! $future_trends !!}</span></div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="meta">
        <h2>Counselor's Remarks</h2>
        <p>{{ $student->name }} exhibits a balanced and mature personality marked by self-awareness
            and goal clarity. With his cognitive strengths and humanistic values, he can lead in fields that demand
            both intellect and empathy. Encouraging exploratory learning and mentorship will enrich his trajectory.
        </p>
    </div>

    <div class="meta">
        <p>Signature</p>
        <p>XYZ</p>
        <p>Career Counsellor</p>
    </div>


</body>

</html>
