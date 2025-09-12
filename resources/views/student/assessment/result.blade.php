{{-- @php use Illuminate\Support\Str; @endphp --}}

<x-app-layout>

    @if (session('error'))
        <div class="p-5">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif



    <div class="max-w-7xl mx-auto py-12 px-6">
        <div class="flex items-center justify-between mb-12" style="margin-top:-50px;padding:15px">
            <h1 class="text-4xl font-bold text-center text-indigo-700">📊 Assessment Results</h1>
            <div class="space-x-2">
                <a href="{{ route('assessment.report') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">View Full Report</a>
                <a href="{{ route('assessment.report.pdf') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">Download PDF</a>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mb-8">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    @foreach ($groupedResults as $domainName => $sections)
                        @php $slug = Str::slug($domainName); @endphp
                        <button 
                            class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-pointer transition-colors duration-200"
                            data-tab="{{ $slug }}"
                            onclick="openTab(event, '{{ $slug }}')"
                        >
                            {{ $domainName }}
                        </button>
                    @endforeach
                </nav>
            </div>
        </div>

        <!-- Tab Content -->
        @foreach ($groupedResults as $domainName => $sections)
            @php $slug = Str::slug($domainName); @endphp
            <div id="{{ $slug }}" class="tab-content hidden">
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
                <div class="bg-white shadow-xl rounded-3xl p-8 mb-12 border border-gray-200 transition hover:shadow-2xl" style="padding-top:20px;width:65%;margin:auto">
                    {{-- Section Cards --}}
                    <div class="flex flex-wrap -mx-4">
                        @php
                            // For all domains, use 'cards' data
                            $displaySections = $sections['cards'];
                        @endphp
                        @foreach ($displaySections as $section)
                            <div class="w-full sm:w-1/2 lg:w-1/3 px-4 mb-6">
                                <div
                                    class="h-full bg-gray-50 rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $section['section_name'] }} - {{ $section['label'] }}</h3>
                                    <p class="text-gray-700 text-sm mb-3">{!! $section['section_description'] !!}</p>
                                    <br>
                                    <div class="text-sm text-gray-700 space-y-1">
                                        <p><span class="font-bold text-gray-800">
                                            @if ($domainName === 'APTITUDE')
                                                Total Score:
                                            @else
                                                Average Score:
                                            @endif
                                        </span>
                                            {{ $section['average'] }}</p>
                                        @if ($domainName === 'OCEAN')
                                            <p><span style="font-weight:bold;">{{ $section['label'] }}:</span> {{ $section['relevant_description'] }}</p>
                                        @elseif ($domainName === 'WORK VALUES')
                                            @if ($section['label'] === 'Low')
                                                <p><span style="font-weight:bold;">Low:</span> {{ $section['low'] }}</p>
                                            @elseif ($section['label'] === 'Mid')
                                                <p><span style="font-weight:bold;">Mid:</span> {{ $section['mid'] }}</p>
                                            @elseif ($section['label'] === 'High')
                                                <p><span style="font-weight:bold;">High:</span> {{ $section['high'] }}</p>
                                            @endif
                                        @else
                                            <p><span style="font-weight:bold;">Key Traits:</span> {{ $section['section_keytraits'] }}
                                            </p>
                                            <p><span style="font-weight:bold;">Enjoys:</span> {{ $section['section_enjoys'] }}</p>
                                            <p><span style="font-weight:bold;">Ideal Environments:</span>
                                                {{ $section['section_idealenvironments'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- After all section cards --}}
                    @php
                        // For all domains, use 'cards' data
                        $careerPathSections = $sections['cards'];
                    @endphp
                    @if (!empty($careerPathSections) && $domainName !== 'GOAL ORIENTATION')
                        <div class="mt-10">
                            <h4 class="text-2xl font-semibold text-indigo-700 mb-4" style="margin-left:20px;">💼 Suggested Career Paths</h4>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-left border border-gray-300 rounded-lg"style="margin-left:20px;margin-bottom:30px">
                                    <thead class="bg-gray-100">

                                    </thead>
                                    <tbody>
                                        @foreach ($careerPathSections as $sec)
                                            @php
                                                $sectionId = $sec['section_id'] ?? null;
                                                $paths = ($careerpaths[$sectionId] ?? collect())->filter(function ($p) {
                                                    return $p->sections && $p->sections->count() === 1;
                                                })->values();
                                                // Combine careers across all paths for this section and de-duplicate
                                                $combinedCareers = collect();
                                                foreach ($paths as $p) {
                                                    $combinedCareers = $combinedCareers->merge($p->careers);
                                                }
                                                $combinedCareers = $combinedCareers->unique('id')->values();
                                            @endphp

                                            @if ($paths->isNotEmpty())
                                                <tr>
                                                    <td class="px-4 py-2 border" style="font-weight:bold;">{{ $sec['section_name'] }}</td>
                                                    <td class="px-4 py-2 border text-center">
                                                        @if($combinedCareers->count() > 0)
                                                            @foreach($combinedCareers as $career)
                                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1 mb-1">
                                                                    {!! $career->name !!}
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

                    {{-- Recommendations for GOAL ORIENTATION Domain --}}
                    @if ($domainName === 'GOAL ORIENTATION')
                        <div class="mt-10">
                            <h4 class="text-2xl font-semibold text-indigo-700 mb-4" style="margin-left:20px;">🎯 Recommendations</h4>
                            
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Short Term Recommendations -->
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200 shadow-sm">
                                    <h5 class="text-lg font-semibold text-blue-800 mb-3 flex items-center">
                                        <span class="mr-2">⏰</span> Short Term
                                    </h5>
                                    <p class="text-gray-700 leading-relaxed">
                                        Aim for short milestones, and rewards. Match with roles needing daily targets.
                                    </p>
                                </div>
                                
                                <!-- Long Term Recommendations -->
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200 shadow-sm">
                                    <h5 class="text-lg font-semibold text-green-800 mb-3 flex items-center">
                                        <span class="mr-2">🎯</span> Long Term
                                    </h5>
                                    <p class="text-gray-700 leading-relaxed">
                                        Use Vision boards, planning tools, long-term mentorship. Ideal for research, entrepreneurship, civil services.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif


                    {{-- Chart --}}
                    <div class="mt-8">
                        <div class="bg-white rounded-xl p-6 border border-gray-300 shadow-md">
                            <h3 class="text-lg font-semibold text-indigo-600 mb-4">
                                Visual Representation of your Score
                            </h3>
                            <canvas id="chart-{{ $slug }}" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>








    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Tab functionality
        function openTab(evt, tabName) {
            // Hide all tab content
            const tabContents = document.getElementsByClassName("tab-content");
            for (let content of tabContents) {
                content.style.display = "none";
            }

            // Remove active class from all tab buttons
            const tabButtons = document.getElementsByClassName("tab-button");
            for (let button of tabButtons) {
                button.classList.remove("border-indigo-500", "text-indigo-600");
                button.classList.add("border-transparent", "text-gray-500", "hover:text-gray-700", "hover:border-gray-300");
            }

            // Show the selected tab content and mark the button as active
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.classList.remove("border-transparent", "text-gray-500", "hover:text-gray-700", "hover:border-gray-300");
            evt.currentTarget.classList.add("border-indigo-500", "text-indigo-600");
        }

        // Initialize charts
        const chartData = @json($groupedResults);

        Object.entries(chartData).forEach(([domain, sections]) => {
            const slug = domain.toLowerCase().replace(/[^a-z0-9]+/g, '-');
            const ctx = document.getElementById(`chart-${slug}`);

            if (!ctx) return;

            // For all domains, use 'chart' data (all sections)
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

        // Open first tab by default
        document.addEventListener('DOMContentLoaded', function() {
            const firstTabButton = document.querySelector('.tab-button');
            if (firstTabButton) {
                firstTabButton.click();
            }
        });
    </script>


</x-app-layout>
