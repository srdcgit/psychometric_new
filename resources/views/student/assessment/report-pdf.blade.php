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
                                                @if ($career->careerCategory)
                                                    <small style="display: block; font-size: 0.8em; color: #666;">
                                                        {!! $career->careerCategory->name !!}
                                                    </small>
                                                @endif
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

    @if (!empty($allCategoryCountsBySection))
        <div style="margin-top: 8px;">
            <h2>All Career Clusters</h2>
            @foreach ($allCategoryCountsBySection as $entry)
                <div class="meta"><strong>{!! $entry['domain'] !!} — {!! $entry['section'] !!}:</strong>
                    @foreach ($entry['counts'] as $catName => $count)
                        <span class="badge">{!! $catName !!} ({{ $count }})</span>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif

    @if (!empty($groupedResults))
        @php
            $repeatedTotalsByDomain = collect($allCategoryCountsBySection ?? [])
                ->groupBy('domain')
                ->map(function ($entries) {
                    $sum = 0;
                    foreach ($entries as $e) {
                        $counts = $e['counts'];
                        $sum +=
                            is_object($counts) && method_exists($counts, 'values')
                                ? array_sum($counts->values()->all())
                                : array_sum((array) $counts);
                    }
                    return $sum;
                });

            $domainRepeatedRows = [];
            foreach ($groupedResults as $domainName => $sections) {
                $weight = (float) ($sections['domain_weightage'] ?? 0);
                $repeated = (int) ($repeatedTotalsByDomain[$domainName] ?? 0);
                $domainRepeatedRows[] = [
                    'domain' => $domainName,
                    'repeated_total' => $repeated,
                    'weight' => $weight,
                    'weighted' => $repeated * $weight,
                ];
            }
        @endphp
        @php
            $repeatedByDomain = collect($allCategoryCountsBySection ?? [])->groupBy('domain');
        @endphp
        <div class="meta">
            <h2>Calculation part</h2>
            <h3>All Career Clusters (by domain)</h3>
            @foreach ($groupedResults as $domainName => $sections)
                @php
                    $weight = (float) ($sections['domain_weightage'] ?? 0);
                    $entries = $repeatedByDomain->get($domainName, collect());
                    // Aggregate counts per category across all sections for this domain
                    $perCategoryTotals = [];
                    foreach ($entries as $e) {
                        $counts = $e['counts'];
                        $arr = is_object($counts) && method_exists($counts, 'all') ? $counts->all() : (array) $counts;
                        foreach ($arr as $cat => $cnt) {
                            if (!isset($perCategoryTotals[$cat])) {
                                $perCategoryTotals[$cat] = 0;
                            }
                            $perCategoryTotals[$cat] += (int) $cnt;
                        }
                    }
                    // Compute weighted scores per category and sort desc
                    $ranked = collect($perCategoryTotals)
                        ->map(function ($cnt, $cat) use ($weight) {
                            return ['category' => $cat, 'count' => (int) $cnt, 'weighted' => (float) $cnt * $weight];
                        })
                        ->sortByDesc('weighted')
                        ->values();
                @endphp
                <div style="margin: 8px 0;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <h3 style="margin:0;">{{ $domainName }}</h3>
                        <div class="meta">
                            <span style="margin-right: 8px;"><strong>Weightage:</strong>
                                {{ rtrim(rtrim(number_format($weight, 2, '.', ''), '0'), '.') }}</span>
                        </div>
                    </div>
                    @if ($ranked->count() > 0)
                        <ol class="meta" style="margin-left: 18px;">
                            @foreach ($ranked as $index => $row)
                                <li>
                                    <strong>{!! $row['category'] !!}</strong>
                                    <span>— total {{ $row['count'] }}, weighted
                                        {{ rtrim(rtrim(number_format($row['weighted'], 2, '.', ''), '0'), '.') }}</span>
                                    @if ($index === 0)
                                        <span class="badge">Top scorer</span>
                                    @elseif($index === 1)
                                        <span class="badge">Second</span>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                        {{-- <div class="meta" style="margin-top:4px;">
                        <strong>Per-section breakdown:</strong>
                        @foreach ($entries as $entry)
                            <div class="meta"><strong>{!! $entry['section'] !!}:</strong>
                                @foreach ($entry['counts'] as $catName => $count)
                                    <span class="badge">{!! $catName !!} ({{ $count }})</span>
                                @endforeach
                            </div>
                        @endforeach
                    </div> --}}
                    @else
                        <div class="meta">No repeated categories found for this domain.</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

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
