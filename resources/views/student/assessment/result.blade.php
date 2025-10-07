@extends('layouts.app')

@section('content')
    @if (session('error'))
        <div class="container pt-4">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="container py-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-5">
            <h1 class="fw-bold text-center text-primary flex-grow-1">📊 Assessment Results</h1>
            <div>
                <a href="{{ route('assessment.report') }}" target="_blank" class="btn btn-primary me-2">View Full Report</a>
                <a href="{{ route('assessment.report.pdf') }}" class="btn btn-dark">Download PDF</a>
            </div>
        </div>

        {{-- Bootstrap Tabs --}}
        <ul class="nav nav-tabs mb-4" id="resultTab" role="tablist">
            @foreach ($groupedResults as $domainName => $sections)
                @php $slug = Str::slug($domainName); @endphp
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                            id="tab-{{ $slug }}"
                            data-bs-toggle="tab"
                            data-bs-target="#{{ $slug }}"
                            type="button"
                            role="tab"
                            aria-controls="{{ $slug }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $domainName }}
                    </button>
                </li>
            @endforeach
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content" id="resultTabContent">
            @foreach ($groupedResults as $domainName => $sections)
                @php $slug = Str::slug($domainName); @endphp
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $slug }}" role="tabpanel" aria-labelledby="tab-{{ $slug }}">
                    {{-- Domain Description --}}
                    @if(isset($sections['description']) && $sections['description'])
                        <div class="alert alert-info d-flex align-items-center mb-4">
                            <span class="me-2"><i class="bi bi-info-circle text-info"></i></span>
                            <div><strong>Description:</strong> {!! $sections['description'] !!}</div>
                        </div>
                    @endif

                    <div class="card shadow-lg border-0 mb-5">
                        <div class="card-body">
                            <div class="row g-4">
                                @php $displaySections = $sections['cards']; @endphp
                                @foreach ($displaySections as $section)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card h-100 bg-light border-primary border-2">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">{{ $section['section_name'] }} - {{ $section['label'] }}</h5>
                                                <p class="card-text small mb-2">{!! $section['section_description'] !!}</p>
                                                <div class="mb-2 small">
                                                    @if ($domainName === 'APTITUDE')
                                                        <strong>Total Score:</strong>
                                                    @else
                                                        <strong>Average Score:</strong>
                                                    @endif
                                                    {{ $section['average'] }}
                                                </div>
                                                @if ($domainName === 'OCEAN')
                                                    <div class="mb-2"><strong>{{ $section['label'] }}:</strong> {{ $section['relevant_description'] }}</div>
                                                @elseif ($domainName === 'WORK VALUES')
                                                    @if ($section['label'] === 'Low')
                                                        <div class="mb-2"><strong>Low:</strong> {{ $section['low'] }}</div>
                                                    @elseif ($section['label'] === 'Mid')
                                                        <div class="mb-2"><strong>Mid:</strong> {{ $section['mid'] }}</div>
                                                    @elseif ($section['label'] === 'High')
                                                        <div class="mb-2"><strong>High:</strong> {{ $section['high'] }}</div>
                                                    @endif
                                                @else
                                                    <div><strong>Key Traits:</strong> {{ $section['section_keytraits'] }}</div>
                                                    <div><strong>Enjoys:</strong> {{ $section['section_enjoys'] }}</div>
                                                    <div><strong>Ideal Environments:</strong> {{ $section['section_idealenvironments'] }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @php $careerPathSections = $sections['cards']; @endphp
                    @if (!empty($careerPathSections) && $domainName !== 'GOAL ORIENTATION')
                        <div class="mb-5">
                            <h4 class="fw-semibold text-primary mb-3">💼 Suggested Career Paths</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
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
                                                    <td class="fw-bold text-primary">{{ $sec['section_name'] }}</td>
                                                    <td>
                                                        @if($combinedCareers->count() > 0)
                                                            @foreach($combinedCareers as $career)
                                                                <span class="badge bg-info text-dark me-1 mb-1">{!! $career->name !!}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">No careers assigned</span>
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

                    @if ($domainName === 'GOAL ORIENTATION')
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <div class="card border-0 bg-gradient bg-primary-subtle">
                                    <div class="card-body">
                                        <h5 class="fw-bold text-primary mb-2"><i class="bi bi-clock me-2"></i>Short Term</h5>
                                        <p class="text-dark">Aim for short milestones and rewards. Match with roles needing daily targets.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 bg-gradient bg-success-subtle">
                                    <div class="card-body">
                                        <h5 class="fw-bold text-success mb-2"><i class="bi bi-bullseye me-2"></i>Long Term</h5>
                                        <p class="text-dark">Use Vision boards, planning tools, long-term mentorship. Ideal for research, entrepreneurship, civil services.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="card shadow mt-4 border-0">
                        <div class="card-body">
                            <h5 class="fw-bold text-primary mb-3">Visual Representation of your Score</h5>
                            <canvas id="chart-{{ $slug }}" height="180"></canvas>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Chart.js & Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Chart Data Initialization
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
                        label: (domain === 'APTITUDE') ? 'Total Score' : 'Average Score',
                        data: chartSections.map(s => s.average_value),
                        backgroundColor: '#0d6efd'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        y: { beginAtZero: true, max: 10 }
                    }
                }
            });
        });
    </script>
@endsection
