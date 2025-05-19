<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Create Section</h2>
    </x-slot>

    <div class="py-10 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded p-6">
            <form method="POST" action="{{ route('section.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium">Name</label>
                    <input type="text" name="name" id="name" required
                        class="w-full border rounded px-3 py-2 mt-1">
                </div>

                <div class="mb-4">
                    <label for="domain_id" class="block text-gray-700 font-medium">Domain</label>
                    <select name="domain_id" id="domain_id" required class="w-full border rounded px-3 py-2 mt-1">
                        <option value="">Select Domain</option>
                        @foreach ($domains as $domain)
                            <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="keytraits" class="block text-gray-700 font-medium">Key Traits</label>
                    <textarea name="keytraits" id="keytraits" rows="3" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                </div>

                <div class="mb-4">
                    <label for="enjoys" class="block text-gray-700 font-medium">Enjoys</label>
                    <textarea name="enjoys" id="enjoys" rows="3" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                </div>

                <div class="mb-4">
                    <label for="idealenvironments" class="block text-gray-700 font-medium">Ideal Environments</label>
                    <textarea name="idealenvironments" id="idealenvironments" rows="3" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium">Description</label>
                    <textarea name="description" id="description" rows="3" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                </div>

                <x-primary-button>{{ __('Create') }}</x-primary-button>
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
