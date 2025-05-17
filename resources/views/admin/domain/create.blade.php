<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Create Domain</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4">
        <form method="POST" action="{{ route('domain.store') }}">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="scoring_type" :value="__('Scoring Type')" />

                <select name="scoring_type" id="scoring_type" required>
                    <option value="">Select Option</option>
                    <option value="likert">Likert</option>
                    <option value="likert2">Likert 2</option>
                    <option value="objective">Objective</option>
                </select>
            </div>

            <div class="mt-4">
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-primary-button>{{ __('Create') }}</x-primary-button>
            </div>
        </form>
    </div>

    <!-- CKEditor 5 Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>


</x-app-layout>
