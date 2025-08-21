<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assessment Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
        }

        h1 {
            color: #4338ca;
            font-size: 22px;
            margin-bottom: 10px;
        }

        h2 {
            color: #111827;
            font-size: 18px;
            margin: 16px 0 8px;
        }

        h3 {
            font-size: 14px;
            margin: 8px 0 4px;
        }

        .section {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 8px;
        }

        .meta {
            font-size: 12px;
            color: #374151;
        }

        .row {
            display: flex;
            gap: 10px;
        }

        .col {
            flex: 1;
        }

        .badge {
            background: #dbeafe;
            color: #1e40af;
            border-radius: 4px;
            padding: 2px 6px;
            font-size: 11px;
            display: inline-block;
            margin: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #e5e7eb;
            padding: 6px;
            font-size: 12px;
        }

        /* Static bar chart styles for PDF */
        .barRow {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 6px 0;
        }

        .barLabel {
            width: 35%;
            font-size: 12px;
            color: #374151;
        }

        .barTrack {
            flex: 1;
            height: 10px;
            background: #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }

        .barFill {
            height: 100%;
            background: #6366f1;
        }
    </style>
    @php use Illuminate\Support\Str; @endphp
    @php $student = $student ?? auth()->user(); @endphp
</head>

<body>
    <h1>Comprehensive Psychometric Assessment Report</h1>
    <div>
        <h2>Student Information</h2>
        <div>
            <div class="meta">
                <p class="meta">Name: {{ $student->name }}</p>
                <p class="meta">Class: {{ $student->class }} ({{ $student->subjects_stream }})
                </p>
                <p class="meta">Date: {{ date('d M Y') }}</p>
                <p class="meta">Conducted by: Career Guidance & Psychological Assessment Cell,
                    Career Map</p>
            </div>
        </div>
    </div>

    <div>
        <div>
            <h4>Comprehensive Career Guidance and Personality
                Assessment</h4>
            <p class="meta">An Integrated Report Based on Multiple Psychometric Tools:</p>
            <div class="meta">
                <style>
                    ol,
                    ul,
                    menu {
                        list-style: disc !important;
                        margin: 0 !important;
                        padding: 0 !important;
                    }
                </style>
                <ul class="meta">
                    <li>Holland Code (RIASEC)</li>
                    <li>NEO FFI (Big Five Personality)</li>
                    <li>VARK Learning Style</li>
                    <li>Work Values Inventory</li>
                    <li>Goal Orientation (Short-Term vs Long-Term)</li>
                    <li>Aptitude Profile</li>
                </ul>
            </div>

            <div class="meta">
                <h2>Introduction</h2>
                <p>This report is a comprehensive analysis of {{ $student->name }}'s personality traits, career
                    interests, learning preferences, work values, future orientation, and cognitive aptitude. The aim is
                    to provide holistic guidance to support academic planning, skill development, and long-term career
                    alignment.</p>
            </div>

            <div class="meta">
                <h2>Overview of Tools</h2>
                <ul class="meta">
                    <li><strong>Holland Code (RIASEC): </strong>Explores personality-job match across six vocational
                        types.</li>
                    <li><strong>NEO FFI: </strong>Assesses Big Five personality dimensions.</li>
                    <li><strong>VARK: </strong>Identifies preferred learning style.</li>
                    <li><strong>Work Values Inventory: </strong>Measures motivational drivers in professional settings.
                    </li>
                    <li><strong>Goal Orientation: </strong>Evaluates temporal preference (long vs short-term goals).
                    </li>
                    <li><strong>Aptitude Profile: </strong>Analyzes reasoning and cognitive abilities.</li>
                </ul>
            </div>

        </div>


    </div>

    @foreach ($groupedResults as $domainName => $sections)
        @php $slug = Str::slug($domainName); @endphp
        <h2>{{ $domainName }}</h2>

        <div>
            @if(isset($sections['description']) && $sections['description'])
                <div class="meta">
                    <div class="meta">
                        <div class="meta">
                            <p class="meta">
                                <strong>Description:</strong> {!! $sections['description'] !!}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @foreach ($sections['cards'] ?? [] as $section)
            <div class="section">
                <h3>{{ $section['section_name'] }} @if (isset($section['label']))
                        - {{ $section['label'] }}
                    @endif
                </h3>
                <div class="meta">{{ $domainName === 'APTITUDE' ? 'Total Score:' : 'Average Score:' }}
                    {{ $section['average'] }}</div>
                <div class="meta">{!! strip_tags($section['section_description']) !!}</div>
                @if ($domainName === 'OCEAN')
                    <div class="meta"><strong>{{ $section['label'] }}:</strong>
                        {{ $section['relevant_description'] }}</div>
                @elseif ($domainName === 'WORK VALUES')
                    @if ($section['label'] === 'Low')
                        <div class="meta"><strong>Low:</strong> {{ $section['low'] }}</div>
                    @elseif ($section['label'] === 'Mid')
                        <div class="meta"><strong>Mid:</strong> {{ $section['mid'] }}</div>
                    @elseif ($section['label'] === 'High')
                        <div class="meta"><strong>High:</strong> {{ $section['high'] }}</div>
                    @endif
                @else
                    <div class="meta"><strong>Key Traits:</strong> {{ $section['section_keytraits'] }}</div>
                    <div class="meta"><strong>Enjoys:</strong> {{ $section['section_enjoys'] }}</div>
                    <div class="meta"><strong>Ideal Environments:</strong>
                        {{ $section['section_idealenvironments'] }}</div>
                @endif
            </div>
        @endforeach

        @if (!empty($sections['cards']) && $domainName !== 'GOAL ORIENTATION')
            <h3>Suggested Career Paths</h3>
            <table>
                <tbody>
                    @foreach ($sections['cards'] as $sec)
                        @php
                            $sectionId = $sec['section_id'] ?? null;
                            $paths = $careerpaths[$sectionId] ?? collect();
                        @endphp
                        @if ($paths->isNotEmpty())
                            @foreach ($paths as $path)
                                <tr>
                                    <td style="width: 30%">{{ $sec['section_name'] }}</td>
                                    <td>
                                        @if ($path->careers->count() > 0)
                                            @foreach ($path->careers as $career)
                                                <span class="badge">{!! $career->name !!}</span>
                                            @endforeach
                                        @else
                                            <span class="meta">No careers assigned</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- Static bar chart (PDF-friendly, mirrors Result page data) --}}
        @if (!empty($sections['chart']))
            <h3>Visual Representation of your Score</h3>
            <div>
                @foreach ($sections['chart'] as $sec)
                    @php
                        $value = (float) ($sec['average_value'] ?? 0);
                        $clamped = max(0, min(10, $value));
                        $percent = $clamped * 10; // 0-100
                    @endphp
                    <div class="barRow">
                        <div class="barLabel">{{ $sec['section_name'] }} ({{ $value }})</div>
                        <div class="barTrack">
                            <div class="barFill" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach

    <br><br>

    <div class="meta">
        <h2>Integrated Analysis</h2>
        <p>{{ $student->name }} demonstrates high emotional stability, creativity, conscientiousness, and social
            engagement. His preference for autonomy and long-term orientation aligns well with careers requiring deep
            engagement and self-direction.</p>
    </div>

    <div class="meta">
        <h2>Counselor's Remarks</h2>
        <p>{{ $student->name }} exhibits a balanced and mature personality marked by self-awareness
            and goal clarity. With his cognitive strengths and humanistic values, he can lead in fields that demand
            both intellect and empathy. Encouraging exploratory learning and mentorship will enrich his trajectory.
        </p>
    </div>

    <div class="meta">
        <p>Signature</p>
        <p>XYZ</p>
        <p>Career Counsellor</p>
    </div>


</body>

</html>
