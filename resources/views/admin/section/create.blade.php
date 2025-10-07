<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Create Section</h2>
    </x-slot>

    <div class="py-10 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded p-6">
            <form method="POST" action="{{ route('section.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium">Name</label>
                    <input type="text" name="name" id="name" required
                        class="w-full border rounded px-3 py-2 mt-1">
                </div>

                <div class="mb-4">
                    <label for="code" class="block text-gray-700 font-medium">Code</label>
                    <input type="text" name="code" id="code" required
                        class="w-full border rounded px-3 py-2 mt-1">
                </div>

                <div class="mb-4">
                    <label for="domain_id" class="block text-gray-700 font-medium">Domain</label>
                    <select name="domain_id" id="domain_id" required class="w-full border rounded px-3 py-2 mt-1">
                        <option value="">Select Domain</option>
                        @foreach ($domains as $domain)
                            <option value="{{ $domain->name == 'OCEAN' ? 'OCEAN' : ($domain->name == 'WORK VALUES' ? 'WORK VALUES' : $domain->id) }}">{{ $domain->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4" id="low-group">
                    <label for="low" class="block text-gray-700 font-medium">Low</label>
                    <textarea name="low" id="low" rows="3" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                </div>

                <div class="mb-4" id="mid-group">
                    <label for="mid" class="block text-gray-700 font-medium">Mid</label>
                    <textarea name="mid" id="mid" rows="3" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                </div>

                <div class="mb-4" id="high-group">
                    <label for="high" class="block text-gray-700 font-medium">High</label>
                    <textarea name="high" id="high" rows="3" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                </div>

                <div class="mb-4" id="keytraits-group">
                    <label for="keytraits" class="block text-gray-700 font-medium">Key Traits</label>
                    <textarea name="keytraits" id="keytraits" rows="3" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                </div>

                <div class="mb-4" id="enjoys-group">
                    <label for="enjoys" class="block text-gray-700 font-medium">Enjoys</label>
                    <textarea name="enjoys" id="enjoys" rows="3" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                </div>

                <div class="mb-4" id="idealenvironments-group">
                    <label for="idealenvironments" class="block text-gray-700 font-medium">Ideal Environments</label>
                    <textarea name="idealenvironments" id="idealenvironments" rows="3" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium">Description</label>
                    <textarea name="description" id="description" rows="3" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 font-medium">Image</label>
                    <input type="file" accept="image/*" name="image" id="image" class="w-full border rounded px-3 py-2 mt-1">
                    <div class="mt-2">
                        <img id="image-preview" src="#" alt="Preview" style="display:none;max-height:120px;"/>
                    </div>
                </div>

                <x-primary-button>{{ __('Create') }}</x-primary-button>
            </form>
        </div>
    </div>

    <!-- CKEditor 5 Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        function toggleFields() {
            const domain = document.getElementById('domain_id').value;
            const showSpecial = domain === 'OCEAN' || domain === 'WORK VALUES';
            document.getElementById('low-group').style.display = showSpecial ? '' : 'none';
            document.getElementById('mid-group').style.display = showSpecial ? '' : 'none';
            document.getElementById('high-group').style.display = showSpecial ? '' : 'none';
            document.getElementById('keytraits-group').style.display = showSpecial ? 'none' : '';
            document.getElementById('enjoys-group').style.display = showSpecial ? 'none' : '';
            document.getElementById('idealenvironments-group').style.display = showSpecial ? 'none' : '';
        }
        document.getElementById('domain_id').addEventListener('change', toggleFields);
        window.addEventListener('DOMContentLoaded', toggleFields);
        // Preview selected image
        document.getElementById('image').addEventListener('change', function (e) {
            const [file] = this.files;
            const img = document.getElementById('image-preview');
            if (file) {
                img.src = URL.createObjectURL(file);
                img.style.display = '';
            } else {
                img.src = '#';
                img.style.display = 'none';
            }
        });
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>
