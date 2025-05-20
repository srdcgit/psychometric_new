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
        <h1 class="text-4xl font-bold text-center text-indigo-700 mb-12" style="margin-top:-50px;padding:15px">📊 Assessment Results</h1>

        @foreach ($groupedResults as $domainName => $sections)
            <div class="bg-white shadow-xl rounded-3xl p-8 mb-12 border border-gray-200 transition hover:shadow-2xl" style="padding-top:20px;width:65%;margin:auto">


                {{-- Section Cards --}}
                {{-- <div class="flex flex-wrap -mx-4">
                    @foreach ($sections as $section)
                        <div class="w-full sm:w-1/2 lg:w-1/3 px-4 mb-6">
                            <div
                                class="h-full bg-gray-50 rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $section['section_name'] }}</h3>
                                <p class="text-gray-700 text-sm mb-3">{!! $section['section_description'] !!}</p>
                                <br>
                                <div class="text-sm text-gray-700 space-y-1">
                                    <p><span class="font-bold text-gray-800">Average Score:</span>
                                        {{ $section['average'] }}</p>
                                    <p><span class="font-bold">Key Traits:</span> {{ $section['section_keytraits'] }}
                                    </p>
                                    <p><span class="font-bold">Enjoys:</span> {{ $section['section_enjoys'] }}</p>
                                    <p><span class="font-bold">Ideal Environments:</span>
                                        {{ $section['section_idealenvironments'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> --}}

                {{-- Section Cards --}}
                <div class="flex flex-wrap -mx-4">
                    @foreach ($sections as $section)
                        <div class="w-full sm:w-1/2 lg:w-1/3 px-4 mb-6">
                            <div
                                class="h-full bg-gray-50 rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $section['section_name'] }} - {{ $section['label'] }}</h3>
                                <p class="text-gray-700 text-sm mb-3">{!! $section['section_description'] !!}</p>
                                <br>
                                <div class="text-sm text-gray-700 space-y-1">
                                    <p><span class="font-bold text-gray-800">Average Score:</span>
                                        {{ $section['average'] }}</p>
                                    <p><span style="font-weight:bold;">Key Traits:</span> {{ $section['section_keytraits'] }}
                                    </p>
                                    <p><span style="font-weight:bold;">Enjoys:</span> {{ $section['section_enjoys'] }}</p>
                                    <p><span style="font-weight:bold;">Ideal Environments:</span>
                                        {{ $section['section_idealenvironments'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- After all section cards --}}
                @if (!empty($sections))
                    <div class="mt-10">
                        <h4 class="text-2xl font-semibold text-indigo-700 mb-4" style="margin-left:20px;">💼 Suggested Career Paths</h4>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left border border-gray-300 rounded-lg"style="margin-left:20px;margin-bottom:30px">
                                <thead class="bg-gray-100">

                                </thead>
                                <tbody>
                                    @foreach ($sections as $sec)
                                        @php
                                            $sectionId = $sec['section_id'] ?? null;
                                            $paths = $careerpaths[$sectionId] ?? collect();
                                        @endphp

                                        @if ($paths->isNotEmpty())
                                            @foreach ($paths as $path)
                                                <tr>
                                                    <td class="px-4 py-2 border" style="font-weight:bold;">{{ $sec['section_name'] }}</td>
                                                    <td class="px-4 py-2 border text-center">{!! $path->name !!}
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


                {{-- Chart --}}
                <div class="mt-8">
                    @php $slug = Str::slug($domainName); @endphp
                    <div class="bg-white rounded-xl p-6 border border-gray-300 shadow-md">
                        <h3 class="text-lg font-semibold text-indigo-600 mb-4">
                            Visual Representation of your Score
                        </h3>
                        <canvas id="chart-{{ $slug }}" height="200"></canvas>
                    </div>
                </div>
            </div>
        @endforeach
    </div>








    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const chartData = @json($groupedResults);

        Object.entries(chartData).forEach(([domain, sections]) => {
            const slug = domain.toLowerCase().replace(/[^a-z0-9]+/g, '-');
            const ctx = document.getElementById(`chart-${slug}`);

            if (!ctx) return;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: sections.map(s => s.section_name),
                    datasets: [{
                        label: 'Average Score',
                        data: sections.map(s => s.average_value),
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
