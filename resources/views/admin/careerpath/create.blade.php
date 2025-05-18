<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Create Careers</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4">
        <form method="POST" action="{{ route('careerpath.store') }}">
            @csrf

            {{-- <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div> --}}

            <div class="mt-4">
                <x-input-label for="section_id" :value="__('Sections')" />

                <select name="section_id" id="section_id" required>
                    <option value="">Select Option</option>
                    @foreach ($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                   @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-input-label for="name" :value="__('Add Careers')" />
                <textarea id="name" name="name" class="block w-full mt-1 rounded"></textarea>
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
            .create(document.querySelector('#name'))
            .catch(error => {
                console.error(error);
            });
    </script>


</x-app-layout>
