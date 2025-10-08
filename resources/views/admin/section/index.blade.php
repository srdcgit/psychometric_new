@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
  .header-container {
    background: linear-gradient(90deg, #624bff 0%, #29b6f6 100%);
    color: white;
    padding: 1rem 2rem;
    border-radius: 1rem 1rem 0 0;
    box-shadow: 0 8px 24px rgba(60, 72, 88, 0.05);
    margin-bottom: 1rem;
  }
  .card-container {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  }
  table thead th {
    font-weight: 600;
  }
  .table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9fafb;
  }
  .table-hover tbody tr:hover {
    background-color: #e2e8f0;
  }
  .badge-counter {
    font-size: 0.9rem;
    padding: 0.4em 0.8em;
  }
  .actions .btn {
    min-width: 36px;
    height: 36px;
    padding: 0;
  }
</style>

<div class="container py-4">
  <div class="header-container d-flex justify-content-between align-items-center">
    <h2 class="h4 mb-0">Sections</h2>
    <a href="{{ route('section.create') }}" class="btn btn-warning btn-lg d-flex align-items-center gap-2 shadow-sm">
      <i class="bi bi-plus-circle"></i> Add New Sections
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

  <div class="card-container">
    @if($sections->count())
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
          <thead>
            <tr>
              <th style="width: 50px;">#</th>
              <th>Name</th>
              <th>Code</th>
              <th>Domain</th>
              <th>Key Traits</th>
              <th>Enjoys</th>
              <th>Ideal Environments</th>
              <th>Low</th>
              <th>Mid</th>
              <th>High</th>
              <th>Description</th>
              <th style="width: 110px;">Actions</th>
            </tr>
          </thead>
          <tbody>
          @foreach($sections as $section)
            <tr>
              <td>
                <span class="badge badge-counter bg-info text-dark">
                  {{ ($sections->currentPage()-1) * $sections->perPage() + $loop->iteration }}
                </span>
              </td>
              <td>{{ $section->name }}</td>
              <td>{{ $section->code }}</td>
              <td>{{ $section->domain->name ?? 'No Domain' }}</td>
              <td>{{ $section->keytraits ?? '-' }}</td>
              <td>{{ $section->enjoys ?? '-' }}</td>
              <td>{{ $section->idealenvironments ?? '-' }}</td>
              <td>{{ $section->low ?? '-' }}</td>
              <td>{{ $section->mid ?? '-' }}</td>
              <td>{{ $section->high ?? '-' }}</td>
              <td>{!! Str::limit(strip_tags($section->description), 50, '...') !!}</td>
              <td class="actions d-flex gap-2">
                <a href="{{ route('section.edit', $section->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('section.destroy', $section->id) }}" method="POST" class="m-0 p-0 d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-bs-toggle="tooltip" data-id="{{ $section->id }}" title="Delete">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>

      <div class="mt-4 d-flex justify-content-center">
        {!! $sections->links('pagination::bootstrap-5') !!}
      </div>

    @else
      <div class="text-center p-5 bg-light rounded text-muted">
        <i class="bi bi-exclamation-circle fs-1 mb-3"></i>
        <p class="mb-0">No sections found.</p>
      </div>
    @endif
  </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Delete Confirmation
    document.querySelectorAll('.delete-btn').forEach(function(button) {
      button.addEventListener('click', function (e) {
        e.preventDefault();
        var form = this.closest('form');
        Swal.fire({
          title: 'Are you sure?',
          text: 'This will permanently delete the section.',
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