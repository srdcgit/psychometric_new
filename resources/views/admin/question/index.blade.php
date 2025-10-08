@extends('layouts.app')

@section('content')
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Question</h2>
            <a href="{{ route('question.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded inline-block hover:bg-indigo-700 transition-colors">
                + Add Question
            </a>
        </div>
   

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-6 border-b">
                <!-- Bulk Actions -->
                <div class="mb-6 flex items-center space-x-4">
                    <select id="bulk_action" class="rounded-md border-gray-300">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button id="apply_bulk_action" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Apply
                    </button>
                    <div class="ml-auto flex items-center space-x-4">
                        <select id="per_page" class="rounded-md border-gray-300">
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                        <button id="reset_filters" class="text-gray-600 hover:text-gray-900">
                            Reset Filters
                        </button>
                    </div>
                </div>

                <!-- Basic Filters -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label for="domain_filter" class="block text-sm font-medium text-gray-700 mb-1">Domain</label>
                        <select id="domain_filter" class="w-full rounded-md border-gray-300">
                            <option value="">All Domains</option>
                            @foreach ($domains as $domain)
                                <option value="{{ $domain->id }}" data-type="{{ $domain->scoring_type }}">
                                    {{ $domain->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="section_filter" class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                        <select id="section_filter" class="w-full rounded-md border-gray-300" disabled>
                            <option value="">Select Domain First</option>
                        </select>
                    </div>
                    <div>
                        <label for="type_filter" class="block text-sm font-medium text-gray-700 mb-1">Question Type</label>
                        <select id="type_filter" class="w-full rounded-md border-gray-300" disabled>
                            <option value="">Select Domain First</option>
                        </select>
                    </div>
                </div>

                <!-- Advanced Filters -->
                <div class="border rounded-md p-4 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-700">Advanced Filters</h3>
                        <button id="toggle_advanced" class="text-sm text-indigo-600 hover:text-indigo-900">
                            Show/Hide
                        </button>
                    </div>
                    <div id="advanced_filters" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                                <input type="date" id="date_from" class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                                <input type="date" id="date_to" class="w-full rounded-md border-gray-300">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="relative">
                    <input type="text" id="search" class="w-full rounded-md border-gray-300 pl-10 pr-4 py-2" 
                           placeholder="Search by question content, domain name, or section name...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Table Header Enhancement -->
            <div class="px-6 py-4 border-b bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" id="select_all" class="rounded border-gray-300 text-indigo-600">
                        <label for="select_all" class="text-sm text-gray-600">Select All</label>
                    </div>
                    <div class="text-sm text-gray-600">
                        Total Questions: <span class="font-medium">{{ $questions->total() }}</span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                @if ($questions->count())
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domain</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Question</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="questions-table-body">
                            @foreach ($questions as $question)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="question-checkbox rounded border-gray-300 text-indigo-600" 
                                               value="{{ $question->id }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
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
                        </tbody>
                    </table>

                    <div class="px-6 py-4 border-t">
                        {!! $questions->links() !!}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No questions</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new question.</p>
                        <div class="mt-6">
                            <a href="{{ route('question.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                + Add Question
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const domainFilter = document.getElementById('domain_filter');
            const sectionFilter = document.getElementById('section_filter');
            const typeFilter = document.getElementById('type_filter');
            const dateFrom = document.getElementById('date_from');
            const dateTo = document.getElementById('date_to');
            const searchInput = document.getElementById('search');
            const perPage = document.getElementById('per_page');
            const selectAll = document.getElementById('select_all');
            const toggleAdvanced = document.getElementById('toggle_advanced');
            const advancedFilters = document.getElementById('advanced_filters');
            const resetFilters = document.getElementById('reset_filters');
            const bulkAction = document.getElementById('bulk_action');
            const applyBulkAction = document.getElementById('apply_bulk_action');
            let typingTimer;

            // Store unique scoring types from domains
            const scoringTypes = new Set();
            document.querySelectorAll('#domain_filter option').forEach(option => {
                const type = option.getAttribute('data-type');
                if (type) scoringTypes.add(type);
            });

            function handleDelete(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will permanently delete the question.",
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
            }

            // Toggle Advanced Filters
            toggleAdvanced.addEventListener('click', function() {
                advancedFilters.classList.toggle('hidden');
            });

            // Reset Filters
            resetFilters.addEventListener('click', function() {
                domainFilter.value = '';
                sectionFilter.value = '';
                typeFilter.value = '';
                dateFrom.value = '';
                dateTo.value = '';
                searchInput.value = '';
                filterQuestions();
            });

            // Select All Checkboxes
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.question-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Domain filter change - update sections and question type
            domainFilter.addEventListener('change', function() {
                const domainId = this.value;
                const selectedOption = this.options[this.selectedIndex];
                const scoringType = selectedOption.getAttribute('data-type');
                
                // Update type filter based on domain selection
                if (domainId) {
                    typeFilter.removeAttribute('disabled');
                    sectionFilter.removeAttribute('disabled');
                    if (scoringType) {
                        typeFilter.innerHTML = `
                            <option value="">All Types</option>
                            <option value="${scoringType}" selected>${scoringType.toUpperCase()}</option>
                        `;
                    }
                    updateSections(domainId);
                } else {
                    typeFilter.setAttribute('disabled', 'disabled');
                    sectionFilter.setAttribute('disabled', 'disabled');
                    typeFilter.innerHTML = '<option value="">Select Domain First</option>';
                    sectionFilter.innerHTML = '<option value="">Select Domain First</option>';
                }

                filterQuestions();
            });

            // Section filter change
            sectionFilter.addEventListener('change', filterQuestions);

            // Search input with debounce
            searchInput.addEventListener('keyup', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(filterQuestions, 500);
            });

            searchInput.addEventListener('keydown', function() {
                clearTimeout(typingTimer);
            });

            // Update sections based on domain
            function updateSections(domainId) {
                if (!domainId) {
                    sectionFilter.innerHTML = '<option value="">Select Domain First</option>';
                    sectionFilter.setAttribute('disabled', 'disabled');
                    return;
                }

                $.ajax({
                    url: 'domain/' + domainId + '/sections',
                    method: 'GET',
                    success: function(sections) {
                        let options = '<option value="">All Sections</option>';
                        sections.forEach(section => {
                            options += `<option value="${section.id}">${section.name}</option>`;
                        });
                        sectionFilter.innerHTML = options;
                        sectionFilter.removeAttribute('disabled');
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to load sections:', error);
                        sectionFilter.innerHTML = '<option value="">Error loading sections</option>';
                        sectionFilter.setAttribute('disabled', 'disabled');
                    }
                });
            }

            // Bulk Actions
            applyBulkAction.addEventListener('click', function() {
                const selectedQuestions = Array.from(document.querySelectorAll('.question-checkbox:checked'))
                    .map(checkbox => checkbox.value);

                if (selectedQuestions.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Questions Selected',
                        text: 'Please select at least one question.',
                        timer: 3000
                    });
                    return;
                }

                const action = bulkAction.value;
                if (!action) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Action Selected',
                        text: 'Please select an action to perform.',
                        timer: 3000
                    });
                    return;
                }

                Swal.fire({
                    title: 'Confirm Delete',
                    text: 'Are you sure you want to delete the selected questions?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("question.bulk-action") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                action: action,
                                questions: selectedQuestions
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    timer: 3000
                                });
                                filterQuestions();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'An error occurred',
                                    timer: 3000
                                });
                            }
                        });
                    }
                });
            });

            // Filter questions
            function filterQuestions() {
                const domain = domainFilter.value;
                const section = sectionFilter.value;
                const type = typeFilter.value;
                const dateFromVal = dateFrom.value;
                const dateToVal = dateTo.value;
                const search = searchInput.value;
                const itemsPerPage = perPage.value;

                $.ajax({
                    url: '{{ route("question.index") }}',
                    method: 'GET',
                    data: {
                        domain: domain,
                        section: section,
                        type: type,
                        date_from: dateFromVal,
                        date_to: dateToVal,
                        search: search,
                        per_page: itemsPerPage
                    },
                    success: function(response) {
                        const tableBody = document.getElementById('questions-table-body');
                        tableBody.innerHTML = response;
                        
                        // Reattach event listeners
                        const newDeleteButtons = tableBody.querySelectorAll('.delete-btn');
                        newDeleteButtons.forEach(button => {
                            button.addEventListener('click', handleDelete);
                        });

                        // Reattach checkbox event listeners
                        const checkboxes = tableBody.querySelectorAll('.question-checkbox');
                        checkboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                // Update select all checkbox state
                                const allCheckboxes = document.querySelectorAll('.question-checkbox');
                                const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
                                selectAll.checked = allChecked;
                            });
                        });

                        // Reset select all checkbox
                        selectAll.checked = false;
                    },
                    error: function(xhr, status, error) {
                        console.error('Error filtering questions:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to filter questions. Please try again.',
                            timer: 3000
                        });
                    }
                });
            }

            // Event listeners for filters
            [typeFilter, perPage].forEach(filter => {
                filter.addEventListener('change', filterQuestions);
            });

            [dateFrom, dateTo].forEach(dateInput => {
                dateInput.addEventListener('change', filterQuestions);
            });

            // Success message
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

@endsection
