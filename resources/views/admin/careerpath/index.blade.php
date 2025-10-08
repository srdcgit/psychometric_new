@extends('layouts.app')

@section('content')
<style>
.bg-glass {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(8px) saturate(1.2);
    box-shadow: 0 12px 32px 0 rgba(31,45,61,0.08), 0 1.5px 5px 0 rgba(60,72,88,0.05);
    border-radius: 1rem;
}
.header-gradient {
    background: linear-gradient(90deg, #624bff 0, #29b6f6 100%);
    color: #fff;
    border-radius: 1rem 1rem 0 0;
    box-shadow: 0 8px 24px rgba(60,72,88,0.05);
}
.card-stats {
    background: #fff6ec;
    border-radius: 1rem;
    box-shadow: 0 2px 16px 0 rgba(31,45,61,0.06);
    padding: 1.5rem;
}
.table thead th {
    border-top: none;
    font-size: 1rem;
    font-weight: 500;
}
.table tbody tr {
    transition: background 0.2s;
}
.table tbody tr:hover {
    background: #f5f7fb !important;
}
.badge-name {
        font-weight: none !important;
}
</style>

<div class="container py-4">

   <!-- Header with SVG Icon & Controls -->
<div class="d-flex justify-content-between align-items-center header-gradient p-4 mb-4">
    <div class="d-flex align-items-center gap-3">
        <!-- Career-related SVG icon -->
       <svg height="40px" width="40px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffffff;} </style> <g> <path class="st0" d="M275.175,74.728c20.637,0,37.372-16.728,37.372-37.364C312.547,16.727,295.812,0,275.175,0 c-20.629,0-37.357,16.727-37.357,37.364C237.818,58,254.546,74.728,275.175,74.728z"></path> <polygon class="st0" points="372.199,419.995 282.451,419.995 282.451,354.645 192.737,354.645 192.737,289.282 102.993,289.282 102.993,223.918 26.559,223.918 26.559,250.56 76.359,250.56 76.359,315.923 166.103,315.923 166.103,381.287 255.817,381.287 255.817,446.637 345.568,446.637 345.568,512 460.237,512 460.237,485.366 372.199,485.359 "></polygon> <path class="st0" d="M477.983,181.243c-0.636-4.242-4.588-7.168-8.838-6.532l-17.934,2.695l-1.532-10.195 c-0.636-4.147-4.494-6.987-8.635-6.373l-1.878,0.282c-0.261-1.734-0.86-3.447-1.85-5.022l-25.897-41.411 c-2.796-4.466-7.052-7.819-12.053-9.488L352.48,83.334c-15.857-7.392-34.21-6.597-49.42,1.821l-9.748,59.294l-36.128-30.63 l-28.882,18.187l-42.183-19.799c-6.554-3.671-14.82-1.495-18.714,4.92l-0.535,0.867c-1.922,3.187-2.514,6.994-1.618,10.601 c0.888,3.606,3.194,6.705,6.387,8.612l50.277,30.002c6.25,3.736,13.874,4.408,20.687,1.836l29.777-16.041l14.119,56.952 l-46.932-0.238c-7.905-0.022-15.412,3.483-20.456,9.574c-5.044,6.091-7.088,14.119-5.586,21.887l15.788,81.282 c1.748,9.003,10.282,15.03,19.35,13.672l0.679-0.102c8.982-1.344,15.347-9.458,14.516-18.498l-5.347-58.24l70.819,1.648 c10.167,0.231,19.889-4.156,26.443-11.937c6.554-7.775,9.22-18.108,7.262-28.094l-1.814-9.205l-14.564-82.2l37.534,5.542 l27.458,31.844c-1.618,1.648-2.565,3.902-2.204,6.359l1.532,10.21l-17.927,2.695c-4.249,0.636-7.168,4.595-6.525,8.844l7.363,48.99 c0.644,4.241,4.596,7.168,8.838,6.532l76.101-11.446c4.242-0.636,7.161-4.596,6.525-8.844L477.983,181.243z M295.162,168.496 c0-2.558,2.074-4.625,4.624-4.625s4.624,2.067,4.624,4.625c0,2.558-2.074,4.624-4.624,4.624S295.162,171.054,295.162,168.496z M304.714,199.018c-2.551,0-4.625-2.066-4.625-4.624s2.074-4.624,4.625-4.624c2.55,0,4.624,2.066,4.624,4.624 S307.265,199.018,304.714,199.018z M416.745,172.644c4.329,4.205,10.984,5,16.157,1.719l0.304-0.195 c2.182-1.38,3.801-3.316,4.827-5.484l4.104-0.621l0.318,0.232l1.532,10.202l-25.781,3.873L416.745,172.644z"></path> <path class="st0" d="M393.667,384.835c6.286,6.568,16.67,6.965,23.44,0.888l0.485-0.426c6.749-6.055,7.486-16.381,1.676-23.353 l-38.701-51.932l-12.342-60.126c-0.838,1.207-1.698,2.4-2.652,3.534c-9.205,10.932-22.692,17.204-36.992,17.204l-6.576-0.152 l14.43,46.909c3.338,6.908,7.681,13.296,12.873,18.968L393.667,384.835z"></path> <polygon class="st0" points="273.983,118.899 285.913,125.026 290.848,111.818 284.41,98.075 268.766,107.757 "></polygon> </g> </g></svg>

        <div>
            <h2 class="fs-3 fw-bold mb-0">Career Path Dashboard</h2>
            <div class="fs-6 mt-1">Manage and analyze your career structure</div>
        </div>
    </div>
    <a href="{{ route('careerpath.create') }}" class="btn btn-lg btn-warning d-flex align-items-center gap-2 shadow">
        <i class="bi bi-plus-circle"></i> Add Career Path
    </a>
</div>


    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card-stats d-flex align-items-center gap-3">
                <i class="bi bi-easel fs-2 text-primary"></i>
                <div>
                    <div class="fs-5 fw-bold">{{ $careerpaths->total() }}</div>
                    <div class="fs-6 text-black-50">Career Paths</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-stats d-flex align-items-center gap-3">
                <i class="bi bi-people fs-2 text-info"></i>
                <div>
                    <div class="fs-5 fw-bold">
                        {{ $careerpaths->reduce(function($c,$p){return $c+$p->careers->count();},0) }}
                    </div>
                    <div class="fs-6 text-black-50">Total Careers (this page)</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-stats d-flex align-items-center gap-3">
                <i class="bi bi-layers fs-2 text-warning"></i>
                <div>
                    <div class="fs-5 fw-bold">
                        {{ $careerpaths->reduce(function($c,$p){return $c+$p->sections->count();},0) }}
                    </div>
                    <div class="fs-6 text-black-50">Total Sections (this page)</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content Card -->
    <div class="card bg-glass border-0 shadow">
        <div class="card-body p-0">
            @if ($careerpaths->count())
                <div class="table-responsive">
    <table class="table align-middle table-hover table-striped rounded-3 bg-white shadow-sm">
        <thead class="table-light">
            <tr>
                <th style="width:48px;">#</th>
                <th style="min-width:200px;">Careers</th>
                <th style="min-width:160px;">Section Name</th>
                <th style="min-width:120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($careerpaths as $career)
                <tr class="hover-bg-soft">
                    <td>
                        <span class="badge badge-pill bg-info text-dark fs-6 px-3 py-2 shadow-sm">
                            {{ ($careerpaths->currentPage() - 1) * $careerpaths->perPage() + $loop->iteration }}
                        </span>
                    </td>
                    <td>
                        @if($career->careers->count() > 0)
                            @foreach($career->careers as $careerItem)
                                <span class="badge bg-light text-dark border border-light rounded-pill me-1 mb-1" style="font-size:0.9em;"
                                      data-bs-toggle="tooltip" title="{{ $careerItem->description ?? '' }}">
                                    {!! $careerItem->name !!}
                                </span>
                            @endforeach
                        @else
                            <span class="text-muted">No careers assigned</span>
                        @endif
                    </td>
                    <td>
                        @if($career->sections->count() > 0)
                            @foreach($career->sections as $section)
                                <span class="badge bg-light text-dark border border-light rounded-pill me-1 mb-1" style="font-size:0.9em;"
                                      data-bs-toggle="tooltip" title="{{ $section->description ?? '' }}">
                                    {!! $section->name !!}
                                </span>
                            @endforeach
                        @else
                            <span class="text-muted">No sections assigned</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('careerpath.edit', $career->id) }}" class="btn btn-sm btn-outline-primary me-2 shadow-sm"
                           data-bs-toggle="tooltip" title="Edit Career Path">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger shadow-sm delete-btn"
                                data-id="{{ $career->id }}" data-bs-toggle="tooltip" title="Delete Career Path">
                            <i class="bi bi-trash"></i>
                        </button>
                        <form action="{{ route('careerpath.destroy', $career->id) }}" method="POST" class="d-none delete-form">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Pagination with better spacing -->
<div class="my-4 px-3 d-flex justify-content-center">
    {!! $careerpaths->links('pagination::bootstrap-5') !!}
</div>

            @else
                <div class="text-center p-5 text-muted">
                    <i class="bi bi-diagram-3 fs-1 mb-3"></i>
                    <h3 class="mb-0">No Career Paths found</h3>
                    <p class="mt-2">Start by adding a new career path to showcase opportunities!</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Delete Career</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Career? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize tooltips
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
            new bootstrap.Tooltip(el)
        });

        let deleteId = null;
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                deleteId = this.dataset.id;
                new bootstrap.Modal(document.getElementById('deleteModal')).show();
            });
        });
        confirmDeleteBtn.addEventListener('click', function() {
            if (deleteId) {
                document.querySelector(`button[data-id="${deleteId}"]`).closest('td')
                    .querySelector('.delete-form').submit();
            }
        });
    });
</script>
@endsection
