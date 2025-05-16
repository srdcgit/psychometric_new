<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Add Question</h2>
    </x-slot>

    <div class="py-10 max-w-2xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow rounded p-6">
            <form method="POST" action="{{ route('question.store') }}">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="domain_id" class="block text-gray-700 font-medium">Domain</label>
                        <select name="domain_id" id="domain_id" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Select Domain</option>
                            @foreach ($domains as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="section_id" class="block text-gray-700 font-medium">Section</label>
                        <select name="section_id" id="section_id" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Select Section</option>
                            <!-- Options will be loaded via AJAX -->
                        </select>
                    </div>
                </div>


                <br>
                <div class="mb-4">
                    <label for="question" class="block text-gray-700 font-medium">Question</label>
                    <textarea name="question" id="question" rows="4" class="w-full border rounded px-3 py-2 mt-1" required></textarea>
                </div>

                <x-primary-button>{{ __('Create') }}</x-primary-button>
            </form>
        </div>
    </div>

    {{-- Script  --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const sectionUrlTemplate = "{{ route('domain.sections', ['id' => '__ID__']) }}";
    </script>

    <script>
        $(document).ready(function() {
            $('#domain_id').on('change', function() {
                var domainId = $(this).val();
                var $sectionSelect = $('#section_id');
                console.log(domainId);


                $sectionSelect.html('<option value="">Loading...</option>');

                if (!domainId) {
                    $sectionSelect.html('<option value="">Select Section</option>');
                    return;
                }
   // Replace placeholder with actual ID
            var url = sectionUrlTemplate.replace('__ID__', domainId);
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(sections) {
                        var options = '<option value="">Select Section</option>';
                        $.each(sections, function(id, name) {
                            options += '<option value="' + id + '">' + name +
                                '</option>';
                        });
                        $sectionSelect.html(options);
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to load sections:', error);
                        $sectionSelect.html('<option value="">Error loading sections</option>');
                    }
                });
            });
        });
    </script>


</x-app-layout>
