<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Career</h2>
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

            <form action="{{ route('career.update', $career->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Section Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $career->name) }}"
                           class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div> --}}

                <div class="mb-4">
                    <label for="career_category_id" class="block text-sm font-medium text-gray-700">Career Category</label>
                    <select name="career_category_id" id="career_category_id" required
                            class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Career Category</option>
                        @foreach ($career_categories as $career_category)
                            <option value="{{ $career_category->id }}"
                                {{ old('career_category_id', $career->career_category_id) == $career_category->id ? 'selected' : '' }}>
                                {!! $career_category->name !!}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Careers</label>
                    <textarea name="name" id="name" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('name', $career->name) }}</textarea>
                </div>

                <div class="flex justify-end space-x-4">
                        <a href="{{ route('career.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Update Career
                    </button>
                </div>
            </form>
        </div>
    </div>

     <!-- CKEditor 5 Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#name'))
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>
