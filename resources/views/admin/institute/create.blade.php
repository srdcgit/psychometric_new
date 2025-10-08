@extends('layouts.app')

@section('content')
<style>
  .card-glass {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px) saturate(1.1);
    border-radius: 1rem;
    box-shadow: 0 12px 32px rgba(31,45,61,0.08), 0 1.5px 5px rgba(60,72,88,0.05);
    padding: 2.5rem 3rem;
    max-width: 600px;
    margin: 40px auto;
  }
  .form-label {
    font-weight: 600;
  }
  .btn-primary {
    font-size: 1.1rem;
    padding: 0.6rem 1.25rem;
    border-radius: 0.5rem;
  }
</style>

<div class="card-glass">
  <h2 class="mb-4 text-center fw-bold">Create Institute</h2>
  <form method="POST" action="{{ route('institute.store') }}">
    @csrf

    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}" autofocus>
      @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}">
      @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="address" class="form-label">Address</label>
      <input id="address" name="address" type="text" class="form-control @error('address') is-invalid @enderror" required value="{{ old('address') }}">
      @error('address')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="contactperson" class="form-label">Contact Person</label>
      <input id="contactperson" name="contact_person" type="text" class="form-control @error('contact_person') is-invalid @enderror" required value="{{ old('contact_person') }}">
      @error('contact_person')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="mobile" class="form-label">Mobile</label>
      <input id="mobile" name="mobile" type="tel" maxlength="12" class="form-control @error('mobile') is-invalid @enderror" required value="{{ old('mobile') }}">
      @error('mobile')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-4">
      <label for="allowedstudents" class="form-label">Allowed Students</label>
      <input id="allowedstudents" name="allowed_students" type="number" maxlength="12" class="form-control @error('allowed_students') is-invalid @enderror" required value="{{ old('allowed_students') }}">
      @error('allowed_students')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-primary">Create</button>
    </div>
  </form>
</div>
@endsection
