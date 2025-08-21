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
                    <div class="mt-6">
                        <h4 class="text-xl font-semibold text-indigo-700 mb-2">Suggested Career Paths</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left border border-gray-300 rounded-lg">
                                <tbody>
                                    @foreach ($sections['cards'] as $sec)
                                        @php
                                            $sectionId = $sec['section_id'] ?? null;
                                            $paths = $careerpaths[$sectionId] ?? collect();
                                        @endphp
                                        @if ($paths->isNotEmpty())
                                            @foreach ($paths as $path)
                                                <tr>
                                                    <td class="px-4 py-2 border font-semibold">
                                                        {{ $sec['section_name'] }}</td>
                                                    <td class="px-4 py-2 border">
                                                        @if ($path->careers->count() > 0)
                                                            @foreach ($path->careers as $career)
                                                                <span
                                                                    class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1 mb-1">{!! $career->name !!}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-gray-500">No careers assigned</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
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
