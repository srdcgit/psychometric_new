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
                    @if(isset($sections['description']) && $sections['description'])
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
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
                                            $paths = ($careerpaths[$sectionId] ?? collect())->filter(function ($p) {
                                                return $p->sections && $p->sections->count() === 1;
                                            })->values();
                                            $combinedCareers = collect();
                                            foreach ($paths as $p) {
                                                $combinedCareers = $combinedCareers->merge($p->careers);
                                            }
                                            $combinedCareers = $combinedCareers->unique('id')->values();
                                        @endphp

                                        @if ($paths->isNotEmpty())
                                            <tr>
                                                <td class="px-4 py-2 border font-semibold">{{ $sec['section_name'] }}</td>
                                                <td class="px-4 py-2 border">
                                                    @if($combinedCareers->count() > 0)
                                                        @foreach($combinedCareers as $career)
                                                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1 mb-1">
                                                                {!! $career->name !!}
                                                                @if($career->careerCategory)
                                                                    <small style="display: block; font-size: 0.7em; color: #666; margin-top: 2px;">
                                                                        {!! $career->careerCategory->name !!}
                                                                    </small>
                                                                @endif
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

        @if (!empty($allCategoryCountsBySection))
            <div class="mt-4">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Repeated Career Categories (by Section)</h2>
                <div class="space-y-2">
                    @foreach ($allCategoryCountsBySection as $entry)
                        <div class="text-sm">
                            <span class="font-semibold">{!! $entry['domain'] !!} — {!! $entry['section'] !!}:</span>
                            @foreach ($entry['counts'] as $catName => $count)
                                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded mr-1 mb-1">
                                    {!! $catName !!} ({{ $count }})
                                </span>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Calculation part</h2>
            @if(!empty($groupedResults))
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <h3 class="text-lg font-semibold mb-2">Domain Weightage</h3>
                    <ul class="list-disc ml-5 text-sm">
                        @foreach($groupedResults as $domain => $data)
                            @php $weight = $data['domain_weightage'] ?? null; @endphp
                            @if(!is_null($weight))
                                <li class="mb-1"><span class="font-semibold">{{ $domain }}:</span> {{ $weight }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @php
                    $repeatedTotalsByDomain = collect($allCategoryCountsBySection ?? [])->groupBy('domain')->map(function($entries){
                        $sum = 0;
                        foreach ($entries as $e) {
                            // $e['counts'] is a Collection of category => count (only where count > 1)
                            $counts = $e['counts'];
                            $sum += (is_object($counts) && method_exists($counts, 'values')) ? array_sum($counts->values()->all()) : array_sum((array)$counts);
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
                <div class="bg-white rounded-xl border border-gray-200 p-4 mt-4">
                    <h3 class="text-lg font-semibold mb-3">Repeated Career Categories (aggregated by domain)</h3>
                    <div class="space-y-6">
                        @foreach($groupedResults as $domainName => $sections)
                            @php
                                $weight = (float) ($sections['domain_weightage'] ?? 0);
                                $entries = $repeatedByDomain->get($domainName, collect());
                                // Aggregate counts per category across all sections for this domain
                                $perCategoryTotals = [];
                                foreach ($entries as $e) {
                                    $counts = $e['counts'];
                                    $arr = (is_object($counts) && method_exists($counts, 'all')) ? $counts->all() : (array) $counts;
                                    foreach ($arr as $cat => $cnt) {
                                        if (!isset($perCategoryTotals[$cat])) { $perCategoryTotals[$cat] = 0; }
                                        $perCategoryTotals[$cat] += (int) $cnt;
                                    }
                                }
                                // Compute weighted scores per category and sort desc
                                $ranked = collect($perCategoryTotals)
                                    ->map(function($cnt, $cat) use ($weight){
                                        return [ 'category' => $cat, 'count' => (int)$cnt, 'weighted' => (float)$cnt * $weight ];
                                    })
                                    ->sortByDesc('weighted')
                                    ->values();
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-base font-semibold text-indigo-700">{{ $domainName }}</h4>
                                    <div class="text-xs text-gray-600">
                                        <span class="mr-3"><span class="font-semibold">Weightage:</span> {{ rtrim(rtrim(number_format($weight, 2, '.', ''), '0'), '.') }}</span>
                                    </div>
                                </div>
                                @if($ranked->count() > 0)
                                    <ol class="list-decimal ml-5 space-y-1 text-sm">
                                        @foreach($ranked as $index => $row)
                                            <li>
                                                <span class="font-semibold">{!! $row['category'] !!}</span>
                                                <span class="text-gray-600"> — total {{ $row['count'] }}, weighted {{ rtrim(rtrim(number_format($row['weighted'], 2, '.', ''), '0'), '.') }}</span>
                                                @if($index === 0)
                                                    <span class="ml-2 inline-block bg-indigo-100 text-indigo-800 text-[10px] px-2 py-0.5 rounded">Top scorer</span>
                                                @elseif($index === 1)
                                                    <span class="ml-2 inline-block bg-gray-100 text-gray-800 text-[10px] px-2 py-0.5 rounded">Second</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                    <div class="mt-3">
                                        <details>
                                            <summary class="cursor-pointer text-xs text-gray-600">Show per-section breakdown</summary>
                                            <div class="mt-2 space-y-1">
                                                @foreach($entries as $entry)
                                                    <div class="text-xs">
                                                        <span class="font-semibold">{!! $entry['section'] !!}:</span>
                                                        @foreach ($entry['counts'] as $catName => $count)
                                                            <span class="inline-block bg-green-100 text-green-800 text-[10px] px-2 py-0.5 rounded mr-1 mb-1">{!! $catName !!} ({{ $count }})</span>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </details>
                                    </div>
                                @else
                                    <div class="text-xs text-gray-500">No repeated categories found for this domain.</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
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
