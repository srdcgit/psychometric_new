<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Career Categories</h2>
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

            <form action="{{ route('careercategory.update', $career->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Section Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $career->name) }}"
                           class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div> --}}

                {{-- <div class="mb-4">
                    <label for="section_id" class="block text-sm font-medium text-gray-700">Domain</label>
                    <select name="section_id" id="section_id" required
                            class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Domain</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}"
                                {{ old('section_id', $career->section_id) == $section->id ? 'selected' : '' }}>
                                {{ $section->name }}
                            </option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Career Category Name</label>
                    <textarea name="name" id="name" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('name', $career->name) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="hook" class="block text-sm font-medium text-gray-700">Hook</label>
                    <textarea name="hook" id="hook" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('hook', $career->hook) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="what_is_it" class="block text-sm font-medium text-gray-700">What is it?</label>
                    <textarea name="what_is_it" id="what_is_it" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('what_is_it', $career->what_is_it) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="example_roles" class="block text-sm font-medium text-gray-700">Example roles</label>
                    <textarea name="example_roles" id="example_roles" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('example_roles', $career->example_roles) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="subjects" class="block text-sm font-medium text-gray-700">Subjects</label>
                    <textarea name="subjects" id="subjects" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('subjects', $career->subjects) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="core_apptitudes_to_highlight" class="block text-sm font-medium text-gray-700">Core aptitudes to highlight</label>
                    <textarea name="core_apptitudes_to_highlight" id="core_apptitudes_to_highlight" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('core_apptitudes_to_highlight', $career->core_apptitudes_to_highlight) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="value_and_personality_edge" class="block text-sm font-medium text-gray-700">Value and personality edge</label>
                    <textarea name="value_and_personality_edge" id="value_and_personality_edge" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('value_and_personality_edge', $career->value_and_personality_edge) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="why_it_could_fit_you" class="block text-sm font-medium text-gray-700">Why it could fit you</label>
                    <textarea name="why_it_could_fit_you" id="why_it_could_fit_you" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('why_it_could_fit_you', $career->why_it_could_fit_you) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="early_actions" class="block text-sm font-medium text-gray-700">Early actions</label>
                    <textarea name="early_actions" id="early_actions" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('early_actions', $career->early_actions) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="india_study_pathways" class="block text-sm font-medium text-gray-700">India study pathways</label>
                    <textarea name="india_study_pathways" id="india_study_pathways" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('india_study_pathways', $career->india_study_pathways) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="future_trends" class="block text-sm font-medium text-gray-700">Future trends</label>
                    <textarea name="future_trends" id="future_trends" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('future_trends', $career->future_trends) }}</textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('careercategory.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Update Career Category
                    </button>
                </div>
            </form>
        </div>
    </div>

     <!-- CKEditor 5 Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        const editorIds = [
            '#name',
            '#hook',
            '#what_is_it',
            '#example_roles',
            '#subjects',
            '#core_apptitudes_to_highlight',
            '#value_and_personality_edge',
            '#why_it_could_fit_you',
            '#early_actions',
            '#india_study_pathways',
            '#future_trends'
        ];
        editorIds.forEach((selector) => {
            const el = document.querySelector(selector);
            if (el) {
                ClassicEditor.create(el).catch(console.error);
            }
        });
    </script>
</x-app-layout>
