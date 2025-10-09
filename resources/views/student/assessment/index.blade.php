@extends('layouts.app')

@section('content')
<div class="container py-5">
    @if ($domain)
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <strong class="flex-grow-1">{{ $domain->name ?? '' }}</strong>
                
            </div>
            <div class="card-body">
                <p class="mb-4">{!! $domain->instruction !!}</p>
                
                <form id="assessment-form">
                    @csrf
                    <input type="hidden" name="domain_id" value="{{ $domain->id }}">
                    @php
                        $likertScales = [
                            'likert' => [
                                1 => 'Not at all interested',
                                2 => 'Slightly interested',
                                3 => 'Moderately interested',
                                4 => 'Quite interested',
                                5 => 'Very much interested',
                            ],
                            'likert2' => [
                                1 => 'Strongly Disagree',
                                2 => 'Disagree',
                                3 => 'Neutral',
                                4 => 'Agree',
                                5 => 'Strongly Agree',
                            ],
                            'objective' => [
                                1 => 'Strongly agree',
                                2 => 'Strongly disagree',
                            ],
                        ];
                        $questionNumber = 1;
                    @endphp

                    @foreach ($sections as $section)
                        <div class="mb-5">
                            {{-- <div class="alert alert-light fw-bold">
                                {{ $section->title ?? '' }}
                            </div> --}}
                            @foreach ($section->questions as $question)
                                <div class="mb-4 p-3 border rounded bg-light question-item">
                                    {{-- <div class="fw-medium mb-2">{{ $questionNumber++ }}. {!! $question->question !!}</div> --}}
                                    <div class="fw-medium mb-2 d-flex align-items-start">
                                        <span class="me-2">{{ $questionNumber++ }}.</span>
                                        <span>{!! $question->question !!}</span>
                                    </div>
                                    
                                    <div class="d-flex flex-wrap gap-3 mt-2">
                                        @php $scoringType = $section->domain->scoring_type; @endphp

                                        @if ($scoringType === 'mcq')
                                            @foreach ($question->options as $option)
                                                <div class="form-check form-check-inline align-items-start">
                                                    <input class="form-check-input" type="radio"
                                                           name="responses[{{ $question->id }}]"
                                                           value="{{ $option->id }}"
                                                           {{ (old('responses.' . $question->id) ?? ($previousAnswers[$question->id] ?? null)) == $option->id ? 'checked' : '' }} required>
                                                    <label class="form-check-label option-text">{!! $option->option_text !!}</label>
                                                </div>
                                            @endforeach
                                        @else
                                            @php $options = $likertScales[$scoringType] ?? null; @endphp

                                            @if ($options)
                                                @foreach ($options as $value => $label)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                               name="responses[{{ $question->id }}]"
                                                               value="{{ $value }}"
                                                               {{ (old('responses.' . $question->id) ?? ($previousAnswers[$question->id] ?? null)) == $value ? 'checked' : '' }} required>
                                                        <label class="form-check-label">{{ $label }}</label>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="text-danger small">Unknown scoring type</span>
                                            @endif
                                        @endif
                                    </div>
                                    <input type="hidden" name="section_ids[{{ $question->id }}]" value="{{ $section->id }}">
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        @if ($isFirstDomain)
                            <a href="{{ route('assessment.index') }}" class="btn btn-outline-secondary">Back</a>
                        @else
                            <a href="{{ route('assessment.domain.view', $previousDomain->id) }}" class="btn btn-outline-secondary">Previous</a>
                        @endif

                        @if ($isLastDomain)
                            <button type="submit" class="btn btn-success ms-3">Submit Assessment</button>
                        @else
                            <div class="d-flex gap-2 ms-auto">
                                <button type="button" id="save-btn" class="btn btn-outline-primary">Save</button>
                                <button type="submit" class="btn btn-primary">Save & Next</button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="text-center py-4">
            <p class="text-muted">No assessment available.</p>
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/decoupled-document/ckeditor.js"></script>
<style>
    
    .option-text { line-height: 1.5; }
    .question-item { transition: box-shadow 0.2s; }
    .question-item:hover { box-shadow: 0 0.5rem 1rem rgba(0,0,0,.10); }
    .option-text p { margin: 0; }
    .option-text img { max-width: 100%; height: auto; margin: 8px 0; }
    .option-text table { border-collapse: collapse; margin: 8px 0; }
    .option-text table td,
    .option-text table th { border: 1px solid #ddd; padding: 8px; }
</style>
<script>
    $(document).ready(function () {
        $('#assessment-form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('assessment.store') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    if (response.next_domain_url) {
                        window.location.href = response.next_domain_url;
                    } else {
                        window.location.href = '{{ route('assessment.result') }}';
                    }
                },
                error: function (xhr) {
                    console.error('Error:', xhr);
                    alert('Failed to save responses. Please try again.');
                }
            });
        });
        $('#save-btn').on('click', function () {
            $.ajax({
                url: '{{ route('assessment.store') }}',
                method: 'POST',
                data: $('#assessment-form').serialize(),
                success: function () {
                    alert('Responses saved successfully!');
                },
                error: function (xhr) {
                    console.error('Error:', xhr);
                    alert('Failed to save responses. Please try again.');
                }
            });
        });
    });
</script>
@endsection
