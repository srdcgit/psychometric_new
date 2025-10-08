@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* Container header with gradient background and rounded edges */
.header-gradient {
    background: linear-gradient(90deg, #624bff 0, #29b6f6 100%);
    color: #fff;
    border-radius: 1rem 1rem 0 0;
    padding: 1.5rem 2rem;
    box-shadow: 0 8px 24px rgba(60,72,88,0.05);
}
.card-institutes {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9fafb;
}
.table-striped tbody tr:nth-of-type(even) {
    background-color: #ffffff;
}
</style>

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center header-gradient mb-4">
        <h2 class="h4 mb-0">Institutes</h2>
        <a href="{{ route('institute.create') }}" class="btn btn-lg btn-warning d-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle"></i> Add New Institute
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Card -->
    <div class="card-institutes p-4 mb-4">
        @if($institutes->count())
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:48px;">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Mobile</th>
                            <th>Contact Person</th>
                            <th>Allowed Student</th>
                            <th style="width:170px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($institutes as $institute)
                        <tr>
                            <td>
                                <span class="badge bg-info text-dark px-3 py-2">
                                    {{ ($institutes->currentPage() - 1) * $institutes->perPage() + $loop->iteration }}
                                </span>
                            </td>
                            <td>{{ $institute->name }}</td>
                            <td>{{ $institute->email }}</td>
                            <td>{{ $institute->address }}</td>
                            <td>{{ $institute->mobile }}</td>
                            <td>{!! $institute->contact_person !!}</td>
                            <td>
                                <div class="small text-muted">{{ \App\Models\User::where('register_institute_id', $institute->id)->count() }} / {{ $institute->allowed_students }}</div>
                            </td>
                            <td class="d-flex gap-2 align-items-center">
                                <a href="{{ route('institute.edit', $institute->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                               <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $institute->id }}" data-form-id="delete-form-{{ $institute->id }}">
    <i class="bi bi-trash"></i>
</button>

<form id="delete-form-{{ $institute->id }}" action="{{ route('institute.destroy', $institute->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-center">
                {!! $institutes->links('pagination::bootstrap-5') !!}
            </div>
        @else
            <div class="text-center p-5 text-muted bg-light rounded">
                <i class="bi bi-diagram-3 fs-1 mb-3"></i>
                <h4>No institutes found.</h4>
                <p class="mb-0">Start by adding a new institute to manage your data.</p>
            </div>
        @endif
    </div>
</div>

<!-- SweetAlert for delete confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
   document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const formId = this.dataset.formId;
        const form = document.getElementById(formId);

        Swal.fire({
            title: 'Are you sure?',
            text: 'This institute will be permanently deleted.',
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

});
</script>
@endsection
