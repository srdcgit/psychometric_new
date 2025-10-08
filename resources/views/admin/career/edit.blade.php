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
  h2 {
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
  }
  .form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: block;
    color: #4a5568; /* Tailwind Gray 700 */
  }
  select.form-select {
    width: 100%;
    border: 1px solid #cbd5e0; /* Tailwind Gray 300 */
    border-radius: 0.375rem;
    padding: 0.5rem;
    font-size: 1rem;
  }
  textarea.form-textarea {
    width: 100%;
    min-height: 120px;
    border: 1px solid #cbd5e0;
    border-radius: 0.375rem;
    padding: 0.5rem;
    font-size: 1rem;
    resize: vertical;
  }
  .btn-primary {
    font-size: 1.1rem;
    padding: 0.6rem 1.25rem;
    border-radius: 0.5rem;
    min-width: 140px;
  }
  .btn-secondary {
    background-color: #e2e8f0; /* Tailwind Gray 200 */
    color: #2d3748; /* Tailwind Gray 800 */
    border-radius: 0.5rem;
    padding: 0.6rem 1.25rem;
    font-size: 1rem;
    min-width: 120px;
  }
  .btn-secondary:hover {
    background-color: #cbd5e0; /* Slightly darker */
  }
  .form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
  }
  .alert-validation {
    color: #e53e3e; /* Tailwind red-600 */
    margin-bottom: 1rem;
    border-left: 4px solid #e53e3e;
    padding-left: 1rem;
  }
</style>

<div class="card-glass">
  <h2>Edit Career</h2>

  @if ($errors->any())
    <div class="alert-validation">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('career.update', $career->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="career_category_id" class="form-label">Career Category</label>
    <select name="career_category_id" id="career_category_id" required class="form-select">
      <option value="">Select Career Category</option>
      @foreach ($career_categories as $career_category)
        <option value="{{ $career_category->id }}" 
            {{ old('career_category_id', $career->career_category_id) == $career_category->id ? 'selected' : '' }}>
          {!! $career_category->name !!}
        </option>
      @endforeach
    </select>

    <label for="name" class="form-label mt-4">Careers</label>
    <textarea name="name" id="name" class="form-textarea">{{ old('name', $career->name) }}</textarea>

    <div class="form-actions">
      <a href="{{ route('career.index') }}" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Update Career</button>
    </div>
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
