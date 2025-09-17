<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Create Career Categories</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4">
            <form method="POST" action="{{ route('careercategory.store') }}">
            @csrf

            {{-- <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div> --}}

            

            <div class="mt-4">
                <x-input-label for="name" :value="__('Career Category Name')" />
                <textarea id="name" name="name" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-input-label for="hook" :value="__('Hook')" />
                <textarea id="hook" name="hook" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-input-label for="what_is_it" :value="__('What is it?')" />
                <textarea id="what_is_it" name="what_is_it" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-input-label for="example_roles" :value="__('Example roles')" />
                <textarea id="example_roles" name="example_roles" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-input-label for="subjects" :value="__('Subjects')" />
                <textarea id="subjects" name="subjects" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-input-label for="core_apptitudes_to_highlight" :value="__('Core aptitudes to highlight')" />
                <textarea id="core_apptitudes_to_highlight" name="core_apptitudes_to_highlight" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-input-label for="value_and_personality_edge" :value="__('Value and personality edge')" />
                <textarea id="value_and_personality_edge" name="value_and_personality_edge" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-input-label for="why_it_could_fit_you" :value="__('Why it could fit you')" />
                <textarea id="why_it_could_fit_you" name="why_it_could_fit_you" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-input-label for="early_actions" :value="__('Early actions')" />
                <textarea id="early_actions" name="early_actions" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-input-label for="india_study_pathways" :value="__('India study pathways')" />
                <textarea id="india_study_pathways" name="india_study_pathways" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-input-label for="future_trends" :value="__('Future trends')" />
                <textarea id="future_trends" name="future_trends" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-primary-button>{{ __('Create') }}</x-primary-button>
            </div>
        </form>
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
