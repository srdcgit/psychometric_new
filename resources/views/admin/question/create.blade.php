<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Add Question</h2>
    </x-slot>

    <div class="py-10 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded p-6">
            <form method="POST" action="{{ route('question.store') }}" id="questionForm">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="domain_id" class="block text-gray-700 font-medium">Domain</label>
                        <select name="domain_id" id="domain_id" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Select Domain</option>
                            @foreach ($domains as $d)
                                <option value="{{ $d->id }}" data-type="{{ $d->scoring_type }}">{{ $d->name }}</option>
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
                <div class="mb-4" id="question-container">
                    <label for="editor" class="block text-gray-700 font-medium">Question</label>
                    <div id="editor"></div>
                    <input type="hidden" name="question" id="question">
                    <div id="question-error" class="text-red-500 text-sm mt-1 hidden">Please enter a question</div>
                </div>

                <!-- MCA Options Container (Initially Hidden) -->
                <div id="mca-options-container" class="mb-4 hidden">
                    <label class="block text-gray-700 font-medium mb-2">Options</label>
                    <div id="options-list">
                        <div class="option-item mb-2 flex items-center gap-2">
                            <input type="text" name="options[]" class="flex-1 border rounded px-3 py-2" placeholder="Option text" required>
                            <label class="inline-flex items-center">
                                <input type="radio" name="correct_option" value="0" required>
                                <span class="ml-2">Correct</span>
                            </label>
                            <button type="button" class="remove-option px-2 py-1 text-red-600 hover:text-red-800" onclick="removeOption(this)">×</button>
                        </div>
                    </div>
                    <button type="button" onclick="addOption()" class="mt-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        + Add Option
                    </button>
                </div>

                <div class="mb-4">
                    <label for="is_reverse" class="block text-gray-700 font-medium mb-1">Is Reverse ?</label>
                    <button type="button" id="toggleButton" class="bg-gray-300 text-gray-700 px-4 py-2 rounded"
                        onclick="toggleIsReverse()">
                        No
                    </button>
                    <input type="hidden" name="is_reverse" id="is_reverse" value="0">
                </div>

                <div class="mt-6 flex justify-center gap-4">
                    <button type="button" id="save-btn" class="btn btn-outline-primary">Save</button>
                    <x-primary-button type="button" onclick="submitForm()">{{ __('Create') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script  --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    
    <script>
        const sectionUrlTemplate = "{{ route('domain.sections', ['id' => '__ID__']) }}";
        let editor;

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });

        // Save button click handler
        document.getElementById('save-btn').addEventListener('click', function() {
            const questionContent = editor.getData();
            if (!questionContent.trim()) {
                document.getElementById('question-error').classList.remove('hidden');
                return;
            }
            
            document.getElementById('question-error').classList.add('hidden');
            document.getElementById('question').value = questionContent;
            
            // Add a hidden input to indicate this is a save action
            const saveInput = document.createElement('input');
            saveInput.type = 'hidden';
            saveInput.name = 'save_action';
            saveInput.value = 'save';
            document.getElementById('questionForm').appendChild(saveInput);
            
            document.getElementById('questionForm').submit();
        });

        function submitForm() {
            const questionContent = editor.getData();
            if (!questionContent.trim()) {
                document.getElementById('question-error').classList.remove('hidden');
                return;
            }
            
            document.getElementById('question-error').classList.add('hidden');
            document.getElementById('question').value = questionContent;
            document.getElementById('questionForm').submit();
        }

        $(document).ready(function() {
            $('#domain_id').on('change', function() {
                var domainId = $(this).val();
                var $sectionSelect = $('#section_id');
                var scoringType = $(this).find(':selected').data('type');
                
                // Toggle MCA options container based on domain type
                if (scoringType === 'mcq') {
                    $('#mca-options-container').removeClass('hidden');
                } else {
                    $('#mca-options-container').addClass('hidden');
                }

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
    </script>
</x-app-layout>
