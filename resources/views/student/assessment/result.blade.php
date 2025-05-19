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
        <h1 class="text-4xl font-bold text-center text-indigo-700 mb-12">📊 Assessment Results</h1>

        @foreach ($groupedResults as $domainName => $sections)
            <div class="bg-white shadow-xl rounded-3xl p-8 mb-12 border border-gray-200 transition hover:shadow-2xl">
                <div class="mb-6">
                    <h2 class="text-3xl font-semibold text-indigo-600">{{ $domainName }}</h2>
                    <p class="text-gray-600 text-sm italic mt-1">
                        {!! $sections[0]['domain_description'] ?? 'No description available.' !!}
                    </p>
                </div>

                {{-- Section Cards --}}
                <div class="flex flex-wrap -mx-4">
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
                </div>

                {{-- Chart --}}
                <div class="mt-8">
                    @php $slug = Str::slug($domainName); @endphp
                    <div class="bg-white rounded-xl p-6 border border-gray-300 shadow-md">
                        <h3 class="text-lg font-semibold text-indigo-600 mb-4">
                            Visual Representation of {{ $domainName }}
                        </h3>
                        <canvas id="chart-{{ $slug }}" height="200"></canvas>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Suggested Career Paths --}}
    <div class="max-w-6xl mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold text-center text-indigo-700 mb-8">📊 Suggested Career Paths</h1>

        <div class="overflow-x-auto border border-gray-300 rounded-lg shadow-sm">
            <table class="min-w-full divide-y divide-gray-300 border border-gray-300 rounded-lg">
                <thead class="bg-indigo-50 border-b border-gray-300">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider border-r border-gray-300">
                            Section
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                            Career Name
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @foreach ($careerpaths as $careerpath)
                        <tr class="hover:bg-indigo-50 transition duration-150 border-b border-gray-300">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 font-medium border-r border-gray-300">
                                {{ $careerpath->section->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-indigo-600 font-semibold">
                                {!! $careerpath->name !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($careerpaths->count() == 0)
            <p class="text-center text-gray-500 italic mt-6">No career paths available at this time.</p>
        @endif
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
