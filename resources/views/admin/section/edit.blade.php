<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Section</h2>
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

            <form action="{{ route('section.update', $section->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Section Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $section->name) }}"
                           class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="domain_id" class="block text-sm font-medium text-gray-700">Domain</label>
                    <select name="domain_id" id="domain_id" required
                            class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Domain</option>
                        @foreach ($domains as $domain)
                            <option value="{{ $domain->id }}"
                                {{ old('domain_id', $section->domain_id) == $domain->id ? 'selected' : '' }}>
                                {{ $domain->name }}
                            </option>
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
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $section->description) }}</textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('section.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Update Section
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
