<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Create Student</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4" style="width:50%">
        <form method="POST" action="{{ route('institutestudent.store') }}">
            @csrf
            <input type="hidden" name="register_institute_id" value="{{ $currentInstituteId }}">
            <!-- Name -->
            <div class="mt-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <!-- Age -->
            <div class="mt-4">
                <x-input-label for="age" :value="__('Age')" />
                <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age')"
                    required />
                <x-input-error :messages="$errors->get('age')" class="mt-2" />
            </div>

            <!-- Class -->
            <div class="mt-4">
                <x-input-label for="class" :value="__('Class')" />
                <x-text-input id="class" class="block mt-1 w-full" type="text" name="class" :value="old('class')"
                    required />
                <x-input-error :messages="$errors->get('class')" class="mt-2" />
            </div>

            <!-- School -->
            <div class="mt-4">
                <x-input-label for="school" :value="__('School')" />
                <x-text-input id="school" class="block mt-1 w-full" type="text" name="school" :value="old('school')"
                    required />
                <x-input-error :messages="$errors->get('school')" class="mt-2" />
            </div>

            <!-- Location -->
            <div class="mt-4">
                <x-input-label for="location" :value="__('Location')" />
                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')"
                    required />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>

            <!-- Subjects/Stream -->
            <div class="mt-4">
                <x-input-label for="subjects_stream" :value="__('Subjects/Stream')" />
                <x-text-input id="subjects_stream" class="block mt-1 w-full" type="text" name="subjects_stream"
                    :value="old('subjects_stream')" required />
                <x-input-error :messages="$errors->get('subjects_stream')" class="mt-2" />
            </div>

            <!-- Career Aspiration -->
            <div class="mt-4">
                <x-input-label for="career_aspiration" :value="__('Career Aspiration')" />
                <x-text-input id="career_aspiration" class="block mt-1 w-full" type="text" name="career_aspiration"
                    :value="old('career_aspiration')" />
                <x-input-error :messages="$errors->get('career_aspiration')" class="mt-2" />
            </div>

            <!-- Parental Occupation -->
            <div class="mt-4">
                <x-input-label for="parental_occupation" :value="__('Parental Occupation')" />
                <x-text-input id="parental_occupation" class="block mt-1 w-full" type="text"
                    name="parental_occupation" :value="old('parental_occupation')" />
                <x-input-error :messages="$errors->get('parental_occupation')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-primary-button>{{ __('Create') }}</x-primary-button>
            </div>
        </form>
    </div>

</x-app-layout>
