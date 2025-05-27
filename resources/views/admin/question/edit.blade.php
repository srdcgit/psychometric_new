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

                <div class="mb-4" id="question-container">
                    <label for="editor" class="block text-sm font-medium text-gray-700">Question</label>
                    <div id="editor">{!! old('question', $question->question) !!}</div>
                    <input type="hidden" name="question" id="question">
                </div>

                <!-- MCA Options Container -->
                <div id="mca-options-container"
                    class="mb-4 {{ $question->domain->scoring_type === 'mcq' ? '' : 'hidden' }}">
                    <label class="block text-gray-700 font-medium mb-2">Options</label>
                    <div id="options-list">
                        @if ($question->options->count() > 0)
                            @foreach ($question->options as $index => $option)
                                <div class="option-item mb-2">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="flex-1">
                                            <div class="option-editor">{!! $option->option_text !!}</div>
                                            <input type="hidden" name="options[]" class="option-input" value="{{ $option->option_text }}">
                                        </div>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="correct_option" value="{{ $index }}"
                                                {{ $option->is_correct ? 'checked' : '' }} required>
                                            <span class="ml-2">Correct</span>
                                        </label>
                                        <button type="button"
                                            class="remove-option px-2 py-1 text-red-600 hover:text-red-800"
                                            onclick="removeOption(this)">×</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="option-item mb-2">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="flex-1">
                                        <div class="option-editor"></div>
                                        <input type="hidden" name="options[]" class="option-input">
                                    </div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="correct_option" value="0" required>
                                        <span class="ml-2">Correct</span>
                                    </label>
                                    <button type="button" class="remove-option px-2 py-1 text-red-600 hover:text-red-800"
                                        onclick="removeOption(this)">×</button>
                                </div>
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
                        {{ $question->is_reverse ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700' }}"
                        onclick="toggleIsReverse()">
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
                    <button type="submit" onclick="submitForm(); return false;" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Update Question
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    
    <script>
        class UploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file.then(file => {
                    return new Promise((resolve, reject) => {
                        const formData = new FormData();
                        formData.append('image', file);

                        $.ajax({
                            url: '{{ route("ckeditor.upload") }}',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                resolve({
                                    default: response.url
                                });
                            },
                            error: function(response) {
                                reject(response.responseText);
                            }
                        });
                    });
                });
            }

            abort() {
                // Abort upload if needed
            }
        }

        function uploadPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new UploadAdapter(loader);
            };
        }

        let editor;
        let optionEditors = [];

        // Initialize CKEditor for the main question
        ClassicEditor
            .create(document.querySelector('#editor'), {
                extraPlugins: [uploadPlugin],
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'imageUpload',
                        'blockQuote',
                        'insertTable',
                        'undo',
                        'redo'
                    ]
                }
            })
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });

        // Function to initialize CKEditor for an option
        function initializeOptionEditor(editorElement) {
            return ClassicEditor
                .create(editorElement, {
                    extraPlugins: [uploadPlugin],
                    toolbar: {
                        items: [
                            'bold',
                            'italic',
                            'link',
                            '|',
                            'imageUpload',
                            'undo',
                            'redo'
                        ]
                    }
                })
                .then(editor => {
                    // Store the editor instance
                    optionEditors.push(editor);
                    
                    // Update hidden input when content changes
                    editor.model.document.on('change:data', () => {
                        const inputField = editorElement.nextElementSibling;
                        inputField.value = editor.getData();
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        }

        // Initialize all option editors when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            const optionEditorElements = document.querySelectorAll('.option-editor');
            optionEditorElements.forEach(editorElement => {
                initializeOptionEditor(editorElement);
            });
        });

        function addOption() {
            const optionsList = document.getElementById('options-list');
            const newOption = document.createElement('div');
            const optionCount = optionsList.children.length;
            
            newOption.className = 'option-item mb-2';
            newOption.innerHTML = `
                <div class="flex items-center gap-2 mb-2">
                    <div class="flex-1">
                        <div class="option-editor"></div>
                        <input type="hidden" name="options[]" class="option-input">
                    </div>
                    <label class="inline-flex items-center">
                        <input type="radio" name="correct_option" value="${optionCount}" required>
                        <span class="ml-2">Correct</span>
                    </label>
                    <button type="button" class="remove-option px-2 py-1 text-red-600 hover:text-red-800" onclick="removeOption(this)">×</button>
                </div>
            `;
            
            optionsList.appendChild(newOption);
            
            // Initialize CKEditor for the new option
            const newEditorElement = newOption.querySelector('.option-editor');
            initializeOptionEditor(newEditorElement);
        }

        function removeOption(button) {
            const optionItem = button.closest('.option-item');
            const optionsList = optionItem.parentElement;
            
            if (optionsList.children.length > 1) {
                // Find and destroy the CKEditor instance
                const editorElement = optionItem.querySelector('.option-editor');
                const editorIndex = Array.from(optionsList.querySelectorAll('.option-editor')).indexOf(editorElement);
                if (editorIndex !== -1) {
                    optionEditors[editorIndex].destroy()
                        .then(() => {
                            optionEditors.splice(editorIndex, 1);
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
                
                optionItem.remove();
                
                // Update radio button values
                Array.from(optionsList.children).forEach((item, index) => {
                    item.querySelector('input[type="radio"]').value = index;
                });
            }
        }

        function submitForm() {
            // Get the question content
            const questionContent = editor.getData();
            document.getElementById('question').value = questionContent;
            
            // Update all option values before submitting
            optionEditors.forEach((editor, index) => {
                const optionContent = editor.getData();
                const hiddenInput = document.querySelectorAll('.option-input')[index];
                hiddenInput.value = optionContent;
            });
            
            document.getElementById('questionForm').submit();
        }

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

</x-app-layout>
