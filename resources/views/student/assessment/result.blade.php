{{-- @php use Illuminate\Support\Str; @endphp --}}

<x-app-layout>

   @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif



    <div class="max-w-6xl mx-auto py-10">
        <h1 class="text-2xl font-bold text-center mb-6">📊 Assessment Results</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($groupedResults as $domainName => $sections)
                <div class="bg-white shadow rounded-xl p-6 border">
                    <h2 class="text-xl font-semibold text-indigo-600 mb-4">{{ $domainName }}</h2>

                    <table class="table-auto w-full text-sm text-left">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">Section</th>
                                <th class="px-4 py-2 border text-center">Average Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sections as $section)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $section['section_name'] }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $section['average'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>

    {{-- bar graph here --}}

    <div class="mt-10 p-10">
        <h2 class="text-xl font-bold text-center mb-4">📊 Visual Summary (Top Sections per Domain)</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($groupedResults as $domain => $sections)
                @php $slug = Str::slug($domain); @endphp
                <div class="bg-white rounded-xl p-4 shadow border">
                    <h3 class="text-lg font-semibold text-indigo-600 mb-2">{{ $domain }}</h3>
                    <canvas id="chart-{{ Str::slug($domain) }}" height="200"></canvas>

                </div>
            @endforeach
        </div>
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
                        data: sections.map(s => s.average),
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
