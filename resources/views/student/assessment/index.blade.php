<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-3xl font-bold text-center mb-6">📝 Assessment</h1>

        @if ($domain)
            {{-- Show Domain Name --}}
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-indigo-700">
                    {{-- Domain: {{ $domain->name }} --}}
                </h2>
            </div>

            {{-- Questions Form --}}
            <form id="assessment-form">
                @csrf
                <input type="hidden" name="domain_id" value="{{ $domain->id }}">

                @php
                    $likert = [
                        1 => 'Strongly agree',
                        2 => 'Agree',
                        3 => 'Neutral',
                        4 => 'Disagree',
                        5 => 'Strongly disagree',
                    ];

                    $likert2 = [
                        1 => 'Strongly agree',
                        2 => 'Strongly disagree',
                    ];
                @endphp


                @foreach ($sections as $section)
                    <div class="mb-6 p-4 border rounded">
                        @foreach ($section->questions as $question)
                            <div class="mt-4">
                                <p class="font-medium text-gray-800">{{ $loop->iteration }}. {{ $question->question }}
                                </p>

                                <div class="flex flex-wrap gap-3 mt-2">
                                    @if ($section->domain->scoring_type === 'likert')
                                        @foreach ($likert as $value => $label)
                                            
                                            <label class="inline-flex items-center gap-2">
                                                <input type="radio" name="responses[{{ $question->id }}]"
                                                    value="{{ $value }}">
                                                <span>{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    @else
                                        {{-- Handle other scoring types if needed --}}
                                        <span class="text-red-500 text-sm">Unknown scoring type</span>
                                    @endif
                                </div>

                                <input type="hidden" name="section_ids[{{ $question->id }}]"
                                    value="{{ $section->id }}">
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <div class="mt-6 flex justify-center gap-4">
                    <button type="button" id="save-btn" class="btn btn-outline-primary">Save</button>
                    <button type="button" id="save-next-btn" class="btn btn-success">Save & Next</button>
                </div>
            </form>
        @else
            <div class="alert text-center alert-warning">No Assessment available at the moment.</div>
        @endif


    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const form = $('#assessment-form');

            function submitForm(goNext = false) {
                const data = form.serialize();
                const submitUrl = "{{ route('assessment.store') }}";

                $.ajax({
                    url: submitUrl,
                    method: 'POST',
                    data: data + '&_token={{ csrf_token() }}',
                    success: function(res) {
                        alert('Responses saved!');
                        if (goNext && res.next_domain_url) {
                            window.location.href = res.next_domain_url;
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Failed to save. Please check console for details.');
                    }
                });
            }

            $('#save-btn').on('click', function(e) {
                e.preventDefault();
                submitForm(false);
            });

            $('#save-next-btn').on('click', function(e) {
                e.preventDefault();
                submitForm(true);
            });
        });
    </script>

</x-app-layout>
