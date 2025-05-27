@foreach ($questions as $question)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap">
            <input type="checkbox" class="question-checkbox rounded border-gray-300 text-indigo-600" 
                   value="{{ $question->id }}">
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ ($questions->currentPage() - 1) * $questions->perPage() + $loop->iteration }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $question->domain->name }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $question->section->name }}
        </td>
        <td class="px-6 py-4 text-sm text-gray-900">
            <div class="max-w-xl">
                {!! $question->question !!}
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $question->domain->scoring_type === 'mcq' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                {{ strtoupper($question->domain->scoring_type) }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
            <a href="{{ route('question.edit', $question->id) }}"
                class="text-indigo-600 hover:text-indigo-900">Edit</a>
            <form action="{{ route('question.destroy', $question->id) }}" method="POST"
                class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="button" class="text-red-600 hover:text-red-900 delete-btn"
                    data-id="{{ $question->id }}">
                    Delete
                </button>
            </form>
        </td>
    </tr>
@endforeach 