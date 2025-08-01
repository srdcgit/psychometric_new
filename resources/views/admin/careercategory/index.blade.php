<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Career Category') }}
        </h2> --}}
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Career Category</h2>
            <a href="{{ route('careercategory.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded inline-block hover:bg-indigo-700 transition-colors">
                + Add New Career Category
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        {{-- <div class="mb-6">
            <a href="{{ route('careercategory.create') }}"
                class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                + Add New Career Category
            </a>
        </div> --}}

        @if (session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            @if ($careercategories->count())
                <div class="table-responsive">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($careercategories as $career)
                                <tr class="border-b">
                                    <td class="px-4 py-2">
                                        {{ ($careercategories->currentPage() - 1) * $careercategories->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-2">{!! $career->name ?? 'Null' !!}</td>
                                    <td class="px-4 py-2 space-x-2">
                                            <a href="{{ route('careercategory.edit', $career->id) }}"
                                            class="text-blue-500 hover:underline">Edit</a>

                                        <form action="{{ route('careercategory.destroy', $career->id) }}" method="POST"
                                            class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:underline delete-btn"
                                                data-id="{{ $career->id }}">
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
                    {!! $careercategories->links() !!}
                </div>
            @else
                <p>No Career Categories found.</p>
            @endif
        </div>
    </div>


    <!-- Include SweetAlert2 -->
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
                        text: "This will permanently delete the Career Category.",
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

            // Show success alert if session has message
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
