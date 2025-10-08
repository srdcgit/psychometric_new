@extends('layouts.app')

@section('content')
<style>
    /* Header */
    .header-gradient {
        background: linear-gradient(90deg, #4f46e5, #06b6d4);
        color: #fff;
        border-radius: 1rem;
        padding: 1.75rem;
        text-align: center;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    /* Card */
    .card-glass {
        background: #fff;
        border-radius: 1rem;
        padding: 2rem 2.5rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid #f3f4f6;
    }

    /* CKEditor */
    .ck-editor__editable {
        min-height: 200px;
        border: 1px solid #e5e7eb !important;
        border-radius: 0.5rem !important;
        background: #f9fafb;
    }

    .ck.ck-toolbar {
        border: 1px solid #e5e7eb !important;
        border-radius: 0.5rem !important;
        background: #f9fafb;
    }

    .option-editor .ck-editor__editable {
        min-height: 100px;
    }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(90deg, #4f46e5, #06b6d4);
        color: white;
        padding: 0.6rem 1.4rem;
        border-radius: 0.6rem;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        opacity: 0.95;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        padding: 0.6rem 1.4rem;
        border-radius: 0.6rem;
        border: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
        transform: translateY(-2px);
    }

    /* Option items */
    .option-item {
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1rem;
        background: #f9fafb;
        transition: all 0.2s ease;
    }

    .option-item:hover {
        background: #f3f4f6;
    }

    .remove-option {
        background: #fee2e2;
        border: none;
        color: #dc2626;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        border-radius: 0.4rem;
        width: 28px;
        height: 28px;
        line-height: 0;
        transition: all 0.2s ease;
    }

    .remove-option:hover {
        background: #dc2626;
        color: white;
    }

    /* Toggle */
    #toggleButton {
        min-width: 80px;
        transition: all 0.3s ease;
    }

    #toggleButton.active {
        background: linear-gradient(90deg, #4f46e5, #06b6d4);
        color: white;
    }

    /* Input / Select */
    select, input[type="text"], input[type="number"] {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        background-color: #f9fafb;
        transition: border-color 0.2s;
    }

    select:focus, input:focus {
        outline: none;
        border-color: #4f46e5;
        background-color: white;
    }
</style>


<div class="header-gradient">
    <h2 class="text-2xl font-semibold">Add Question</h2>
</div>

<div class="max-w-3xl mx-auto">
    <div class="card-glass">
        <form method="POST" action="{{ route('question.store') }}" id="questionForm">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="domain_id" class="block text-gray-700 font-medium">Domain</label>
                    <select name="domain_id" id="domain_id" required class="w-full border rounded px-3 py-2 mt-1">
                        <option value="">Select Domain</option>
                        @foreach ($domains as $d)
                            <option value="{{ $d->id }}" data-type="{{ $d->scoring_type }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="section_id" class="block text-gray-700 font-medium">Section</label>
                    <select name="section_id" id="section_id" required class="w-full border rounded px-3 py-2 mt-1">
                        <option value="">Select Section</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium">Question</label>
                <div id="editor" class="mt-2"></div>
                <input type="hidden" name="question" id="question">
                <div id="question-error" class="text-red-500 text-sm mt-1 hidden">Please enter a question</div>
            </div>

            <!-- MCA Options Section -->
            <div id="mca-options-container" class="mb-6 hidden">
                <label class="block text-gray-700 font-medium mb-2">Options</label>
                <div id="options-list">
                    <div class="option-item mb-4">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex-1">
                                <div class="option-editor"></div>
                                <input type="hidden" name="options[]" class="option-input">
                            </div>
                            <label class="inline-flex items-center">
                                <input type="radio" name="correct_option" value="0" required>
                                <span class="ml-2">Correct</span>
                            </label>
                            <button type="button" class="remove-option" onclick="removeOption(this)">×</button>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addOption()" class="btn-secondary mt-2">+ Add Option</button>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Is Reverse?</label>
                <button type="button" id="toggleButton" class="btn-secondary" onclick="toggleIsReverse()">No</button>
                <input type="hidden" name="is_reverse" id="is_reverse" value="0">
            </div>

            <div class="flex justify-center gap-4">
                <a href="{{ route('question.index') }}" class="btn-secondary">Cancel</a>
                <button type="button" onclick="submitForm()" class="btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>

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
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            const formData = new FormData();
            formData.append('image', file);
            $.ajax({
                url: '{{ route('ckeditor.upload') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: res => resolve({ default: res.url }),
                error: err => reject(err.responseText)
            });
        }));
    }
}

function uploadPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = loader => new UploadAdapter(loader);
}

$(document).ready(() => {
    // Initialize main CKEditor
    DecoupledEditor.create(document.querySelector('#editor'), {
        extraPlugins: [uploadPlugin],
        toolbar: { items: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'uploadImage', 'undo', 'redo'] }
    }).then(editor => {
        mainEditor = editor;
        const toolbarContainer = document.querySelector('#editor');
        toolbarContainer.parentNode.insertBefore(editor.ui.view.toolbar.element, toolbarContainer);
    });

    // First option editor
    initializeOptionEditor(document.querySelector('.option-editor'));

    $('#domain_id').on('change', function() {
        const domainId = $(this).val();
        const type = $(this).find(':selected').data('type');
        if (type === 'mcq') $('#mca-options-container').removeClass('hidden');
        else $('#mca-options-container').addClass('hidden');
        loadSections(domainId);
    });
});

async function initializeOptionEditor(editorElement) {
    const editor = await DecoupledEditor.create(editorElement, {
        extraPlugins: [uploadPlugin],
        toolbar: { items: ['bold', 'italic', 'link', '|', 'uploadImage', 'undo', 'redo'] }
    });
    optionEditors.push(editor);
    const toolbarContainer = editorElement;
    toolbarContainer.parentNode.insertBefore(editor.ui.view.toolbar.element, toolbarContainer);
    editor.model.document.on('change:data', () => {
        const inputField = editorElement.nextElementSibling;
        if (inputField) inputField.value = editor.getData();
    });
}

function loadSections(domainId) {
    const $sectionSelect = $('#section_id');
    if (!domainId) return $sectionSelect.html('<option value="">Select Section</option>');
    $sectionSelect.html('<option>Loading...</option>');
    $.get(sectionUrlTemplate.replace('__ID__', domainId), sections => {
        let options = '<option value="">Select Section</option>';
        sections.forEach(s => options += `<option value="${s.id}">${s.name}</option>`);
        $sectionSelect.html(options);
    });
}

function addOption() {
    const optionsList = $('#options-list');
    const index = optionsList.children().length;
    const html = `
        <div class="option-item mb-4">
            <div class="flex items-center gap-2 mb-2">
                <div class="flex-1">
                    <div class="option-editor"></div>
                    <input type="hidden" name="options[]" class="option-input">
                </div>
                <label class="inline-flex items-center">
                    <input type="radio" name="correct_option" value="${index}" required>
                    <span class="ml-2">Correct</span>
                </label>
                <button type="button" class="remove-option" onclick="removeOption(this)">×</button>
            </div>
        </div>`;
    optionsList.append(html);
    initializeOptionEditor(optionsList.find('.option-editor').last()[0]);
}

function removeOption(btn) {
    const option = $(btn).closest('.option-item');
    if ($('#options-list .option-item').length > 1) option.remove();
}

function toggleIsReverse() {
    const btn = $('#toggleButton');
    const input = $('#is_reverse');
    if (input.val() === '1') {
        input.val('0');
        btn.text('No').removeClass('bg-blue-600 text-white').addClass('btn-secondary');
    } else {
        input.val('1');
        btn.text('Yes').removeClass('btn-secondary').addClass('bg-blue-600 text-white');
    }
}

function submitForm() {
    const question = mainEditor.getData();
    if (!question.trim()) return $('#question-error').removeClass('hidden');
    $('#question').val(question);
    $('#questionForm').submit();
}
</script>
@endsection
