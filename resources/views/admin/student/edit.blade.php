<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Student') }}
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
            <form method="POST" action="{{ route('students.update', $student->id) }}">
                @csrf
                @method('PUT')
                <!-- Institution -->
                <div class="mt-4">
                    <x-input-label for="register_institute_id" :value="__('Register Institution')" />
                    <select id="register_institute_id" name="register_institute_id"
                        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Select Institution --</option>
                        @foreach ($institutes as $institute)
                            <option value="{{ $institute->id }}"
                                {{ old('register_institute_id', $student->register_institute_id) == $institute->id ? 'selected' : '' }}>
                                {{ $institute->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('register_institute_id')" class="mt-2" />
                </div>

                <!-- Name -->
                <div class="mt-4">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name', $student->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email', $student->email)" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Age -->
                <div class="mt-4">
                    <x-input-label for="age" :value="__('Age')" />
                    <x-text-input id="age" class="block mt-1 w-full" type="number" name="age"
                        :value="old('age', $student->age)" required />
                    <x-input-error :messages="$errors->get('age')" class="mt-2" />
                </div>

                <!-- Class -->
                <div class="mt-4">
                    <x-input-label for="class" :value="__('Class')" />
                    <x-text-input id="class" class="block mt-1 w-full" type="text" name="class"
                        :value="old('class', $student->class)" required />
                    <x-input-error :messages="$errors->get('class')" class="mt-2" />
                </div>

                <!-- School -->
                <div class="mt-4">
                    <x-input-label for="school" :value="__('School')" />
                    <x-text-input id="school" class="block mt-1 w-full" type="text" name="school"
                        :value="old('school', $student->school)" required />
                    <x-input-error :messages="$errors->get('school')" class="mt-2" />
                </div>

                <!-- Location -->
                <div class="mt-4">
                    <x-input-label for="location" :value="__('Location')" />
                    <x-text-input id="location" class="block mt-1 w-full" type="text" name="location"
                        :value="old('location', $student->location)" required />
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>

                <!-- Subjects Stream -->
                <div class="mt-4">
                    <x-input-label for="subjects_stream" :value="__('Subjects/Stream')" />
                    <x-text-input id="subjects_stream" class="block mt-1 w-full" type="text" name="subjects_stream"
                        :value="old('subjects_stream', $student->subjects_stream)" required />
                    <x-input-error :messages="$errors->get('subjects_stream')" class="mt-2" />
                </div>

                <!-- Career Aspiration -->
                <div class="mt-4">
                    <x-input-label for="career_aspiration" :value="__('Career Aspiration')" />
                    <x-text-input id="career_aspiration" class="block mt-1 w-full" type="text"
                        name="career_aspiration" :value="old('career_aspiration', $student->career_aspiration)" />
                    <x-input-error :messages="$errors->get('career_aspiration')" class="mt-2" />
                </div>

                <!-- Parental Occupation -->
                <div class="mt-4">
                    <x-input-label for="parental_occupation" :value="__('Parental Occupation')" />
                    <x-text-input id="parental_occupation" class="block mt-1 w-full" type="text"
                        name="parental_occupation" :value="old('parental_occupation', $student->parental_occupation)" />
                    <x-input-error :messages="$errors->get('parental_occupation')" class="mt-2" />
                </div>

                <!-- Submit -->
                <div class="mt-4">
                    <x-primary-button>{{ __('Update') }}</x-primary-button>
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
