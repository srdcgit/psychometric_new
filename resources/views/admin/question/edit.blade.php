<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Question</h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded p-6">
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('question.update', $question->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="domain_id" class="block text-sm font-medium text-gray-700">Domain</label>
                    <select name="domain_id" id="domain_id" class="mt-1 block w-full rounded border-gray-300" required>
                        <option value="">Select Domain</option>
                        @foreach ($domains as $domain)
                            <option value="{{ $domain->id }}"
                                {{ old('domain_id', $question->domain_id) == $domain->id ? 'selected' : '' }}>
                                {{ $domain->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="section_id" class="block text-sm font-medium text-gray-700">Section</label>
                    <select name="section_id" id="section_id" class="mt-1 block w-full rounded border-gray-300" required>
                        <option value="">Select Section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}"
                                {{ old('section_id', $question->section_id) == $section->id ? 'selected' : '' }}>
                                {{ $section->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="question" class="block text-sm font-medium text-gray-700">Question</label>
                    <textarea name="question" id="question" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-500 sm:text-sm"
                              required>{{ old('question', $question->question) }}</textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('question.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Update Question
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Optional: Load sections dynamically on domain change
        document.getElementById('domain_id').addEventListener('change', function () {
            const domainId = this.value;
            fetch(`/get-sections/${domainId}`)
                .then(response => response.json())
                .then(data => {
                    const sectionSelect = document.getElementById('section_id');
                    sectionSelect.innerHTML = '<option value="">Select Section</option>';
                    for (const [id, name] of Object.entries(data)) {
                        sectionSelect.innerHTML += `<option value="${id}">${name}</option>`;
                    }
                });
        });
    </script>
</x-app-layout>
