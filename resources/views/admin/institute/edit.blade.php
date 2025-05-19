<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Institute') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">

            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('institute.update', $institute->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="name">Institute Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $institute->name) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="description">Contact_Person</label>
                    <textarea name="contactperson" id="contactperson"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        rows="4">{{ old('contactperson', $institute->contactperson) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="scoring_type">Scoring Type</label>
                    <select name="scoring_type" id="scoring_type" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Option</option>
                        <option value="likert"
                            {{ old('scoring_type', $institute->scoring_type) == 'likert' ? 'selected' : '' }}>Likert
                        </option>
                        <option value="likert2"
                            {{ old('scoring_type', $institute->scoring_type) == 'likert2' ? 'selected' : '' }}>Likert 2
                        </option>
                        <option value="objective"
                            {{ old('scoring_type', $institute->scoring_type) == 'objective' ? 'selected' : '' }}>Objective
                        </option>
                    </select>
                </div>


                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('institute.index') }}"
                        class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Update Institute
                    </button>
                </div>
            </form>
        </div>
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
