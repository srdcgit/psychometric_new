@extends('layouts.app')

@section('content')

    <style>
        .card-body canvas {
            width: 100% !important;
            max-width: 500px;
            /* reduce width */
            height: auto !important;
            max-height: 250px;
            /* reduce height */
            margin: 0 auto;
            display: block;
        }

        .career-list {
            counter-reset: list-counter;
            list-style: none;
            padding-left: 1.5rem;
        }

        .career-list li {
            counter-increment: list-counter;
            position: relative;
            margin-bottom: 0.4rem;
        }

        .career-list li::before {
            content: counter(list-counter) ".";
            position: absolute;
            left: -1.2rem;
            color: #0d6efd;
            font-weight: 600;
        }

        p {
            margin-bottom: none !important;
        }
    </style>
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
                @php
                    $slug = Str::slug($domainName);
                    $domainDisplayName = $sections['cards'][0]['domain_display_name'] ?? $domainName;
                @endphp
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $slug }}"
                        data-bs-toggle="tab" data-bs-target="#{{ $slug }}" type="button" role="tab"
                        aria-controls="{{ $slug }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $domainDisplayName }}
                    </button>
                </li>
            @endforeach
        </ul>


        {{-- Tab Content --}}
        <div class="tab-content mx-auto" id="resultTabContent" style="width: 80%; max-width: 1000px;">
            @foreach ($groupedResults as $domainName => $sections)
                @php $slug = Str::slug($domainName); @endphp
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $slug }}" role="tabpanel"
                    aria-labelledby="tab-{{ $slug }}">
                    {{-- Domain Description --}}
                    @if (isset($sections['description']) && $sections['description'])
                        <div class="alert alert-info d-flex align-items-center mb-4">
                            <span class="me-2"><i class="bi bi-info-circle text-info"></i></span>
                            <div><strong>Description:</strong> {!! $sections['description'] !!}</div>
                        </div>
                    @endif

                    {{-- Section cards --}}
                    <div class="row g-4 mb-5 mx-auto">
                        @foreach ($sections['cards'] ?? [] as $section)
                            <article class="col-12">
                                <div class="card border rounded-4 shadow-sm h-100">
                                    <div class="row g-0 w-100 align-items-center">

                                        {{-- Left side: Image --}}
                                        <div class="col-4 text-center p-3">
                                            <img src="{{ asset($section['section_image']) }}"
                                                alt="{{ $section['section_name'] }} image" class="img-fluid"
                                                style="max-height: 100px; object-fit: contain;">
                                        </div>

                                        {{-- Right side: Content --}}
                                        <div class="col-8">
                                            <div class="card-body p-3">
                                                <h5 class="card-title mb-1 fw-bold text-dark">
                                                    {{ $section['section_name'] }}
                                                    @if (isset($section['label']))
                                                        <small class="text-muted">- {{ $section['label'] }}</small>
                                                    @endif
                                                </h5>

                                                <p class="mb-2 small text-muted">
                                                    <strong>{{ $domainName === 'APTITUDE' ? 'Total Score:' : 'Average Score:' }}</strong>
                                                    {{ $section['average'] }}
                                                </p>

                                                <p class="text-muted small mb-2">{!! $section['section_description'] !!}</p>

                                                {{-- Conditional Details --}}
                                                @if ($domainName === 'OCEAN')
                                                    <p class="small"><strong>{{ $section['label'] }}:</strong>
                                                        {{ $section['relevant_description'] }}</p>
                                                @elseif ($domainName === 'WORK VALUES')
                                                    @if ($section['label'] === 'Low')
                                                        <p class="small"><strong>Low:</strong> {{ $section['low'] }}</p>
                                                    @elseif ($section['label'] === 'Mid')
                                                        <p class="small"><strong>Mid:</strong> {{ $section['mid'] }}</p>
                                                    @elseif ($section['label'] === 'High')
                                                        <p class="small"><strong>High:</strong> {{ $section['high'] }}</p>
                                                    @endif
                                                @else
                                                    <div class="small">
                                                        <p><strong>Key Traits:</strong> {{ $section['section_keytraits'] }}
                                                        </p>
                                                        <p><strong>Enjoys:</strong> {{ $section['section_enjoys'] }}</p>
                                                        <p><strong>Ideal Environments:</strong>
                                                            {{ $section['section_idealenvironments'] }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="row">
                        {{-- Show Career Cluster  --}}
                        <div class="col">
                            @php $careerPathSections = $sections['cards']; @endphp
                            @if (!empty($careerPathSections) && $domainName !== 'GOAL ORIENTATION')
                                <div class="mb-5">
                                    <h4 class="fw-semibold text-primary mb-3">Suggested Career Paths</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
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
                                                            <td class="fw-bold text-primary text-center">
                                                                {{ $sec['section_name'] }}
                                                            </td>
                                                            <td>
                                                                @if ($combinedCareers->count() > 0)
                                                                    @php
                                                                        // Group careers by category name (or Uncategorized)
                                                                        $groupedByCategory = $combinedCareers->groupBy(
                                                                            fn($c) => $c->careerCategory->name ??
                                                                                'Uncategorized',
                                                                        );
                                                                    @endphp

                                                                    @foreach ($groupedByCategory as $categoryName => $careersInCategory)
                                                                        <div class="mb-3 border-bottom pb-2">
                                                                            {{-- Category Name --}}
                                                                            <h6 class="fw-semibold text-primary mb-2">
                                                                                <i class="bi bi-folder2-open me-1"></i>
                                                                                {!! $categoryName !!}
                                                                            </h6>

                                                                            {{-- Careers under this category --}}
                                                                            <ol class="ms-3 mb-0 career-list">
                                                                                @php
                                                                                    $displayCareers = $careersInCategory->take(
                                                                                        2,
                                                                                    );
                                                                                    $hiddenCareers = $careersInCategory->skip(
                                                                                        2,
                                                                                    );
                                                                                @endphp

                                                                                @foreach ($displayCareers as $career)
                                                                                    <li class="mb-1">
                                                                                        <span
                                                                                            class="text-dark small fw-medium">{!! $career->name !!}</span>
                                                                                    </li>
                                                                                @endforeach
                                                                                {{-- Show "+N more" popover if there are hidden ones --}}
                                                                                @if ($hiddenCareers->count() > 0)
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-outline-secondary text-primary fw-semibold"
                                                                                        data-bs-toggle="popover"
                                                                                        data-bs-html="true"
                                                                                        title="More Careers"
                                                                                        data-bs-content="
                                                                                         <ul class='career-list mb-0'>
                                                                                             @foreach ($hiddenCareers as $career)
                                                                                             <li>{!! $career->name !!}</li>
                                                                                             @endforeach
                                                                                         </ul>
                                                                                     ">
                                                                                        +{{ $hiddenCareers->count() }}
                                                                                        more
                                                                                    </button>
                                                                                @endif

                                                                            </ol>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <span class="text-muted fst-italic">No careers
                                                                        assigned</span>
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
                                                <h5 class="fw-bold text-primary mb-2"><i class="bi bi-clock me-2"></i>Short
                                                    Term
                                                </h5>
                                                <p class="text-dark">Aim for short milestones and rewards. Match with roles
                                                    needing
                                                    daily targets.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-0 bg-gradient bg-success-subtle">
                                            <div class="card-body">
                                                <h5 class="fw-bold text-success mb-2"><i
                                                        class="bi bi-bullseye me-2"></i>Long Term
                                                </h5>
                                                <p class="text-dark">Use Vision boards, planning tools, long-term
                                                    mentorship. Ideal
                                                    for research, entrepreneurship, civil services.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Chat show  --}}
                        <div class="col">
                            <div class="card shadow mt-4 border-0">
                                <div class="card-body">
                                    <h5 class="fw-bold text-primary mb-3">Visual Representation of your Score</h5>
                                    <canvas id="chart-{{ $slug }}" height="180"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            @endforeach
        </div>
    </div>

    <!-- Chart.js & Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    {{-- <script>
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
    </script> --}}

    <script>
        const chartData = @json($groupedResults);

        Object.entries(chartData).forEach(([domain, sections]) => {
            const slug = domain.toLowerCase().replace(/[^a-z0-9]+/g, '-');
            const ctx = document.getElementById(`chart-${slug}`);
            if (!ctx) return;

            const chartSections = sections.chart;
            const labels = chartSections.map(s => s.section_name);
            const dataValues = chartSections.map(s => s.average_value);

            // 🧠 Choose chart type per domain
            let chartType = 'bar';
            let backgroundColor = '#0d6efd';
            let borderColor = '#0d6efd';
            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10
                    }
                }
            };

            switch (domain.toUpperCase()) {
                case 'APTITUDE':
                    chartType = 'bar';
                    backgroundColor = '#007bff';
                    break;

                case 'OCEAN': // Big 5 Personality
                    chartType = 'radar';
                    backgroundColor = 'rgba(13, 110, 253, 0.4)';
                    borderColor = '#0d6efd';
                    options = {
                        responsive: true,
                        elements: {
                            line: {
                                borderWidth: 2
                            }
                        },
                        scales: {
                            r: {
                                angleLines: {
                                    display: true
                                },
                                suggestedMin: 0,
                                suggestedMax: 10
                            }
                        }
                    };
                    break;

                case 'WORK VALUES':
                    chartType = 'doughnut';
                    backgroundColor = [
                        '#0d6efd', '#198754', '#ffc107', '#dc3545', '#6610f2'
                    ];
                    options = {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            }
                        }
                    };
                    break;

                case 'GOAL ORIENTATION':
                    chartType = 'polarArea';
                    backgroundColor = [
                        'rgba(13, 110, 253, 0.6)',
                        'rgba(25, 135, 84, 0.6)',
                        'rgba(255, 193, 7, 0.6)',
                        'rgba(220, 53, 69, 0.6)'
                    ];
                    options = {
                        responsive: true,
                        scales: {
                            r: {
                                suggestedMin: 0,
                                suggestedMax: 10
                            }
                        }
                    };
                    break;

                default:
                    chartType = 'bar';
            }

            new Chart(ctx, {
                type: chartType,
                data: {
                    labels: labels,
                    datasets: [{
                        label: (domain === 'APTITUDE') ? 'Total Score' : 'Average Score',
                        data: dataValues,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 2,
                        fill: chartType !== 'bar'
                    }]
                },
                options: options
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            })
        })
    </script>
@endsection
