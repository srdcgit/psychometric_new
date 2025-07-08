<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="text-xl font-semibold text-gray-800">Sections</h2> --}}
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Sections</h2>
            <a href="{{ route('section.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded inline-block hover:bg-indigo-700 transition-colors">
                + Add New Sections
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- <a href="{{ route('section.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded mb-4 inline-block">
            + Add Section
        </a> --}}

        <div class="bg-white shadow rounded p-6">
            @if ($sections->count())
                <div class="table-responsive">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Code</th>
                                <th class="px-4 py-2">Domain</th>
                                <th class="px-4 py-2">Key Traits</th>
                                <th class="px-4 py-2">Enjoys</th>
                                <th class="px-4 py-2">Ideal Environments</th>
                                <th class="px-4 py-2">Low</th>
                                <th class="px-4 py-2">Mid</th>
                                <th class="px-4 py-2">High</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sections as $section)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ ($sections->currentPage() - 1) * $sections->perPage() + $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $section->name }}</td>
                                    <td class="px-4 py-2">{{ $section->code }}</td>
                                    <td class="px-4 py-2">{{ $section->domain->name ?? 'No Domain Found' }}</td>

                                    <td class="px-4 py-2">{{ $section->keytraits ?? 'Null' }}</td>
                                    <td class="px-4 py-2">{{ $section->enjoys ?? 'Null' }}</td>
                                    <td class="px-4 py-2">{{ $section->idealenvironments ?? 'Null' }}</td>
                                    <td class="px-4 py-2">{{ $section->low ?? 'Null' }}</td>
                                    <td class="px-4 py-2">{{ $section->mid ?? 'Null' }}</td>
                                    <td class="px-4 py-2">{{ $section->high ?? 'Null' }}</td>
                                    <td class="px-4 py-2">{!! $section->description ?? 'Null' !!}</td>
                                    <td class="px-4 py-2 space-x-2">
                                        <a href="{{ route('section.edit', $section->id) }}"
                                            class="text-blue-600 hover:underline">Edit</a>

                                        <form action="{{ route('section.destroy', $section->id) }}" method="POST"
                                            class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:underline delete-btn"
                                                data-id="{{ $section->id }}">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {!! $sections->links() !!}
                </div>
            @else
                <p>No sections found.</p>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will permanently delete the section.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>

</x-app-layout>
