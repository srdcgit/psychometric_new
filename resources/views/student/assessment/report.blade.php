<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-6">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-indigo-700">Comprehensive Psychometric Assessment Report</h1>
            <div class="space-x-2">
                {{-- <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Print</button> --}}
                <a href="{{ route('assessment.report.pdf') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">Download
                    PDF</a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Student Information</h2>
            <div class="grid md:grid-cols-1 gap-4 text-sm">
                <div>
                    <p><span class="font-semibold">Name:</span> {{ $student->name }}</p>
                    <p><span class="font-semibold">Class:</span> {{ $student->class }} ({{ $student->subjects_stream }})
                    </p>
                    <p><span class="font-semibold">Date:</span> {{ date('d M Y') }}</p>
                    <p><span class="font-semibold">Conducted by:</span> Career Guidance & Psychological Assessment Cell,
                        Career Map</p>
                    {{-- <p><span class="font-semibold">Email:</span> {{ $student->email }}</p>
                    <p><span class="font-semibold">Role:</span> {{ optional($student->rolls)->name }}</p>
                    <p><span class="font-semibold">Institute:</span> {{ optional($student->institute)->name }}</p> --}}
                </div>
                {{-- <div>
                    <p><span class="font-semibold">Age:</span> {{ $student->age }}</p>
                    <p><span class="font-semibold">Class:</span> {{ $student->class }}</p>
                    <p><span class="font-semibold">School:</span> {{ $student->school }}</p>
                    <p><span class="font-semibold">Location:</span> {{ $student->location }}</p>
                </div>
                <div>
                    <p><span class="font-semibold">Subjects/Stream:</span> {{ $student->subjects_stream }}</p>
                    <p><span class="font-semibold">Career Aspiration:</span> {{ $student->career_aspiration }}</p>
                    <p><span class="font-semibold">Parental Occupation:</span> {{ $student->parental_occupation }}</p>
                </div> --}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4 class="text-xl font-semibold text-gray-800">Comprehensive Career Guidance and Personality
                    Assessment</h4>
                <p class="mb-4">An Integrated Report Based on Multiple Psychometric Tools:</p>
                <div>
                    <style>
                        ol,
                        ul,
                        menu {
                            list-style: disc !important;
                            margin: 0px !important;
                            padding: 0px !important;
                        }
                    </style>
                    <ul>
                        <li>Holland Code (RIASEC)</li>
                        <li>NEO FFI (Big Five Personality)</li>
                        <li>VARK Learning Style</li>
                        <li>Work Values Inventory</li>
                        <li>Goal Orientation (Short-Term vs Long-Term)</li>
                        <li>Aptitude Profile</li>
                    </ul>
                </div>

                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Introduction</h2>
                    <p class="mb-4">This report is a comprehensive analysis of {{ $student->name }}'s personality
                        traits, career interests, learning preferences, work values, future orientation, and cognitive
                        aptitude. The aim is to provide holistic guidance to support academic planning, skill
                        development, and long-term career alignment.</p>
                </div>

                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Overview of Tools</h2>
                    <ul>
                        <li><strong>Holland Code (RIASEC): </strong>Explores personality-job match across six vocational
                            types.</li>
                        <li><strong>NEO FFI: </strong>Assesses Big Five personality dimensions.</li>
                        <li><strong>VARK: </strong>Identifies preferred learning style.</li>
                        <li><strong>Work Values Inventory: </strong>Measures motivational drivers in professional
                            settings.</li>
                        <li><strong>Goal Orientation: </strong>Evaluates temporal preference (long vs short-term goals).
                        </li>
                        <li><strong>Aptitude Profile: </strong>Analyzes reasoning and cognitive abilities.</li>
                    </ul>
                </div>
            </div>




        </div>

        <br><br><br>

        @foreach ($groupedResults as $domainName => $sections)
            @php $slug = Str::slug($domainName); @endphp
            <div class="mb-10">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $domainName }}</h2>

                <div>
                    @if (isset($sections['description']) && $sections['description'])
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>Description:</strong> {!! $sections['description'] !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-6 print:p-0">
                    <div class="grid md:grid-cols-1 gap-6">
                        @foreach ($sections['cards'] ?? [] as $section)
                            <div class="bg-gray-50 rounded-lg p-4 border">
                                <h3 class="text-lg font-semibold">{{ $section['section_name'] }} @if (isset($section['label']))
                                        - {{ $section['label'] }}
                                    @endif
                                </h3>
                                <p class="text-sm text-gray-700 mb-2">{!! $section['section_description'] !!}</p>
                                <p class="text-sm"><span
                                        class="font-semibold">{{ $domainName === 'APTITUDE' ? 'Total Score:' : 'Average Score:' }}</span>
                                    {{ $section['average'] }}</p>

                                @if ($domainName === 'OCEAN')
                                    <p class="text-sm mt-1"><span class="font-semibold">{{ $section['label'] }}:</span>
                                        {{ $section['relevant_description'] }}</p>
                                @elseif ($domainName === 'WORK VALUES')
                                    @if ($section['label'] === 'Low')
                                        <p class="text-sm mt-1"><span class="font-semibold">Low:</span>
                                            {{ $section['low'] }}</p>
                                    @elseif ($section['label'] === 'Mid')
                                        <p class="text-sm mt-1"><span class="font-semibold">Mid:</span>
                                            {{ $section['mid'] }}</p>
                                    @elseif ($section['label'] === 'High')
                                        <p class="text-sm mt-1"><span class="font-semibold">High:</span>
                                            {{ $section['high'] }}</p>
                                    @endif
                                @else
                                    <div class="text-sm mt-2 space-y-1">
                                        <p><span class="font-semibold">Key Traits:</span>
                                            {{ $section['section_keytraits'] }}</p>
                                        <p><span class="font-semibold">Enjoys:</span> {{ $section['section_enjoys'] }}
                                        </p>
                                        <p><span class="font-semibold">Ideal Environments:</span>
                                            {{ $section['section_idealenvironments'] }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                @if (!empty($sections['cards']) && $domainName !== 'GOAL ORIENTATION')
                    @php
                        $careerPathSections = $sections['cards'];
                    @endphp
                    <div class="mt-6">
                        <h4 class="text-xl font-semibold text-indigo-700 mb-2">Suggested Career Paths</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left border border-gray-300 rounded-lg">
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
                                                $combinedCareers = $combinedCareers->merge($p->careers);
                                            }
                                            $combinedCareers = $combinedCareers->unique('id')->values();
                                        @endphp

                                        @if ($paths->isNotEmpty())
                                            <tr>
                                                <td class="px-4 py-2 border font-semibold">{{ $sec['section_name'] }}
                                                </td>
                                                <td class="px-4 py-2 border">
                                                    @if ($combinedCareers->count() > 0)
                                                        @foreach ($combinedCareers as $career)
                                                            <span
                                                                class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1 mb-1">
                                                                {!! $career->name !!}
                                                                {{-- @if ($career->careerCategory)
                                                                    <small
                                                                        style="display: block; font-size: 0.7em; color: #666; margin-top: 2px;">
                                                                        {!! $career->careerCategory->name !!}
                                                                    </small>
                                                                @endif --}}
                                                            </span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-gray-500">No careers assigned</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                {{-- Chart (same as Result page) --}}
                <div class="mt-8">
                    <div class="bg-white rounded-xl p-6 border border-gray-300 shadow-md">
                        <h3 class="text-lg font-semibold text-indigo-600 mb-4">
                            Visual Representation of your Score
                        </h3>
                        <canvas id="chart-{{ $slug }}" height="200"></canvas>
                    </div>
                </div>
            </div>
        @endforeach


        <br><br>

        <div class="mt-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Integrated Analysis</h2>
            <p class="mb-4">{{ $student->name }} demonstrates high emotional stability, creativity,
                conscientiousness, and social engagement. His preference for autonomy and long-term orientation aligns
                well with careers requiring deep engagement and self-direction.</p>
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


        <div class="mt-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Career Clusters with Total Weightage</h2>
            @php
                // Build domain -> entries map if not already available
                $repeatedByDomain = collect($allCategoryCountsBySection ?? [])->groupBy('domain');

                // Aggregate overall totals per category across all domains using domain weightage
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

                // Sort categories by total weighted value (desc)
                arsort($overallCategoryWeightages);
            @endphp

            @if (!empty($overallCategoryWeightages))
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left border border-gray-300 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">Career Cluster</th>
                                <th class="px-4 py-2 border text-right">Total Weightage</th>
                                {{-- <th class="px-4 py-2 border">Example roles</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $categoryDetails = \App\Models\CareerCategory::whereIn(
                                    'name',
                                    array_keys($overallCategoryWeightages),
                                )
                                    ->get()
                                    ->keyBy('name');
                            @endphp
                            @foreach ($overallCategoryWeightages as $catName => $totalWeighted)
                                <tr>
                                    <td class="px-4 py-2 border font-semibold">{!! $catName !!}</td>
                                    <td class="px-4 py-2 border text-right">
                                        {{ rtrim(rtrim(number_format($totalWeighted, 2, '.', ''), '0'), '.') }}</td>
                                    {{-- <td class="px-4 py-2 border">
                                        @php $roles = optional($categoryDetails->get($catName))->example_roles; @endphp
                                        {!! $roles ? $roles : '<span class="text-gray-500">—</span>' !!}
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-sm text-gray-500">No career clusters to display.</div>
            @endif
        </div>

        <div class="mt-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Customized Career Recommendation</h2>
            @foreach ($overallCategoryWeightages as $catName => $totalWeighted)
                @php
                    $roles = optional($categoryDetails->get($catName))->example_roles;
                    $hook = optional($categoryDetails->get($catName))->hook;
                    $what_is_it = optional($categoryDetails->get($catName))->what_is_it;
                    $example_roles = optional($categoryDetails->get($catName))->example_roles;
                    $subjects = optional($categoryDetails->get($catName))->subjects;
                    $core_apptitudes_to_highlight = optional($categoryDetails->get($catName))
                        ->core_apptitudes_to_highlight;
                    $value_and_personality_edge = optional($categoryDetails->get($catName))->value_and_personality_edge;
                    $why_it_could_fit_you = optional($categoryDetails->get($catName))->why_it_could_fit_you;
                    $early_actions = optional($categoryDetails->get($catName))->early_actions;
                    $india_study_pathways = optional($categoryDetails->get($catName))->india_study_pathways;
                    $future_trends = optional($categoryDetails->get($catName))->future_trends;
                @endphp
                <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{!! $catName !!} @if (!empty($hook))
                                    - {!! $hook !!}
                                @endif
                            </h3>
                        </div>
                       
                    </div>

                    <div class="mt-3 grid md:grid-cols-1 gap-4 text-sm">

                        @if (!empty($what_is_it))
                            <div>
                                <div class="text-gray-700">{!! $what_is_it !!}</div>
                            </div>
                        @endif

                        @if (!empty($roles))
                            <div>
                                <div class="text-gray-700 mb-1"><span class="font-semibold">Example Roles</span> - <span>{!! $roles !!}</span></div>
                            </div>
                        @endif
                        @if (!empty($subjects))
                            <div>
                                <div class="text-gray-700 mb-1"><span class="font-semibold">Subjects</span> - <span>{!! $subjects !!}</span></div>
                            </div>
                        @endif

                        @if (!empty($core_apptitudes_to_highlight))
                            <div>
                                <div class="text-gray-700 mb-1"><span class="font-semibold">Core aptitudes to highlight</span> - <span>{!! $core_apptitudes_to_highlight !!}</span></div>
                            </div>
                        @endif

                        @if (!empty($value_and_personality_edge))
                            <div>
                                <div class="text-gray-700 mb-1"><span class="font-semibold">Value and personality edge</span> - <span>{!! $value_and_personality_edge !!}</span></div>
                            </div>
                        @endif

                        @if (!empty($why_it_could_fit_you))
                            <div>
                                <div class="text-gray-700 mb-1"><span class="font-semibold">Why it could fit you</span> - <span>{!! $why_it_could_fit_you !!}</span></div>
                            </div>
                        @endif

                        @if (!empty($early_actions))
                            <div>
                                <div class="text-gray-700 mb-1"><span class="font-semibold">Early actions</span> - <span>{!! $early_actions !!}</span></div>
                            </div>
                        @endif

                        @if (!empty($india_study_pathways))
                            <div>
                                <div class="text-gray-700 mb-1"><span class="font-semibold">India study pathways</span> - <span>{!! $india_study_pathways !!}</span></div>
                            </div>
                        @endif

                        @if (!empty($future_trends))
                            <div>
                                <div class="text-gray-700 mb-1"><span class="font-semibold">Future trends</span> - <span>{!! $future_trends !!}</span></div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Counselor's Remarks</h2>
            <p class="mb-4">{{ $student->name }} exhibits a balanced and mature personality marked by self-awareness
                and goal clarity. With his cognitive strengths and humanistic values, he can lead in fields that demand
                both intellect and empathy. Encouraging exploratory learning and mentorship will enrich his trajectory.
            </p>
        </div>

        <div class="mt-4">
            <p>Signature</p>
            <p>XYZ</p>
            <p>Career Counsellor</p>
        </div>




    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartData = @json($groupedResults);

        Object.entries(chartData).forEach(([domain, sections]) => {
            const slug = domain.toLowerCase().replace(/[^a-z0-9]+/g, '-');
            const ctx = document.getElementById(`chart-${slug}`);

            if (!ctx) return;

            const chartSections = sections.chart;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartSections.map(s => s.section_name),
                    datasets: [{
                        label: domain === 'APTITUDE' ? 'Total Score' : 'Average Score',
                        data: chartSections.map(s => s.average_value),
                        backgroundColor: '#6366f1'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10
                        }
                    }
                }
            });
        });
    </script>

</x-app-layout>
