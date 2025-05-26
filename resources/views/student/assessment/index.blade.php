<x-app-layout>
    <div class="max-w-4xl mx-auto py-10" style="padding:15px">
        @if ($domain)
            {{-- Show Domain Name --}}
            <div class="mb-6" style="padding:15px;background-color:#fff">
                <p>
                    {!! $domain->description !!}
                </p>
            </div>

            {{-- Questions Form --}}
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
                @endphp

                @foreach ($sections as $section)
                    <div class="mb-6 p-4 border rounded">
                        @foreach ($section->questions as $question)
                            <div class="mt-4">
                                <p class="font-medium text-gray-800">{{ $loop->iteration }}. {!! $question->question !!}
                                </p>
                                <div class="flex flex-wrap gap-3 mt-2">
                                    @php
                                        $scoringType = $section->domain->scoring_type;
                                    @endphp

                                    @if($scoringType === 'mcq')
                                        @foreach($question->options as $option)
                                            <label class="inline-flex items-center gap-2">
                                                <input type="radio" name="responses[{{ $question->id }}]"
                                                    value="{{ $option->id }}" required>
                                                <span>{{ $option->option_text }}</span>
                                            </label>
                                        @endforeach
                                    @else
                                        @php
                                            $options = $likertScales[$scoringType] ?? null;
                                        @endphp

                                        @if ($options)
                                            @foreach ($options as $value => $label)
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" name="responses[{{ $question->id }}]"
                                                        value="{{ $value }}" required>
                                                    <span>{{ $label }}</span>
                                                </label>
                                            @endforeach
                                        @else
                                            <span class="text-red-500 text-sm">Unknown scoring type</span>
                                        @endif
                                    @endif
                                </div>

                                <input type="hidden" name="section_ids[{{ $question->id }}]"
                                    value="{{ $section->id }}">
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('assessment.index') }}"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Back</a>

                    @if ($isLastDomain)
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                            Submit Assessment
                        </button>
                    @else
                        <div class="mt-6 flex justify-center gap-4">
                            <button type="button" id="save-btn" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                                Save
                            </button>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                Save & Next
                            </button>
                        </div>
                    @endif
                </div>
            </form>
        @else
            <div class="text-center py-8">
                <p class="text-gray-600">No assessment available.</p>
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#assessment-form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('assessment.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.next_domain_url) {
                            window.location.href = response.next_domain_url;
                        } else {
                            window.location.href = '{{ route('assessment.result') }}';
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        alert('Failed to save responses. Please try again.');
                    }
                });
            });

            // Add Save button functionality
            $('#save-btn').on('click', function() {
                $.ajax({
                    url: '{{ route('assessment.store') }}',
                    method: 'POST',
                    data: $('#assessment-form').serialize(),
                    success: function(response) {
                        alert('Responses saved successfully!');
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        alert('Failed to save responses. Please try again.');
                    }
                });
            });
        });
    </script>
</x-app-layout>
