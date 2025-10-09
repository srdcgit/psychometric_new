@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="mb-4 fw-bold">Edit Question</h2>

    <style>
        .ck-editor__editable {
            min-height: 200px;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
        }
        .ck.ck-toolbar {
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
        }
        .option-editor .ck-editor__editable {
            min-height: 100px;
        }
    </style>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('question.update', $question->id) }}" method="POST" id="questionForm">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="domain_id" class="form-label">Domain</label>
                    <select name="domain_id" id="domain_id" class="form-select" required>
                        <option value="">Select Domain</option>
                        @foreach ($domains as $domain)
                            <option value="{{ $domain->id }}" data-type="{{ $domain->scoring_type }}"
                                {{ old('domain_id', $question->domain_id) == $domain->id ? 'selected' : '' }}>
                                {{ $domain->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="section_id" class="form-label">Section</label>
                    <select name="section_id" id="section_id" class="form-select" required>
                        <option value="">Select Section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}"
                                {{ old('section_id', $question->section_id) == $section->id ? 'selected' : '' }}>
                                {{ $section->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="editor" class="form-label">Question</label>
                    <div id="editor">{!! old('question', $question->question) !!}</div>
                    <input type="hidden" name="question" id="question">
                </div>

                <!-- MCQ Options -->
                <div id="mca-options-container" class="mb-3 {{ $question->domain->scoring_type === 'mcq' ? '' : 'd-none' }}">
                    <label class="form-label">Options</label>
                    <div id="options-list">
                        @if ($question->options->count() > 0)
                            @foreach ($question->options as $index => $option)
                                <div class="option-item mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="flex-grow-1">
                                            <div class="option-editor">{!! $option->option_text !!}</div>
                                            <input type="hidden" name="options[]" class="option-input" value="{{ $option->option_text }}">
                                        </div>
                                        <div class="form-check me-2">
                                            <input class="form-check-input" type="radio" name="correct_option" value="{{ $index }}"
                                                {{ $option->is_correct ? 'checked' : '' }} required>
                                            <label class="form-check-label">Correct</label>
                                        </div>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeOption(this)">×</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="option-item mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="flex-grow-1">
                                        <div class="option-editor"></div>
                                        <input type="hidden" name="options[]" class="option-input">
                                    </div>
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="radio" name="correct_option" value="0" required>
                                        <label class="form-check-label">Correct</label>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeOption(this)">×</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" onclick="addOption()" class="btn btn-secondary btn-sm mt-2">+ Add Option</button>
                </div>

                <!-- Reverse Toggle -->
                <div class="mb-3">
                    <label class="form-label">Is Reverse?</label>
                    <div>
                        <button type="button" id="toggleButton" class="btn {{ $question->is_reverse ? 'btn-primary' : 'btn-secondary' }}" onclick="toggleIsReverse()">
                            {{ $question->is_reverse ? 'Yes' : 'No' }}
                        </button>
                        <input type="hidden" name="is_reverse" id="is_reverse" value="{{ old('is_reverse', $question->is_reverse ?? 0) }}">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('question.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" onclick="submitForm(); return false;" class="btn btn-primary">Update Question</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- JS Scripts remain the same -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/decoupled-document/ckeditor.js"></script>

{{-- Keep your existing JS/AJAX logic for CKEditor, option add/remove, toggle --}}

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
                        }
                    ]
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

        // Initialize all existing option editors
        const optionEditorElements = document.querySelectorAll('.option-editor');
        optionEditorElements.forEach(editorElement => {
            initializeOptionEditor(editorElement);
        });
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
                        }
                    ]
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
            alert('Please enter a question');
            return;
        }

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
@endsection
