@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4 bg-light min-vh-100">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">📋 Question Management</h2>
                <p class="text-muted mb-0 small">View, filter, and manage all questions easily.</p>
            </div>
            <a href="{{ route('question.create') }}" class="btn btn-primary shadow-sm">
                + Add Question
            </a>
        </div>

        <!-- Main Card -->
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">

                <!-- Bulk Actions -->
                <div class="row align-items-center mb-4">
                    <div class="col-md-6 d-flex gap-2">
                        <select id="bulk_action" class="form-select w-auto">
                            <option value="">Bulk Actions</option>
                            <option value="delete">Delete Selected</option>
                        </select>
                        <button id="apply_bulk_action" class="btn btn-dark">Apply</button>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end gap-3">
                        <select id="per_page" class="form-select w-auto">
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                        <button id="reset_filters" class="btn btn-link text-decoration-none text-muted">
                            Reset Filters
                        </button>
                    </div>
                </div>

                <!-- Filters -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="domain_filter" class="form-label fw-semibold">Domain</label>
                        <select id="domain_filter" class="form-select">
                            <option value="">All Domains</option>
                            @foreach ($domains as $domain)
                                <option value="{{ $domain->id }}" data-type="{{ $domain->scoring_type }}">
                                    {{ $domain->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="section_filter" class="form-label fw-semibold">Section</label>
                        <select id="section_filter" class="form-select" disabled>
                            <option value="">Select Domain First</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="type_filter" class="form-label fw-semibold">Question Type</label>
                        <select id="type_filter" class="form-select" disabled>
                            <option value="">Select Domain First</option>
                        </select>
                    </div>
                </div>

                <!-- Advanced Filters -->
                <div class="card bg-light border-0 mb-4">
                    <div class="card-body py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-semibold mb-0 text-secondary">Advanced Filters</h6>
                            <button id="toggle_advanced" class="btn btn-sm btn-outline-primary">
                                Show / Hide
                            </button>
                        </div>
                        <div id="advanced_filters" class="d-none mt-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="date_from" class="form-label">Date From</label>
                                    <input type="date" id="date_from" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="date_to" class="form-label">Date To</label>
                                    <input type="date" id="date_to" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="position-relative mb-4">
                    <input type="text" id="search" class="form-control ps-5"
                        placeholder="Search by question, domain, or section...">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                </div>

                <!-- Table Header -->
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3 mb-2 border">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="select_all">
                        <label class="form-check-label text-muted small" for="select_all">Select All</label>
                    </div>
                    <span class="text-muted small">
                        Total Questions: <strong>{{ $questions->total() }}</strong>
                    </span>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    @if ($questions->count())
                        <table class="table table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>Domain</th>
                                    <th>Section</th>
                                    <th>Question</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="questions-table-body">
                                @foreach ($questions as $question)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input question-checkbox"
                                                value="{{ $question->id }}">
                                        </td>
                                        <td>{{ ($questions->currentPage() - 1) * $questions->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="fw-semibold">{{ $question->domain->name }}</td>
                                        <td>{{ $question->section->name }}</td>
                                        <td class="text-truncate" style="max-width: 400px;">{!! $question->question !!}</td>
                                        <td>
                                            <span
                                                class="badge 
                                            {{ $question->domain->scoring_type === 'mcq' ? 'bg-success' : 'bg-info text-dark' }}">
                                                {{ strtoupper($question->domain->scoring_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('question.edit', $question->id) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="{{ route('question.destroy', $question->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                                    data-id="{{ $question->id }}">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {!! $questions->links('pagination::bootstrap-5') !!}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted mb-2"></i>
                            <h5 class="fw-semibold text-muted">No Questions Found</h5>
                            <p class="text-muted small">Start by creating a new question.</p>
                            <a href="{{ route('question.create') }}" class="btn btn-primary mt-2">
                                + Add Question
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts (same as before) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Keep your existing JS/AJAX --}}

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

          

            // DOMContentLoaded refersh in delete
            const tableBody = document.getElementById('questions-table-body');

            tableBody.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-btn')) {
                    e.preventDefault();
                    const form = e.target.closest('form');

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
            });


            // Toggle Advanced Filters
            toggleAdvanced.addEventListener('click', function() {
                advancedFilters.classList.toggle('d-none');

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
                const selectedQuestions = Array.from(document.querySelectorAll(
                        '.question-checkbox:checked'))
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
                            url: '{{ route('question.bulk-action') }}',
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
                                    text: xhr.responseJSON?.message ||
                                        'An error occurred',
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
                    url: '{{ route('question.index') }}',
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
                                const allCheckboxes = document.querySelectorAll(
                                    '.question-checkbox');
                                const allChecked = Array.from(allCheckboxes).every(cb =>
                                    cb.checked);
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
