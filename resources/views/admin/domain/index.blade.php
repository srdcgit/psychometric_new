<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Domains') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('domain.create') }}"
                class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                + Add New Domain
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            @if ($domains->count())
                <div class="table-responsive">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Score Type</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($domains as $domain)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ ($domains->currentPage() - 1) * $domains->perPage() + $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $domain->name ?? 'Null' }}</td>
                                    <td class="px-4 py-2">{{ $domain->scoring_type ?? 'Null' }}</td>
                                    <td class="px-4 py-2">{!! $domain->description ?? 'null' !!}</td>
                                    <td class="px-4 py-2 space-x-2">
                                        <a href="{{ route('domain.edit', $domain->id) }}"
                                            class="text-blue-500 hover:underline">Edit</a>

                                        <form action="{{ route('domain.destroy', $domain->id) }}" method="POST"
                                            class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:underline delete-btn"
                                                data-id="{{ $domain->id }}">
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
                    {!! $domains->links() !!}
                </div>
            @else
                <p>No domains found.</p>
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
                        text: "This will permanently delete the domain.",
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
