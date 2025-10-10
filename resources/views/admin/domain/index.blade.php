@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
.header-gradient {
    background: linear-gradient(90deg, #624bff 0%, #29b6f6 100%);
    color: white;
    padding: 1.25rem 2rem;
    border-radius: 1rem;
    box-shadow: 0 8px 24px rgba(60,72,88,0.05);
    margin-bottom: 1.5rem;
}
.card-domains {
    background-color: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.table thead th {
    font-weight: 600;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9fafb;
}
.table-hover tbody tr:hover {
    background-color: #e9ecef;
}
.badge-counter {
    font-size: 0.9rem;
    padding: 0.4em 0.8em;
}
.action-btn {
    width: 36px;
    height: 36px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
</style>

<div class="container py-4">

    <!-- Header -->
    <div class="header-gradient d-flex justify-content-between align-items-center">
        <h2 class="h4 mb-0">Domains</h2>
        <a href="{{ route('domain.create') }}" class="btn btn-lg btn-warning d-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle"></i> Add New Domains
        </a>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
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

    <div class="card-domains">
        @if ($domains->count())
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Name</th>
                            <th>Display Domain Name</th>
                            <th>Score Type</th>
                            <th>Description</th>
                            <th>Domain Weightage</th>
                            <th style="width: 140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($domains as $domain)
                        <tr>
                            <td><span class="badge badge-counter bg-info text-dark">{{ ($domains->currentPage()-1)*$domains->perPage() + $loop->iteration }}</span></td>
                            <td>{{ $domain->name ?? 'Null' }}</td>
                            <td>{{ $domain->display_name ?? 'Null' }}</td>
                            <td>{{ $domain->scoring_type ?? 'Null' }}</td>
                            <td>{!! Str::limit(strip_tags($domain->description), 50, '...') ?? 'Null' !!}</td>
                            <td>{{ $domain->domain_weightage ?? 'Null' }}</td>
                            <td>
                                <a href="{{ route('domain.edit', $domain->id) }}"
                                   class="btn btn-sm btn-outline-primary action-btn"
                                   data-bs-toggle="tooltip" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('domain.destroy', $domain->id) }}" method="POST" class="d-inline-block m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger action-btn delete-btn"
                                        data-bs-toggle="tooltip" title="Delete" data-id="{{ $domain->id }}">
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
                {!! $domains->links('pagination::bootstrap-5') !!}
            </div>
        @else
            <div class="text-center p-5 bg-light rounded text-muted">
                <i class="bi bi-exclamation-circle fs-1 mb-3"></i>
                <p class="mb-0">No domains found.</p>
            </div>
        @endif
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tooltip initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Delete confirmation
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            var form = this.closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the domain.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3086d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
