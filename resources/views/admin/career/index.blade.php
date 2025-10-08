@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
.header-gradient {
    background: linear-gradient(90deg, #624bff 0, #29b6f6 100%);
    color: #fff;
    border-radius: 1rem;
    padding: 1rem 2rem;
    box-shadow: 0 8px 24px rgba(60,72,88,0.05);
    margin-bottom: 1rem;
}
.card-careers {
    background-color: #fff;
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
.action-btn {
    min-width: 36px;
    padding: 0.375rem 0.5rem;
}
</style>

<div class="container py-4">
    <div class="header-gradient d-flex justify-content-between align-items-center">
        <h2 class="h4 mb-0">Career</h2>
        <a href="{{ route('career.create') }}" class="btn btn-lg btn-warning d-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle"></i> Add New Career
        </a>
    </div>

    @if (session('success'))
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

    <div class="card-careers">
        @if ($careers->count())
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Name</th>
                            <th>Career Category</th>
                            <th style="width: 140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($careers as $career)
                            <tr>
                                <td>
                                    <span class="badge bg-info text-dark px-3 py-2">
                                        {{ ($careers->currentPage() - 1) * $careers->perPage() + $loop->iteration }}
                                    </span>
                                </td>
                                <td>{!! $career->name ?? 'Null' !!}</td>
                                <td>{!! $career->careerCategory->name ?? 'Null' !!}</td>
                                <td>
                                    <a href="{{ route('career.edit', $career->id) }}"
                                        class="btn btn-sm btn-outline-primary action-btn"
                                        data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('career.destroy', $career->id) }}" method="POST" class="d-inline-block m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger action-btn delete-btn"
                                            data-id="{{ $career->id }}" data-bs-toggle="tooltip" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-center">
                {!! $careers->links('pagination::bootstrap-5') !!}
            </div>
        @else
            <div class="text-center p-5 text-muted">
                <i class="bi bi-exclamation-circle fs-1 mb-3"></i>
                <h5>No Careers found.</h5>
            </div>
        @endif
    </div>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the Career.",
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

    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
@endsection
