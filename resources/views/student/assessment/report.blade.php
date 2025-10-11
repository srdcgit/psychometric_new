@extends('layouts.app')

@section('content')
    <div class="container max-w-5xl py-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-5">
            <h1 class="display-5 fw-bold text-primary flex-grow-1">Comprehensive Psychometric Assessment Report</h1>
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
            @php $slug = Str::slug($domainName);
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

                {{-- Sections Cards --}}
                <div class="row g-4">
                    @foreach ($sections['cards'] ?? [] as $section)
                        <article class="col-md-12 col-lg-6">
                            <div class="card border-primary shadow-sm rounded-4 h-100">
                                <div class="card-body">
                                    <img src="{{ asset($section['section_image']) }}"
                                        alt="{{ $section['section_name'] }} image" class="img-fluid mb-2">
                                    <h3 class="card-title h5 text-primary">{{ $section['section_name'] }}
                                        @if (isset($section['label']))
                                            - {{ $section['label'] }}
                                        @endif
                                    </h3>
                                    <p class="card-text small text-muted mb-3">{!! $section['section_description'] !!}</p>
                                    <p>
                                        <strong>{{ $domainName === 'APTITUDE' ? 'Total Score:' : 'Average Score:' }}</strong>
                                        {{ $section['average'] }}
                                    </p>

                                    @if ($domainName === 'OCEAN')
                                        <p class="small mt-2"><strong>{{ $section['label'] }}:</strong>
                                            {{ $section['relevant_description'] }}</p>
                                    @elseif ($domainName === 'WORK VALUES')
                                        @if ($section['label'] === 'Low')
                                            <p class="small mt-2"><strong>Low:</strong> {{ $section['low'] }}</p>
                                        @elseif ($section['label'] === 'Mid')
                                            <p class="small mt-2"><strong>Mid:</strong> {{ $section['mid'] }}</p>
                                        @elseif ($section['label'] === 'High')
                                            <p class="small mt-2"><strong>High:</strong> {{ $section['high'] }}</p>
                                        @endif
                                    @else
                                        <div class="small mt-3">
                                            <p><strong>Key Traits:</strong> {{ $section['section_keytraits'] }}</p>
                                            <p><strong>Enjoys:</strong> {{ $section['section_enjoys'] }}</p>
                                            <p><strong>Ideal Environments:</strong>
                                                {{ $section['section_idealenvironments'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Suggested Career Paths Table --}}
                @if (!empty($sections['cards']) && $domainName !== 'GOAL ORIENTATION')
                    <div class="mt-5">
                        <h4 class="fw-semibold text-primary mb-3">Suggested Career Paths</h4>
                        <div class="table-responsive rounded-4 shadow-sm border">
                            <table class="table table-hover align-middle text-sm mb-0">
                                <tbody>
                                    @foreach ($sections['cards'] as $sec)
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
                                        @endphp

                                        @if ($paths->isNotEmpty())
                                            <tr>
                                                <td class="fw-semibold">{{ $sec['section_name'] }}</td>
                                                <td class="small">
                                                    @if ($combinedCareers->count() > 0)
                                                        {{-- @foreach ($combinedCareers as $career)
                                                            <span
                                                                class="badge bg-info text-dark me-1 mb-1">{!! $career->name !!}</span>
                                                        @endforeach --}}

                                                         {{-- now merge and show single career cluster  --}}
                                                         @php
                                                         $uniqueCategories = $combinedCareers
                                                             ->pluck('careerCategory.name') // extract category names
                                                             ->filter() // remove null values
                                                             ->unique() // keep only unique ones
                                                             ->values();
                                                     @endphp

                                                     @foreach ($uniqueCategories as $categoryName)
                                                         <span class="badge bg-info text-dark me-1 mb-1">
                                                             {!! $categoryName !!}
                                                         </span>
                                                     @endforeach
                                                     {{-- end merging  --}}
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

                {{-- Chart --}}
                <div class="mt-5 card shadow-sm rounded-4 border-0">
                    <div class="card-body">
                        <h3 class="h5 text-primary mb-3">Visual Representation of your Score</h3>
                        <canvas id="chart-{{ $slug }}" height="200"></canvas>
                    </div>
                </div>
            </section>
        @endforeach

        {{-- Integrated Analysis --}}
        <section class="mt-5">
            <h2 class="h3 fw-semibold text-secondary mb-3">Integrated Analysis</h2>
            <p class="lead text-muted">{{ $student->name }} demonstrates high emotional stability, creativity,
                conscientiousness, and social engagement. His preference for autonomy and long-term orientation aligns well
                with careers requiring deep engagement and self-direction.</p>
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
            <p class="lead text-muted">{{ $student->name }} exhibits a balanced and mature personality marked by
                self-awareness and goal clarity. With his cognitive strengths and humanistic values, he can lead in fields
                that demand both intellect and empathy. Encouraging exploratory learning and mentorship will enrich his
                trajectory.</p>
            <address class="fs-6 mt-4">
                Signature<br>
                <strong>XYZ</strong><br>
                Career Counsellor
            </address>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script>
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
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, max: 10 } }
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
                        elements: { line: { borderWidth: 2 } },
                        scales: {
                            r: {
                                angleLines: { display: true },
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
                            legend: { display: true, position: 'bottom' }
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
                            r: { suggestedMin: 0, suggestedMax: 10 }
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
@endsection
