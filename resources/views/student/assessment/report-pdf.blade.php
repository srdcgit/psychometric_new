<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assessment Report</title>
    <style>
        * {
            margin: 0;
            /* padding: 0; */
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
        }

        /* h1 {
            
            font-size: 22px;
            margin-bottom: 10px;
        } */

        h2 {
            color: #111827;
            font-size: 18px;
            margin: 16px 0 8px;
        }

        /* H2 Banner Design */
        .h2-banner {
            background: #0667d0;
            color: #ffffff;
            padding: 12px 16px;
            margin: 16px 0 8px 0;
            position: relative;
            overflow: hidden;
        }

        .h2-banner .h2-title {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
            position: relative;
            z-index: 2;
            color: #ffffff;
        }

        .h2-banner::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: #52a7d8;
            z-index: 1;
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

        /* latest pdf changes css codes  */
        .top-header {
            background: #0667d0;
            color: #ffffff;
        }

        .top-header-h1 {
            background: #0667d0;
            color: #ffffff;
        }

        .top-header .container {
            padding-top: 16px;
            padding-bottom: 16px;
            text-align: center;
        }

        .top-header-h1 .container-h1 {
            padding-top: 16px;
            padding-bottom: 16px;
            /* text-align: center; */
        }

        .top-header .title {
            font-size: 28px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .top-header .subtitle {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 4px;
            opacity: 0.95;
        }

        .top-header-h1 .title-h1 {
            font-size: 24px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            left: 10px;
            padding-left: 5px;
        }

        .top-header-h1 .subtitle-h1 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 4px;
            opacity: 0.95;
            left: 10px;
            padding-left: 5px;
        }

        .stripe {
            height: 16px;
            width: 100%;
        }

        .stripe-1 {
            background: #52a7d8;
        }

        .stripe-2 {
            background: #dbf6fb;
        }

        .hero {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: auto;
            margin: 0;
        }

        .hero img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: fill;
            display: block;
            z-index: 1;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            height: 100%;
            background: rgba(0, 0, 0, 0.63);
            z-index: 2;
        }

        .hero-text {
            position: absolute;
            top: 200px;
            /* push below header */
            left: 12px;
            color: #ffffff;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Repeating footer for every PDF page */
        @page {
            margin: 40px 32px 90px 32px;
            /* bottom margin leaves room for taller custom footer */
        }

        .pdf-footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            height: 72px;
            z-index: 1000;
        }

        /* Top twin stripes, like the sample */
        .pdf-footer .footer-top-stripe-1 {
            height: 4px;
            background: #1f5f9e;
            width: 100%;
        }

        .pdf-footer .footer-top-stripe-2 {
            height: 2px;
            background: #3b93c7;
            width: 100%;
        }

        /* Main footer body */
        .pdf-footer .footer-inner {
            background: #e7f3fb;
            height: 66px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 8px 16px;
        }

        .pdf-footer .footer-logo {
            position: absolute;
            left: 12px;
            height: 40px;
        }

        .pdf-footer .copyright {
            font-size: 10px;
            color: #374151;
            text-align: center;
            justify-content: center;
            align-content: center;
        }

        /* Ensure the first section renders as a standalone cover page */
        .cover-page {
            position: relative;
            height: 100vh;
            /* full page height */
            page-break-after: always;
        }

        /* Place the header over the full-page image */
        .cover-page .top-header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 4;
        }

        .body-space {
            padding: 10px;
        }

        .domain-section {
            min-height: calc(100vh - 100px);
            page-break-after: always;
            page-break-inside: avoid;
        }

        .careerpath-section {
            min-height: 60vh;
            page-break-before: always;
        }

        .careerpath-chart {
            min-height: 20vh;
            page-break-before: always;
            page-break-after: always;
        }

        ol,
        ul,
        menu {
            list-style: disc !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Add comfortable padding for the bullet list below the header */
        ul.meta {
            padding-left: 30px !important;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }

        p.meta {
            padding: 30px !important;
        }

        .careerdesc {
            padding: 30px !important;
        }

        .section-contaner {
            padding: 25px !important;
        }

        .career-table {
            padding: 25px !important;
        }

        .career-chart {
            padding: 25px !important;
        }

        image.meta {
            height: 100px !important;
            width: 250px !important;
        }
    </style>
    @php use Illuminate\Support\Str; @endphp
    @php $student = $student ?? auth()->user(); @endphp
</head>

<body>
    <div class="cover-page">
        <div class="top-header">
            <div class="container">
                <div class="title">Comprehensive Psychometric Assessment Report</div>
                <div class="subtitle">Student Assessment Report</div>
            </div>
            <div class="stripe stripe-1"></div>
            <div class="stripe stripe-2"></div>
        </div>
        <div class="hero">
            <img src="{{ asset('images/event1.png') }}" alt="banner">
            <div class="hero-overlay">
                <div class="hero-text">
                    <div>Unique ID: {{ $student->email }}</div>
                    <div>{{ $student->name }}</div>
                    <div>Class: {{ $student->class }}</div>
                    <div>Date: {{ date('d M Y') }}</div>
                    <div>Conducted by: Career Guidance & Psychological Assessment Cell,
                        Career Map</div>
                </div>
            </div>
        </div>
    </div>


    <div>
        <div>
            <div class="top-header-h1">
                <div class="container-h1">
                    <div class="title-h1">Comprehensive Career Guidance and Personality
                        Assessment</div>
                    <div class="subtitle-h1">An Integrated Report Based on Multiple Psychometric Tools:</div>
                </div>
                <div class="stripe stripe-1"></div>
                <div class="stripe stripe-2"></div>
            </div>

            <div>
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
                <div class="h2-banner">
                    <h2 class="h2-title">Introduction</h2>
                </div>
                <p class="meta">This report is a comprehensive analysis of {{ $student->name }}'s personality traits,
                    career
                    interests, learning preferences, work values, future orientation, and cognitive aptitude. The aim is
                    to provide holistic guidance to support academic planning, skill development, and long-term career
                    alignment.</p>
            </div>

            <div class="meta">
                <div class="h2-banner">
                    <h2 class="h2-title">Overview of Tools</h2>
                </div>
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

    {{-- Dmain section start here  --}}
    <div class="domain-section">
        @foreach ($groupedResults as $domainName => $sections)
            @php $slug = Str::slug($domainName);
                $domainDisplayName = $sections['cards'][0]['domain_display_name'] ?? $domainName;
            @endphp
            <div class="h2-banner">
                <h2 class="h2-title">{{ $domainDisplayName }}</h2>
            </div>

            <div class="meta">
                @if (isset($sections['description']) && $sections['description'])
                    <div class="careerdesc"><b>Description:</b> {!! $sections['description'] !!}</div>
                @endif
            </div>

            <div class="section-contaner">
                @foreach ($sections['cards'] ?? [] as $section)
                    <div class="section">
                        <img src="{{ asset($section['section_image']) }}" alt="{{ $section['section_name'] }} image"
                            class="meta">
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
            </div>


            <div class="careerpath-section">
                @if (!empty($sections['cards']) && $domainName !== 'GOAL ORIENTATION')
                    @php
                        $careerPathSections = $sections['cards'];
                    @endphp
                    <div class="h2-banner">
                        <h2 class="h2-title">Suggested Career Paths</h2>
                    </div>
                    <div class="career-table">
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
                                                    {{-- @foreach ($combinedCareers as $career)
                                                        <span class="badge">
                                                            {!! $career->name !!}
                                                        </span>
                                                    @endforeach --}}

                                                    {{-- now merge and show single career cluster  --}}
                                                    @php
                                                        $uniqueCategories = $combinedCareers
                                                            ->pluck('careerCategory.name') // extract category names
                                                            ->filter() // remove null values
                                                            ->unique() // keep only unique ones
                                                            ->values();
                                                    @endphp

                                                    @foreach ($uniqueCategories as $categoryName)
                                                       
                                                            {!! $categoryName !!}
                                                        
                                                    @endforeach
                                                    {{-- end merging  --}}

                                                @else
                                                    <span class="meta">No careers assigned</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>


            {{-- Static bar chart (PDF-friendly, mirrors Result page data) --}}
            <div class="careerpath-chart">
                @if (!empty($sections['chart']))
                    <div class="h2-banner">
                        <h2 class="h2-title">Visual Representation of your Score</h2>
                    </div>
                    <div class="career-chart">
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
            </div>

        @endforeach
    </div>


    <br><br>





    <div class="meta">
        <div class="h2-banner">
            <h2 class="h2-title">Integrated Analysis</h2>
        </div>
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
        <div class="h2-banner">
            <h2 class="h2-title">Career Clusters with Total Weightage</h2>
        </div>
        @php
            // Group previously computed counts by domain
            $repeatedByDomain = collect($allCategoryCountsBySection ?? [])->groupBy('domain');

            // Compute overall weighted totals per career cluster across all domains
            $overallCategoryWeightages = [];
            foreach ($groupedResults as $domainName => $sections) {
                $weight = (float) ($sections['domain_weightage'] ?? 0);
                if ($weight === 0) {
                    continue;
                }

                $entries = $repeatedByDomain->get($domainName, collect());
                foreach ($entries as $e) {
                    $counts = $e['counts'];
                    $arr = is_object($counts) && method_exists($counts, 'all') ? $counts->all() : (array) $counts;
                    foreach ($arr as $cat => $cnt) {
                        if (!isset($overallCategoryWeightages[$cat])) {
                            $overallCategoryWeightages[$cat] = 0;
                        }
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
                            <td style="text-align: right;">
                                {{ rtrim(rtrim(number_format($totalWeighted, 2, '.', ''), '0'), '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="meta">No career clusters to display.</div>
        @endif
    </div>

    <div class="meta" style="margin-top: 10px;">
        <div class="h2-banner">
            <h2 class="h2-title">Customized Career Recommendation</h2>
        </div>
        @php
            $categoryDetails = \App\Models\CareerCategory::whereIn('name', array_keys($overallCategoryWeightages ?? []))
                ->get()
                ->keyBy('name');
        @endphp
        @foreach ($overallCategoryWeightages ?? [] as $catName => $totalWeighted)
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
                        <h3 style="margin:0; font-size: 14px;">{!! $catName !!}@if (!empty($hook))
                                - {!! $hook !!}
                            @endif
                        </h3>
                    </div>

                </div>

                <div class="meta" style="margin-top: 6px;">
                    @if (!empty($what_is_it))
                        <div style="margin-bottom:6px;">{!! $what_is_it !!}</div>
                    @endif

                    @if (!empty($roles))
                        <div style="margin-bottom:6px;"><strong>Example Roles</strong> -
                            <span>{!! $roles !!}</span>
                        </div>
                    @endif

                    @if (!empty($subjects))
                        <div style="margin-bottom:6px;"><strong>Subjects</strong> - <span>{!! $subjects !!}</span>
                        </div>
                    @endif

                    @if (!empty($core_apptitudes_to_highlight))
                        <div style="margin-bottom:6px;"><strong>Core aptitudes to highlight</strong> -
                            <span>{!! $core_apptitudes_to_highlight !!}</span>
                        </div>
                    @endif

                    @if (!empty($value_and_personality_edge))
                        <div style="margin-bottom:6px;"><strong>Value and personality edge</strong> -
                            <span>{!! $value_and_personality_edge !!}</span>
                        </div>
                    @endif

                    @if (!empty($why_it_could_fit_you))
                        <div style="margin-bottom:6px;"><strong>Why it could fit you</strong> -
                            <span>{!! $why_it_could_fit_you !!}</span>
                        </div>
                    @endif

                    @if (!empty($early_actions))
                        <div style="margin-bottom:6px;"><strong>Early actions</strong> -
                            <span>{!! $early_actions !!}</span>
                        </div>
                    @endif

                    @if (!empty($india_study_pathways))
                        <div style="margin-bottom:6px;"><strong>India study pathways</strong> -
                            <span>{!! $india_study_pathways !!}</span>
                        </div>
                    @endif

                    @if (!empty($future_trends))
                        <div style="margin-bottom:6px;"><strong>Future trends</strong> -
                            <span>{!! $future_trends !!}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="meta">
        <div class="h2-banner">
            <h2 class="h2-title">Counselor's Remarks</h2>
        </div>
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

    <br>
    <br>
    <!-- Fixed footer that repeats on every page (must be inside body for dompdf) -->
    <div class="pdf-footer">
        <div class="footer-top-stripe-1"></div>
        <div class="footer-top-stripe-2"></div>
        <div class="footer-inner">
            <img class="footer-logo" src="{{ asset('images/footerlogo.png') }}" alt="footer logo">
            <div class="copyright">Copyright - TheCareerMap.in</div>
        </div>


    </div>

</body>

</html>
