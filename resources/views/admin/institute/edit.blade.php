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
                

                <div class="mt-4">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" class="mt-1 block w-full"
                        value="{{ old('name', $institute->name) }}" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" class="mt-1 block w-full"
                        value="{{ old('email', $institute->email) }}" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" name="address" class="mt-1 block w-full"
                        value="{{ old('address', $institute->address) }}" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="contactperson" :value="__('Contact Person')" />
                    <x-text-input id="contactperson" name="contact_person" class="mt-1 block w-full"
                        value="{{ old('contact_person', $institute->contact_person) }}" required />
                    <x-input-error :messages="$errors->get('contact_person')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="mobile" :value="__('Mobile')" />
                    <x-text-input id="mobile" type="number" name="mobile" class="mt-1 block w-full"
                        value="{{ old('mobile', $institute->mobile) }}" maxlength="12" required />
                    <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="allowedstudents" :value="__('Allowed Students')" />
                    <x-text-input id="allowedstudents" type="number" name="allowed_students" class="mt-1 block w-full"
                        value="{{ old('allowed_students', $institute->allowed_students) }}" maxlength="12" required />
                    <x-input-error :messages="$errors->get('allowed_students')" class="mt-2" />
                </div>

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
