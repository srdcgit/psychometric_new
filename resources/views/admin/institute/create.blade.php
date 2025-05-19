<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Create Institute</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4">
        <form method="POST" action="{{ route('institute.store') }}">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="address" :value="__('Address')" />
                <x-text-input id="address" name="address" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="mobile" :value="__('Mobile')" />
                <x-text-input id="mobile" type="number"  name="mobile" class="mt-1 block w-full" maxlength="12" required />
                <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
            </div>

              <div>
                <x-input-label for="allowedstudents" :value="__('Allowed Student')" />
                <x-text-input id="allowedstudents" type="number"  name="allowed_students" class="mt-1 block w-full" maxlength="12" required />
                <x-input-error :messages="$errors->get('allowed_students')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="contactperson" :value="__('Contact Person')" />
                <textarea id="contactperson" name="contact_person" class="block w-full mt-1 rounded"></textarea>
            </div>

            <div class="mt-4">
                <x-primary-button>{{ __('Create') }}</x-primary-button>
            </div>
        </form>
    </div>

</x-app-layout>
