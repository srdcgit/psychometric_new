@extends('layouts.app')

@section('content')
<style>
  .card-glass {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px) saturate(1.1);
    border-radius: 1rem;
    box-shadow: 0 12px 32px rgba(31,45,61,0.08), 0 1.5px 5px rgba(60,72,88,0.05);
    padding: 2rem 2.5rem;
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
  }
  select.form-select {
    width: 100%;
  }
  textarea.form-control {
    min-height: 150px;
  }
  .btn-primary {
    font-size: 1.1rem;
    padding: 0.6rem 1.25rem;
    border-radius: 0.5rem;
    width: 100%;
    margin-top: 1.5rem;
  }
</style>

<div class="card-glass">
  <h2>Create Careers</h2>
  <form method="POST" action="{{ route('career.store') }}">
    @csrf

    <div class="mb-4">
      <label for="career_category_id" class="form-label">Career Categories</label>
      <select name="career_category_id" id="career_category_id" class="form-select" required>
        <option value="" disabled selected>Select Option</option>
        @foreach ($career_categories as $career_category)
          <option value="{{ $career_category->id }}">{!! $career_category->name !!}</option>
        @endforeach
      </select>
      @error('career_category_id')
        <div class="text-danger mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-4">
      <label for="name" class="form-label">Add Careers</label>
      <textarea id="name" name="name" class="form-control">{{ old('name') }}</textarea>
      @error('name')
        <div class="text-danger mt-1">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-primary">Create</button>
  </form>
</div>

<!-- CKEditor 5 Script -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
  ClassicEditor
    .create(document.querySelector('#name'))
    .catch(error => {
      console.error(error);
    });
</script>
@endsection
