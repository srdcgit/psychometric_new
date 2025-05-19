<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Institutes') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('institute.create') }}"
               class="inline-block px-4 py-2 bg-indigo-600 text-dark rounded hover:bg-indigo-700">
                + Add New Institute
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            @if ($institutes->count())
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Address</th>
                            <th class="px-4 py-2">Mobile</th>
                            <th class="px-4 py-2">Contact Person</th>
                            <th class="px-4 py-2">Allowed Student</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($institutes as $key => $institute)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $key + 1 }}</td>
                                <td class="px-4 py-2">{{ $institute->name }}</td>
                                <td class="px-4 py-2">{{ $institute->address }}</td>
                                <td class="px-4 py-2">{{ $institute->mobile }}</td>
                                <td class="px-4 py-2">{{ $institute->allowed_students }}</td>
                                <td class="px-4 py-2">{!! $institute->contact_person !!}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ route('institute.index', $institute->id) }}"
                                       class="text-blue-500 hover:underline">Edit</a>

                                    <form action="{{ route('institute.index', $institute->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:underline"
                                                onclick="return confirm('Are you sure you want to delete this institute??')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No institutes found.</p>
            @endif
        </div>
    </div>
</x-app-layout>
