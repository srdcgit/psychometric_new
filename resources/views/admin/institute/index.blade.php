<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Institutes') }}
        </h2> --}}
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Institutes</h2>
            <a href="{{ route('institute.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded inline-block hover:bg-indigo-700 transition-colors">
                + Add New Institute
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        {{-- <div class="mb-6">
            <a href="{{ route('institute.create') }}"
                class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                + Add New Institute
            </a>
        </div> --}}

        @if (session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            @if ($institutes->count())
                <div class="table-responsive">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Address</th>
                                <th class="px-4 py-2">Mobile</th>
                                <th class="px-4 py-2">Contact Person</th>
                                <th class="px-4 py-2">Allowed Student</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($institutes as $institute)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ ($institutes->currentPage() - 1) * $institutes->perPage() + $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $institute->name }}</td>
                                    <td class="px-4 py-2">{{ $institute->email }}</td>
                                    <td class="px-4 py-2">{{ $institute->address }}</td>
                                    <td class="px-4 py-2">{{ $institute->mobile }}</td>
                                    <td class="px-4 py-2">{!! $institute->contact_person !!}</td>

                                    @php
                                        $registered = \App\Models\User::where(
                                            'register_institute_id',
                                            $institute->id,
                                        )->count();
                                        $allowed = $institute->allowed_students;
                                    @endphp


                                    <td class="px-4 py-2">
                                        <div class="text-sm text-gray-600 mt-1">
                                            {{ $registered }} / {{ $allowed }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 space-x-2">
                                        <a href="{{ route('institute.edit', $institute->id) }}"
                                            class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('institute.destroy', $institute->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline delete-btn"
                                                data-id="{{ $institute->id }}">
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
                    {!! $institutes->links() !!}
                </div>
            @else
                <p>No institutes found.</p>
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
                        text: "This will permanently delete the Institute.",
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
