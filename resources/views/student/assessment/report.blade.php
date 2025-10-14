@extends('layouts.app')

@section('content')

    <style>
        .card {
            border: 1px solid #dee2e6;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .card img {
            max-width: 100%;
            border-radius: 10px;
        }

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

        .career-list li::before {
            content: counter(list-counter) ".";
            position: absolute;
            left: -1.2rem;
            color: #0d6efd;
            font-weight: 600;
        }
    </style>
    <div class="container max-w-5xl py-5 mx-auto" style="width: 80%; max-width: 1000px;">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-5">
            <h3 class="fw-bold text-primary flex-grow-1">Comprehensive Psychometric Assessment Report</h3>
            <a href="{{ route('assessment.report.pdf') }}" class="btn btn-dark btn-lg px-4 shadow-sm">Download PDF</a>
        </div>

        {{-- Student Information --}}
        <div class="card shadow-sm rounded-4 border-0 mb-5">
            <div class="card-body">
                <h2 class="h4 fw-semibold mb-4 text-secondary">Student Information</h2>
                <dl class="row text-muted small">
                    <dt class="col-sm-3 fw-semibold">Name:</dt>
                    <dd class="col-sm-9">{{ $student->name }}</dd>

                    <dt class="col-sm-3 fw-semibold">Class & Stream:</dt>
                    <dd class="col-sm-9">{{ $student->class }} ({{ $student->subjects_stream }})</dd>

                    <dt class="col-sm-3 fw-semibold">Date:</dt>
                    <dd class="col-sm-9">{{ date('d M Y') }}</dd>

                    <dt class="col-sm-3 fw-semibold">Conducted by:</dt>
                    <dd class="col-sm-9">Career Guidance & Psychological Assessment Cell, Career Map</dd>
                </dl>
            </div>
        </div>

        {{-- Introduction and Overview --}}
        <div class="mb-5">
            <h2 class="h3 fw-semibold text-secondary mb-3">Introduction</h2>
            <p class="lead">This report is a comprehensive analysis of {{ $student->name }}'s personality traits, career
                interests, learning preferences, work values, future orientation, and cognitive aptitude. The aim is to
                provide holistic guidance to support academic planning, skill development, and long-term career alignment.
            </p>
        </div>

        <div class="mb-5">
            <h2 class="h3 fw-semibold text-secondary mb-3">Overview of Tools</h2>
            <ul class="list-group list-group-flush small">
                <li class="list-group-item"><strong>Holland Code (RIASEC):</strong> Explores personality-job match across
                    six vocational types.</li>
                <li class="list-group-item"><strong>NEO FFI:</strong> Assesses Big Five personality dimensions.</li>
                <li class="list-group-item"><strong>VARK:</strong> Identifies preferred learning style.</li>
                <li class="list-group-item"><strong>Work Values Inventory:</strong> Measures motivational drivers in
                    professional settings.</li>
                <li class="list-group-item"><strong>Goal Orientation:</strong> Evaluates temporal preference (long vs
                    short-term goals).</li>
                <li class="list-group-item"><strong>Aptitude Profile:</strong> Analyzes reasoning and cognitive abilities.
                </li>
            </ul>
        </div>

        {{-- Domains and Sections --}}
        @foreach ($groupedResults as $domainName => $sections)
            @php
                $slug = Str::slug($domainName);
                $domainDisplayName = $sections['cards'][0]['domain_display_name'] ?? $domainName;
            @endphp
            <section class="mb-5">
                <h2 class="h4 fw-semibold text-primary mb-4">{{ $domainDisplayName }}</h2>

                {{-- Description --}}
                @if (!empty($sections['description']))
                    <div class="alert alert-info rounded-4 py-3 mb-4 d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-3 fs-4 text-info"></i>
                        <div class="small">{!! $sections['description'] !!}</div>
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

               {{-- display career suggstion and chat  --}}
               <div class="row">
                {{-- Show Career Cluster  --}}
                <div class="col-12">
                    @php $careerPathSections = $sections['cards']; @endphp
                    @if (!empty($careerPathSections) && $domainName !== 'GOAL ORIENTATION')
                        <div class="mb-5">
                            <h4 class="fw-semibold text-primary mb-3">Suggested Career Paths</h4>

                            <div class="accordion" id="accordionExample">
                                @foreach ($careerPathSections as $index => $sec)
                                    @php
                                        $sectionId = $sec['section_id'] ?? null;
                                        $paths = ($careerpaths[$sectionId] ?? collect())
                                            ->filter(fn($p) => $p->sections && $p->sections->count() === 1)
                                            ->values();
                                        $combinedCareers = collect();
                                        foreach ($paths as $p) {
                                            $combinedCareers = $combinedCareers->merge($p->careers);
                                        }
                                        $combinedCareers = $combinedCareers->unique('id')->values();

                                        $collapseId = 'collapse' . $index;
                                        $headingId = 'heading' . $index;
                                        $isFirst = $index === 0; // first accordion open by default
                                    @endphp

                                    @if ($paths->isNotEmpty())
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="{{ $headingId }}">
                                                <button class="accordion-button {{ !$isFirst ? 'collapsed' : '' }}"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#{{ $collapseId }}"
                                                    aria-expanded="{{ $isFirst ? 'true' : 'false' }}"
                                                    aria-controls="{{ $collapseId }}">
                                                    <i class="bi bi-diagram-3 me-2"></i>{{ $sec['section_name'] }}
                                                </button>
                                            </h2>
                                            <div id="{{ $collapseId }}"
                                                class="accordion-collapse collapse {{ $isFirst ? 'show' : '' }}"
                                                aria-labelledby="{{ $headingId }}"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    @if ($combinedCareers->count() > 0)
                                                        @php
                                                            $groupedByCategory = $combinedCareers->groupBy(
                                                                fn($c) => $c->careerCategory->name ??
                                                                    'Uncategorized',
                                                            );
                                                        @endphp

                                                        @foreach ($groupedByCategory as $categoryName => $careersInCategory)
                                                            <div class="mb-3">
                                                                <h6 class="fw-semibold text-primary">
                                                                    <i
                                                                        class="bi bi-folder2-open me-1"></i>{!! $categoryName !!}
                                                                </h6>
                                                                @php
                                                                            $chunks = $careersInCategory->chunk(10); // Split into groups of 10
                                                                            $counter = 1; // Start numbering
                                                                        @endphp

                                                                        <div class="row g-3">
                                                                            @foreach ($chunks as $chunk)
                                                                                <div class="col-md-6 col-lg-4">
                                                                                    <ol class="mb-0" start="{{ $counter }}">
                                                                                        @foreach ($chunk as $career)
                                                                                            <li><span class="text-dark small">{!! $career->name !!}</span></li>
                                                                                            @php $counter++; @endphp
                                                                                        @endforeach
                                                                                    </ol>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-muted fst-italic">No careers assigned</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Goal Orientation Section --}}
                    @if ($domainName === 'GOAL ORIENTATION')
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <div class="card border-0 bg-gradient bg-primary-subtle">
                                    <div class="card-body">
                                        <h5 class="fw-bold text-primary mb-2"><i class="bi bi-clock me-2"></i>Short
                                            Term</h5>
                                        <p class="text-dark">Aim for short milestones and rewards. Match with roles
                                            needing daily targets.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 bg-gradient bg-success-subtle">
                                    <div class="card-body">
                                        <h5 class="fw-bold text-success mb-2"><i
                                                class="bi bi-bullseye me-2"></i>Long Term</h5>
                                        <p class="text-dark">Use Vision boards, planning tools, long-term
                                            mentorship. Ideal for research, entrepreneurship, civil services.</p>
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


            </section>
        @endforeach

        {{-- Integrated Analysis --}}
        <section class="mt-5">
            <h2 class="h3 fw-semibold text-secondary mb-3">Integrated Analysis</h2>

        </section>

        {{-- Customized Career Recommendation --}}
        @php
            $allCategoryCountsBySection = [];
            foreach ($groupedResults as $domainName => $sections) {
                $careerPathSections = $sections['cards'] ?? [];
                foreach ($careerPathSections as $sec) {
                    $sectionId = $sec['section_id'] ?? null;
                    $paths = ($careerpaths[$sectionId] ?? collect())
                        ->filter(fn($p) => $p->sections && $p->sections->count() === 1)
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
                        ->map(fn($career) => optional($career->careerCategory)->name)
                        ->filter()
                        ->countBy()
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

        <section class="mt-5">
            <h2 class="h3 fw-semibold text-secondary mb-3">Career Clusters with Total Weightage</h2>
            @php
                $repeatedByDomain = collect($allCategoryCountsBySection ?? [])->groupBy('domain');
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
                $categoryDetails = \App\Models\CareerCategory::whereIn('name', array_keys($overallCategoryWeightages))
                    ->get()
                    ->keyBy('name');
            @endphp

            @if (!empty($overallCategoryWeightages))
                <div class="table-responsive rounded-4 shadow-sm border">
                    <table class="table table-hover text-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Career Cluster</th>
                                <th class="text-end">Total Weightage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($overallCategoryWeightages as $catName => $totalWeighted)
                                <tr>
                                    <td class="fw-semibold">{!! $catName !!}</td>
                                    <td class="text-end">
                                        {{ rtrim(rtrim(number_format($totalWeighted, 2, '.', ''), '0'), '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted small">No career clusters to display.</p>
            @endif
        </section>

        {{-- Customized Career Recommendation Details --}}
        <section class="mt-5">
            <h2 class="h3 fw-semibold text-secondary mb-4">Customized Career Recommendation</h2>
            @foreach ($overallCategoryWeightages as $catName => $totalWeighted)
                @php
                    $details = $categoryDetails->get($catName);
                @endphp
                <div class="card rounded-4 mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h3 class="h5 text-primary fw-bold mb-3">{!! $catName !!}
                            @if (!empty($details->hook))
                                - {!! $details->hook !!}
                            @endif
                        </h3>

                        <div class="small text-muted">
                            @foreach ([
            'what_is_it' => 'What is it',
            'example_roles' => 'Example Roles',
            'subjects' => 'Subjects',
            'core_apptitudes_to_highlight' => 'Core Aptitudes to Highlight',
            'value_and_personality_edge' => 'Value and Personality Edge',
            'why_it_could_fit_you' => 'Why it Could Fit You',
            'early_actions' => 'Early Actions',
            'india_study_pathways' => 'India Study Pathways',
            'future_trends' => 'Future Trends',
        ] as $field => $label)
                                @if (!empty($details->$field))
                                    <p><strong>{{ $label }}:</strong> {!! $details->$field !!}</p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

        {{-- Counselor's Remarks --}}
        <section class="mt-5">
            <h2 class="h3 fw-semibold text-secondary mb-3">Counselor's Remarks</h2>
            <div class="card rounded-4 mb-4 shadow-sm border-0">
                <div class="card-body lead" style="height: 200px !important;">
                    {{-- Data will here  --}}
                </div>
            </div>


            <address class="fs-6 mt-4">
                Signature<br>
                <strong>XYZ</strong><br>
                Career Counsellor
            </address>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
