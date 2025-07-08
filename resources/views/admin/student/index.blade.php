<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Students') }}
        </h2> --}}
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Students</h2>
            <a href="{{ route('students.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded inline-block hover:bg-indigo-700 transition-colors">
                + Add New Students
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        {{-- <div class="mb-6">
            <a href="{{ route('students.create') }}"
                class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                + Add New Students
            </a>
        </div> --}}

        @if (session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            @if ($students->count())
                <form method="GET" action="{{ route('students.index') }}" class="mb-6">
                    <input type="text" name="search" placeholder="Search by name or email"
                        value="{{ request('search') }}" class="border px-4 py-2 rounded w-1/3" />
                    <button type="submit" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Search
                    </button>
                </form>

                <div class="table-responsive">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Instituation Name</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Age</th>
                                <th class="px-4 py-2">Class</th>
                                <th class="px-4 py-2">School</th>
                                {{-- <th class="px-4 py-2">Location</th>
                            <th class="px-4 py-2">Subjects/Stream</th>
                            <th class="px-4 py-2">Career Aspiration</th>
                            <th class="px-4 py-2">Parental Occupation</th> --}}
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr class="border-b">
                                    <td class="px-4 py-2">
                                        {{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-2">{{ $student->institute->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $student->name }}</td>
                                    <td class="px-4 py-2">{{ $student->email }}</td>
                                    <td class="px-4 py-2">{{ $student->age }}</td>
                                    <td class="px-4 py-2">{{ $student->class }}</td>
                                    <td class="px-4 py-2">{{ $student->school }}</td>
                                    <td class="px-4 py-2 space-x-2">
                                        <a href="{{ route('students.edit', $student->id) }}"
                                            class="text-blue-500 hover:underline">Edit</a>

                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                            class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline delete-btn"
                                                data-id="{{ $student->id }}">
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
                    {!! $students->links() !!}
                </div>
            @else
                <p>No student found.</p>
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
                        text: "This will permanently delete the Students.",
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
