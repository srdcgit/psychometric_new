<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Sections</h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('section.create') }}" class="bg-indigo-600 text-dark px-4 py-2 rounded mb-4 inline-block">
            + Add Section
        </a>

        <div class="bg-white shadow rounded p-6">
            @if ($sections->count())
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Domain</th>
                            <th class="px-4 py-2">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sections as $section)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $section->name }}</td>
                                <td class="px-4 py-2">{{ $section->domain->name }}</td>
                                <td class="px-4 py-2">{{ $section->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No sections found.</p>
            @endif
        </div>
    </div>
</x-app-layout>
