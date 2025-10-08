@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />

<style>
  .header-container {
    background: linear-gradient(90deg, #6366f1, #4338ca);
    padding: 1rem 1.5rem;
    border-radius: 1rem 1rem 0 0;
    color: white;
    margin-bottom: 1.5rem;
  }
  .header-container h2 {
    margin: 0;
    font-weight: 600;
    font-size: 1.25rem;
  }
  .btn-add {
    background-color: #4f46e5;
    padding: 0.5rem 1rem;
    color: white;
    border-radius: 0.375rem;
    font-weight: 600;
    transition: background-color 0.3s ease;
  }
  .btn-add:hover {
    background-color: #4338ca;
  }
  .card-container {
    background-color: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }
  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 0.75rem;
  }
  thead tr {
    background-color: #f3f4f6;
  }
  thead th {
    font-weight: 600;
    padding: 0.75rem 1rem;
    text-align: left;
    text-transform: uppercase;
    font-size: 0.75rem;
    color: #4b5563;
  }
  tbody tr {
    background-color: white;
    border-radius: 0.5rem;
  }
  tbody tr:hover {
    background-color: #e0e7ff;
  }
  tbody td {
    padding: 0.75rem 1rem;
    vertical-align: top;
    color: #374151;
    font-size: 0.875rem;
  }
  .actions a, .actions button {
    font-weight: 600;
    font-size: 0.875rem;
    margin-right: 0.5rem;
    text-decoration: none;
    cursor: pointer;
  }
  .actions a {
    color: #4f46e5;
  }
  .actions a:hover {
    color: #4338ca;
    text-decoration: underline;
  }
  .actions button {
    background: none;
    border: none;
    color: #ef4444;
  }
  .actions button:hover {
    color: #b91c1c;
  }
  .pagination-wrapper {
    margin-top: 1.5rem;
    display: flex;
    justify-content: center;
  }
  .no-data {
    text-align: center;
    padding: 3rem;
    color: #6b7280;
  }
</style>

<div class="container my-4">
  <div class="header-container d-flex justify-content-between align-items-center">
    <h2>Career Category</h2>
    <a href="{{ route('careercategory.create') }}" class="btn-add">+ Add New Career Category</a>
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

  <div class="card-container">
    @if($careercategories->count())
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Hook</th>
            <th>What is it?</th>
            <th>Example roles</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($careercategories as $career)
          <tr>
            <td>{{ ($careercategories->currentPage()-1)*$careercategories->perPage() + $loop->iteration }}</td>
            <td>{!! $career->name ?? 'Null' !!}</td>
            <td>{{ \Illuminate\Support\Str::limit(strip_tags($career->hook), 60) }}</td>
            <td>{{ \Illuminate\Support\Str::limit(strip_tags($career->what_is_it), 60) }}</td>
            <td>{{ \Illuminate\Support\Str::limit(strip_tags($career->example_roles), 60) }}</td>
            <td class="actions">
              <a href="{{ route('careercategory.edit', $career->id) }}">Edit</a>
              <form action="{{ route('careercategory.destroy', $career->id) }}" method="POST" class="d-inline delete-form">
                @csrf
                @method('DELETE')
                <button type="button" class="delete-btn" data-id="{{ $career->id }}">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="pagination-wrapper">
      {!! $careercategories->links('pagination::bootstrap-5') !!}
    </div>

    @else
    <div class="no-data">
      No Career Categories Found.
    </div>
    @endif
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(function (button) {
      button.addEventListener('click', function (e) {
        e.preventDefault();
        const form = this.closest('form');
        Swal.fire({
          title: 'Are you sure?',
          text: "This will permanently delete the Career Category.",
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
  });
</script>
@endsection