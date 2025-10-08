@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
.header-gradient {
    background: linear-gradient(90deg, #624bff 0%, #29b6f6 100%);
    color: #fff;
    border-radius: 1rem;
    padding: 1rem 2rem;
    box-shadow: 0 8px 24px rgba(60,72,88,0.05);
    margin-bottom: 1.5rem;
}

.card-students {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 1.5rem;
}

.table thead th {
    font-weight: 600;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9fafb;
}

.table-striped tbody tr:hover {
    background-color: #e9ecef;
}

.badge-counter {
    font-size: 0.95rem;
    padding: 0.4em 0.75em;
    border-radius: 1rem;
}

.search-input {
    max-width: 350px;
    width: 100%;
    display: inline-block;
    padding: 0.5rem 1rem;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    font-size: 1rem;
}

.btn-search {
    padding: 0.5rem 1.25rem;
    margin-left: 0.5rem;
    border-radius: 0.375rem;
}

.action-btn {
    min-width: 36px;
    padding: 0.375rem 0.5rem;
}
</style>

<div class="container py-4">
    <div class="header-gradient d-flex justify-content-between align-items-center">
        <h2 class="h4 mb-0">Students</h2>
        <a href="{{ route('students.create') }}" class="btn btn-lg btn-warning d-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle"></i> Add New Student
        </a>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    <div class="card-students">
        @if ($students->count())
            <form method="GET" action="{{ route('students.index') }}" class="mb-4 d-flex align-items-center gap-2 flex-wrap">
                <input type="text" name="search" placeholder="Search by name or email" value="{{ request('search') }}" class="search-input" />
                <button type="submit" class="btn btn-indigo btn-search bg-indigo-600 text-white hover:bg-indigo-700 rounded">
                    Search
                </button>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>Institute Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Class</th>
                            <th>School</th>
                            <th style="width:140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <td>
                                <span class="badge bg-info text-dark badge-counter">
                                    {{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                                </span>
                            </td>
                            <td>{{ $student->institute->name ?? 'N/A' }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->age }}</td>
                            <td>{{ $student->class }}</td>
                            <td>{{ $student->school }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="tooltip" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline-block m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger action-btn delete-btn" data-id="{{ $student->id }}" data-bs-toggle="tooltip" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                {!! $students->links('pagination::bootstrap-5') !!}
            </div>
        @else
            <div class="text-center p-5 text-muted bg-light rounded">
                <i class="bi bi-exclamation-circle fs-1 mb-3"></i>
                <h4>No students found.</h4>
                <p class="mb-0">Try adding some students to get started.</p>
            </div>
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
                text: "This will permanently delete the student.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
