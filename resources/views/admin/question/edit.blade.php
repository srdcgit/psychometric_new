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

            <form action="{{ route('question.update', $question->id) }}" method="POST" id="questionForm">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="domain_id" class="block text-sm font-medium text-gray-700">Domain</label>
                    <select name="domain_id" id="domain_id" class="mt-1 block w-full rounded border-gray-300" required>
                        <option value="">Select Domain</option>
                        @foreach ($domains as $domain)
                            <option value="{{ $domain->id }}" data-type="{{ $domain->scoring_type }}"
                                {{ old('domain_id', $question->domain_id) == $domain->id ? 'selected' : '' }}>
                                {{ $domain->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="section_id" class="block text-sm font-medium text-gray-700">Section</label>
                    <select name="section_id" id="section_id" class="mt-1 block w-full rounded border-gray-300"
                        required>
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
                    <textarea name="question" id="questions" rows="4"
                        class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-500 sm:text-sm" required>{{ old('question', $question->question) }}</textarea>
                </div>

                <!-- MCA Options Container -->
                <div id="mca-options-container"
                    class="mb-4 {{ $question->domain->scoring_type === 'mcq' ? '' : 'hidden' }}">
                    <label class="block text-gray-700 font-medium mb-2">Options</label>
                    <div id="options-list">
                        @if ($question->options->count() > 0)
                            @foreach ($question->options as $index => $option)
                                <div class="option-item mb-2 flex items-center gap-2">
                                    <input type="text" name="options[]" class="flex-1 border rounded px-3 py-2"
                                        placeholder="Option text" required value="{{ $option->option_text }}">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="correct_option" value="{{ $index }}"
                                            {{ $option->is_correct ? 'checked' : '' }} required>
                                        <span class="ml-2">Correct</span>
                                    </label>
                                    <button type="button"
                                        class="remove-option px-2 py-1 text-red-600 hover:text-red-800"
                                        onclick="removeOption(this)">×</button>
                                </div>
                            @endforeach
                        @else
                            <div class="option-item mb-2 flex items-center gap-2">
                                <input type="text" name="options[]" class="flex-1 border rounded px-3 py-2"
                                    placeholder="Option text" required>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="correct_option" value="0" required>
                                    <span class="ml-2">Correct</span>
                                </label>
                                <button type="button" class="remove-option px-2 py-1 text-red-600 hover:text-red-800"
                                    onclick="removeOption(this)">×</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" onclick="addOption()"
                        class="mt-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        + Add Option
                    </button>
                </div>

                <div class="mb-4">
                    <label for="is_reverse" class="block text-gray-700 font-medium mb-1">Is Reverse?</label>
                    <button type="button" id="toggleButton"
                        class="px-4 py-2 rounded 
                        {{ $question->is_reverse ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700' }}">
                        {{ $question->is_reverse ? 'Yes' : 'No' }}
                    </button>
                    <input type="hidden" name="is_reverse" id="is_reverse"
                        value="{{ old('is_reverse', $question->is_reverse ?? 0) }}">
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('question.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Update Question
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Handle domain change
        document.getElementById('domain_id').addEventListener('change', function() {
            const scoringType = this.options[this.selectedIndex].getAttribute('data-type');
            const mcaContainer = document.getElementById('mca-options-container');

            if (scoringType === 'mcq') {
                mcaContainer.classList.remove('hidden');
            } else {
                mcaContainer.classList.add('hidden');
            }
        });

        function addOption() {
            const optionsList = document.getElementById('options-list');
            const newOption = document.createElement('div');
            const optionCount = optionsList.children.length;

            newOption.className = 'option-item mb-2 flex items-center gap-2';
            newOption.innerHTML = `
                <input type="text" name="options[]" class="flex-1 border rounded px-3 py-2" placeholder="Option text" required>
                <label class="inline-flex items-center">
                    <input type="radio" name="correct_option" value="${optionCount}" required>
                    <span class="ml-2">Correct</span>
                </label>
                <button type="button" class="remove-option px-2 py-1 text-red-600 hover:text-red-800" onclick="removeOption(this)">×</button>
            `;

            optionsList.appendChild(newOption);
        }

        function removeOption(button) {
            const optionItem = button.parentElement;
            const optionsList = optionItem.parentElement;

            if (optionsList.children.length > 1) {
                optionItem.remove();
                // Update radio button values
                Array.from(optionsList.children).forEach((item, index) => {
                    item.querySelector('input[type="radio"]').value = index;
                });
            }
        }

        function toggleIsReverse() {
            const button = document.getElementById('toggleButton');
            const input = document.getElementById('is_reverse');
            const isOn = input.value === '1';

            if (isOn) {
                input.value = '0';
                button.textContent = 'No';
                button.classList.remove('bg-blue-600', 'text-white');
                button.classList.add('bg-gray-300', 'text-gray-700');
            } else {
                input.value = '1';
                button.textContent = 'Yes';
                button.classList.remove('bg-gray-300', 'text-gray-700');
                button.classList.add('bg-blue-600', 'text-white');
            }
        }

        // Optional: Load sections dynamically on domain change
        document.getElementById('domain_id').addEventListener('change', function() {
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

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#questions'))
            .catch(error => {
                console.error(error);
            });
    </script>

</x-app-layout>
