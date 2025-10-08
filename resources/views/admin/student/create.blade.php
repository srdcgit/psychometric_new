@extends('layouts.app')

@section('content')
<style>
  .card-glass {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px) saturate(1.1);
    border-radius: 1rem;
    box-shadow: 0 12px 32px rgba(31,45,61,0.1), 0 1.5px 5px rgba(60,72,88,0.07);
    padding: 2.5rem 3rem;
    max-width: 600px;
    margin: 40px auto;
  }
  h2 {
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
  }
  .form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: block;
    color: #4a5568; /* Gray-700 */
  }
  select.form-select, input.form-control, textarea.form-control {
    width: 100%;
    border: 1px solid #cbd5e0; /* Gray-300 */
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 1rem;
  }
  select.form-select[disabled] {
    background-color: #e2e8f0; /* Gray-200 */
    cursor: not-allowed;
  }
  .btn-primary {
    font-size: 1.1rem;
    padding: 0.6rem 1.25rem;
    border-radius: 0.5rem;
    width: 100%;
    margin-top: 1.5rem;
  }
  .invalid-feedback {
    display: block;
    font-size: 0.875rem;
    color: #e53e3e; /* Red-600 */
    margin-top: 0.25rem;
  }
</style>

<div class="card-glass">
  <h2>Create Student</h2>
  <form method="POST" action="{{ route('students.store') }}" novalidate>
    @csrf

    <!-- Register Institute -->
    <label for="register_institute_id" class="form-label">Register Institution</label>
    <select id="register_institute_id" name="register_institute_id" class="form-select @error('register_institute_id') is-invalid @enderror" style="cursor:pointer;" required>
      <option value="" disabled selected>-- Select Institution --</option>
      @foreach ($institutes as $institute)
        @php
          $registered = \App\Models\User::where('register_institute_id', $institute->id)->count();
          $allowed = $institute->allowed_students;
        @endphp
        <option value="{{ $institute->id }}"
          {{ old('register_institute_id') == $institute->id ? 'selected' : '' }}
          {{ $registered >= $allowed ? 'disabled' : '' }}
          title="{{ $registered >= $allowed ? 'This institution has reached its limit' : '' }}">
          {{ $institute->name }} {!! $registered >= $allowed ? '(Full)' : '' !!}
        </option>
      @endforeach
    </select>
    @error('register_institute_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Name -->
    <label for="name" class="form-label mt-4">Name</label>
    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus autocomplete="name" />
    @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Email -->
    <label for="email" class="form-label mt-4">Email</label>
    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="username" />
    @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Age -->
    <label for="age" class="form-label mt-4">Age</label>
    <input id="age" name="age" type="number" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" required />
    @error('age')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Class -->
    <label for="class" class="form-label mt-4">Class</label>
    <input id="class" name="class" type="text" class="form-control @error('class') is-invalid @enderror" value="{{ old('class') }}" required />
    @error('class')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- School -->
    <label for="school" class="form-label mt-4">School</label>
    <input id="school" name="school" type="text" class="form-control @error('school') is-invalid @enderror" value="{{ old('school') }}" required />
    @error('school')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Location -->
    <label for="location" class="form-label mt-4">Location</label>
    <input id="location" name="location" type="text" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" required />
    @error('location')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Subjects/Stream -->
    <label for="subjects_stream" class="form-label mt-4">Subjects/Stream</label>
    <input id="subjects_stream" name="subjects_stream" type="text" class="form-control @error('subjects_stream') is-invalid @enderror" value="{{ old('subjects_stream') }}" required />
    @error('subjects_stream')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Career Aspiration -->
    <label for="career_aspiration" class="form-label mt-4">Career Aspiration</label>
    <input id="career_aspiration" name="career_aspiration" type="text" class="form-control @error('career_aspiration') is-invalid @enderror" value="{{ old('career_aspiration') }}" />
    @error('career_aspiration')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <!-- Parental Occupation -->
    <label for="parental_occupation" class="form-label mt-4">Parental Occupation</label>
    <input id="parental_occupation" name="parental_occupation" type="text" class="form-control @error('parental_occupation') is-invalid @enderror" value="{{ old('parental_occupation') }}" />
    @error('parental_occupation')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary mt-5">Create</button>
  </form>
</div>
@endsection
