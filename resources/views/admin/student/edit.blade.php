@extends('layouts.app')

@section('content')
<style>
  .card-glass {
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(8px) saturate(1.1);
    border-radius: 1rem;
    box-shadow: 0 12px 30px rgba(31,45,61,0.1), 0 1.5px 5px rgba(60,72,88,0.07);
    padding: 2.5rem 3rem;
    max-width: 700px;
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
    color: #4a5568; /* Tailwind gray-700 */
  }
  select.form-select, input.form-control {
    width: 100%;
    border: 1px solid #cbd5e0; /* Tailwind gray-300 */
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 1rem;
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
    color: #e53e3e; /* Tailwind red-600 */
    margin-top: 0.25rem;
    font-size: .875rem;
  }
</style>

<div class="card-glass">
  <h2>Edit Student</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('students.update', $student->id) }}">
    @csrf
    @method('PUT')

    {{-- Register Institution --}}
    <label for="register_institute_id" class="form-label">Register Institution</label>
    <select id="register_institute_id" name="register_institute_id" class="form-select @error('register_institute_id') is-invalid @enderror" required>
      <option value="" disabled>Select Institution</option>
      @foreach ($institutes as $institute)
        <option value="{{ $institute->id }}" {{ old('register_institute_id', $student->register_institute_id) == $institute->id ? 'selected' : '' }}>
          {{ $institute->name }}
        </option>
      @endforeach
    </select>
    @error('register_institute_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    {{-- Name --}}
    <label for="name" class="form-label mt-4">Name</label>
    <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
           value="{{ old('name', $student->name) }}" required autofocus>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror

    {{-- Email --}}
    <label for="email" class="form-label mt-4">Email</label>
    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
           value="{{ old('email', $student->email) }}" required>
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror

    {{-- Age --}}
    <label for="age" class="form-label mt-4">Age</label>
    <input id="age" type="number" name="age" class="form-control @error('age') is-invalid @enderror" 
           value="{{ old('age', $student->age) }}" required>
    @error('age') <div class="invalid-feedback">{{ $message }}</div> @enderror

    {{-- Class --}}
    <label for="class" class="form-label mt-4">Class</label>
    <input id="class" type="text" name="class" class="form-control @error('class') is-invalid @enderror" 
           value="{{ old('class', $student->class) }}" required>
    @error('class') <div class="invalid-feedback">{{ $message }}</div> @enderror

    {{-- School --}}
    <label for="school" class="form-label mt-4">School</label>
    <input id="school" type="text" name="school" class="form-control @error('school') is-invalid @enderror" 
           value="{{ old('school', $student->school) }}" required>
    @error('school') <div class="invalid-feedback">{{ $message }}</div> @enderror

    {{-- Location --}}
    <label for="location" class="form-label mt-4">Location</label>
    <input id="location" type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
           value="{{ old('location', $student->location) }}" required>
    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror

    {{-- Subjects/Stream --}}
    <label for="subjects_stream" class="form-label mt-4">Subjects/Stream</label>
    <input id="subjects_stream" type="text" name="subjects_stream" class="form-control @error('subjects_stream') is-invalid @enderror" 
           value="{{ old('subjects_stream', $student->subjects_stream) }}" required>
    @error('subjects_stream') <div class="invalid-feedback">{{ $message }}</div> @enderror

    {{-- Career Aspiration --}}
    <label for="career_aspiration" class="form-label mt-4">Career Aspiration</label>
    <input id="career_aspiration" type="text" name="career_aspiration" class="form-control @error('career_aspiration') is-invalid @enderror" 
           value="{{ old('career_aspiration', $student->career_aspiration) }}">
    @error('career_aspiration') <div class="invalid-feedback">{{ $message }}</div> @enderror

    {{-- Parental Occupation --}}
    <label for="parental_occupation" class="form-label mt-4">Parental Occupation</label>
    <input id="parental_occupation" type="text" name="parental_occupation" class="form-control @error('parental_occupation') is-invalid @enderror" 
           value="{{ old('parental_occupation', $student->parental_occupation) }}">
    @error('parental_occupation') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <button type="submit" class="btn btn-primary mt-5">Update</button>
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
