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
                                <option value="{{ $d->id }}" data-type="{{ $d->scoring_type }}">
                                    {{ $d->name }}</option>
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
                <style>
                    .ck-editor__editable {
                        min-height: 200px;
                        border: 1px solid #d1d5db !important;
                        border-radius: 0.375rem !important;
                    }

                    .ck.ck-toolbar {
                        border: 1px solid #d1d5db !important;
                        border-radius: 0.375rem !important;
                    }

                    .option-editor .ck-editor__editable {
                        min-height: 100px;
                    }
                </style>

                <div class="mb-4" id="question-container">
                    <label for="editor" class="block text-gray-700 font-medium">Question</label>
                    <div id="editor" class="mt-1"></div>
                    <input type="hidden" name="question" id="question">
                    <div id="question-error" class="text-red-500 text-sm mt-1 hidden">Please enter a question</div>
                </div>

                <!-- MCA Options Container (Initially Hidden) -->
                <div id="mca-options-container" class="mb-4 hidden">
                    <label class="block text-gray-700 font-medium mb-2">Options</label>
                    <div id="options-list">
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
                    </div>
                    <button type="button" onclick="addOption()"
                        class="mt-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
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
                    <a href="{{ route('question.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancel
                    </a>
                    <x-primary-button type="button" onclick="submitForm()">{{ __('Create') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script  --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/decoupled-document/ckeditor.js"></script>

    <script>
        const sectionUrlTemplate = "{{ route('domain.sections', ['id' => '__ID__']) }}";
        let optionEditors = [];
        let mainEditor;

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
                            url: '{{ route('ckeditor.upload') }}',
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

        // Initialize main editor when document is ready
        $(document).ready(function() {
            // Initialize CKEditor with image upload support
            DecoupledEditor
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
                            'uploadImage',
                            'blockQuote',
                            'insertTable',
                            'undo',
                            'redo'
                        ]
                    },
                    image: {
                        toolbar: [
                            'imageStyle:inline',
                            'imageStyle:block',
                            'imageStyle:side',
                            '|',
                            'toggleImageCaption',
                            'imageTextAlternative',
                            '|',
                            'resizeImage'
                        ],
                        resizeUnit: '%',
                        resizeOptions: [{
                            name: 'resizeImage:original',
                            value: null,
                            icon: 'original'
                        },
                        {
                            name: 'resizeImage:50',
                            value: '50',
                            icon: 'medium'
                        },
                        {
                            name: 'resizeImage:75',
                            value: '75',
                            icon: 'large'
                        }]
                    }
                })
                .then(editor => {
                    mainEditor = editor;
                    const toolbarContainer = document.querySelector('#editor');
                    toolbarContainer.parentNode.insertBefore(
                        editor.ui.view.toolbar.element,
                        toolbarContainer
                    );
                })
                .catch(error => {
                    console.error(error);
                });

            // Initialize the first option editor
            const firstOptionEditor = document.querySelector('.option-editor');
            if (firstOptionEditor) {
                initializeOptionEditor(firstOptionEditor);
            }
        });

        async function initializeOptionEditor(editorElement) {
            try {
                const editor = await DecoupledEditor.create(editorElement, {
                    extraPlugins: [uploadPlugin],
                    toolbar: {
                        items: [
                            'bold',
                            'italic',
                            'link',
                            '|',
                            'uploadImage',
                            'undo',
                            'redo'
                        ]
                    },
                    image: {
                        toolbar: [
                            'imageStyle:inline',
                            'imageStyle:block',
                            'imageStyle:side',
                            '|',
                            'toggleImageCaption',
                            'imageTextAlternative',
                            '|',
                            'resizeImage'
                        ],
                        resizeUnit: '%',
                        resizeOptions: [{
                            name: 'resizeImage:original',
                            value: null,
                            icon: 'original'
                        },
                        {
                            name: 'resizeImage:50',
                            value: '50',
                            icon: 'medium'
                        },
                        {
                            name: 'resizeImage:75',
                            value: '75',
                            icon: 'large'
                        }]
                    }
                });

                // Store the editor instance
                optionEditors.push(editor);
                
                // Handle the toolbar placement
                const toolbarContainer = editorElement;
                toolbarContainer.parentNode.insertBefore(
                    editor.ui.view.toolbar.element,
                    toolbarContainer
                );
                
                // Update hidden input when content changes
                editor.model.document.on('change:data', () => {
                    const inputField = editorElement.nextElementSibling;
                    if (inputField) {
                        inputField.value = editor.getData();
                    }
                });

                return editor;
            } catch (error) {
                console.error('Error initializing option editor:', error);
            }
        }

        function submitForm() {
            if (!mainEditor) {
                console.error('Editor not initialized');
                return;
            }

            const questionContent = mainEditor.getData();
            if (!questionContent.trim()) {
                document.getElementById('question-error').classList.remove('hidden');
                return;
            }
            
            document.getElementById('question-error').classList.add('hidden');
            document.getElementById('question').value = questionContent;
            
            // Update all option values before submitting
            optionEditors.forEach((editor, index) => {
                if (editor) {
                    const optionContent = editor.getData();
                    const hiddenInput = document.querySelectorAll('.option-input')[index];
                    if (hiddenInput) {
                        hiddenInput.value = optionContent;
                    }
                }
            });
            
            document.getElementById('questionForm').submit();
        }

        // Domain change handler
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

                var url = sectionUrlTemplate.replace('__ID__', domainId);
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(sections) {
                        var options = '<option value="">Select Section</option>';
                        $.each(sections, function(id, name) {
                            options += '<option value="' + id + '">' + name + '</option>';
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
