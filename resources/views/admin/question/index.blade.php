<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Questions</h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('question.create') }}" class="bg-indigo-600 text-dark px-4 py-2 rounded mb-4 inline-block">
            + Add Question
        </a>

        <div class="bg-white shadow rounded p-6">
            @if ($questions->count())
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Section</th>
                            <th class="px-4 py-2">Question</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $question->section->name }}</td>
                                <td class="px-4 py-2">{{ $question->question }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No questions found.</p>
            @endif
        </div>
    </div>
</x-app-layout>
