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
                            <option value="{{ $domain->name == 'OCEAN' ? 'OCEAN' : ($domain->name == 'Work Values' ? 'Work Values' : $domain->id) }}"
                                {{ old('domain_id', $section->domain->name == 'OCEAN' ? 'OCEAN' : ($section->domain->name == 'Work Values' ? 'Work Values' : $section->domain_id)) == ($domain->name == 'OCEAN' ? 'OCEAN' : ($domain->name == 'Work Values' ? 'Work Values' : $domain->id)) ? 'selected' : '' }}>
                                {{ $domain->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4" id="low-group">
                    <label for="low" class="block text-gray-700 font-medium">Low</label>
                    <textarea name="low" id="low" rows="3" class="w-full border rounded px-3 py-2 mt-1">{{ old('low', $section->low) }}</textarea>
                </div>

                <div class="mb-4" id="mid-group">
                    <label for="mid" class="block text-gray-700 font-medium">Mid</label>
                    <textarea name="mid" id="mid" rows="3" class="w-full border rounded px-3 py-2 mt-1">{{ old('mid', $section->mid) }}</textarea>
                </div>

                <div class="mb-4" id="high-group">
                    <label for="high" class="block text-gray-700 font-medium">High</label>
                    <textarea name="high" id="high" rows="3" class="w-full border rounded px-3 py-2 mt-1">{{ old('high', $section->high) }}</textarea>
                </div>

                <div class="mb-4" id="keytraits-group">
                    <label for="keytraits" class="block text-gray-700 font-medium">Key Traits</label>
                    <textarea name="keytraits" id="keytraits" rows="3" class="w-full border rounded px-3 py-2 mt-1">{{ old('keytraits', $section->keytraits) }}</textarea>
                </div>

                <div class="mb-4" id="enjoys-group">
                    <label for="enjoys" class="block text-gray-700 font-medium">Enjoys</label>
                    <textarea name="enjoys" id="enjoys" rows="3" class="w-full border rounded px-3 py-2 mt-1">{{ old('enjoys', $section->enjoys) }}</textarea>
                </div>

                <div class="mb-4" id="idealenvironments-group">
                    <label for="idealenvironments" class="block text-gray-700 font-medium">Ideal Environments</label>
                    <textarea name="idealenvironments" id="idealenvironments" rows="3" class="w-full border rounded px-3 py-2 mt-1">{{ old('idealenvironments', $section->idealenvironments) }}</textarea>
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
        function toggleFields() {
            const domain = document.getElementById('domain_id').value;
            const showSpecial = domain === 'OCEAN' || domain === 'Work Values';
            document.getElementById('low-group').style.display = showSpecial ? '' : 'none';
            document.getElementById('mid-group').style.display = showSpecial ? '' : 'none';
            document.getElementById('high-group').style.display = showSpecial ? '' : 'none';
            document.getElementById('keytraits-group').style.display = showSpecial ? 'none' : '';
            document.getElementById('enjoys-group').style.display = showSpecial ? 'none' : '';
            document.getElementById('idealenvironments-group').style.display = showSpecial ? 'none' : '';
        }
        document.getElementById('domain_id').addEventListener('change', toggleFields);
        window.addEventListener('DOMContentLoaded', toggleFields);
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>
