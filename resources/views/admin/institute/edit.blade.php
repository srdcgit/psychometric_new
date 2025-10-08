@extends('layouts.app')

@section('content')
<style>
  .card-glass {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px) saturate(1.2);
    border-radius: 1rem;
    box-shadow: 0 12px 32px rgba(31,45,61,0.08), 0 1.5px 5px rgba(60,72,88,0.05);
    padding: 2.5rem 3rem;
    max-width: 700px;
    margin: 40px auto;
  }
  h2 {
    font-weight: 700;
    margin-bottom: 2rem;
  }
  .form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
  }
  .invalid-feedback {
    display: block;
  }
  .btn-primary {
    font-size: 1.1rem;
    padding: 0.6rem 1.25rem;
    border-radius: 0.5rem;
  }
</style>

<div class="card-glass">
  <h2 class="text-center">Edit Institute</h2>

  @if ($errors->any())
    <div class="alert alert-danger mb-4">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('institute.update', $institute->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" 
             value="{{ old('name', $institute->name) }}" required autofocus>
      @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
             value="{{ old('email', $institute->email) }}" required>
      @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="address" class="form-label">Address</label>
      <input id="address" name="address" type="text" class="form-control @error('address') is-invalid @enderror"
             value="{{ old('address', $institute->address) }}" required>
      @error('address')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="contactperson" class="form-label">Contact Person</label>
      <input id="contactperson" name="contact_person" type="text" class="form-control @error('contact_person') is-invalid @enderror"
             value="{{ old('contact_person', $institute->contact_person) }}" required>
      @error('contact_person')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="mobile" class="form-label">Mobile</label>
      <input id="mobile" name="mobile" type="tel" maxlength="12" class="form-control @error('mobile') is-invalid @enderror"
             value="{{ old('mobile', $institute->mobile) }}" required>
      @error('mobile')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-4">
      <label for="allowedstudents" class="form-label">Allowed Students</label>
      <input id="allowedstudents" name="allowed_students" type="number" maxlength="12" class="form-control @error('allowed_students') is-invalid @enderror"
             value="{{ old('allowed_students', $institute->allowed_students) }}" required>
      @error('allowed_students')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>
</div>


<!-- CKEditor 5 Script -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
