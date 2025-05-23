<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Students') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('institutestudent.create') }}"
                class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                + Add New Student
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-5">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            @if ($students->count())
                <div class="table-responsive">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Instituation</th>
                                <th class="px-4 py-2">Student Name</th>
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
                                        <a href="{{ route('institutestudent.show', $student->id) }}"
                                            class="text-blue-500 hover:underline">view Result</a>
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
</x-app-layout>
