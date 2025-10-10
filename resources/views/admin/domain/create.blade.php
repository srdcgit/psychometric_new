@extends('layouts.app')

@section('content')
<style>
  .card-glass {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px) saturate(1.1);
    border-radius: 1rem;
    box-shadow: 0 12px 30px rgba(31,45,61,0.08), 0 1.5px 5px rgba(60,72,88,0.07);
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
    display: block;
    color: #4a5568; /* Tailwind Gray 700 */
  }
  select.form-select, input.form-control, textarea.form-control {
    width: 100%;
    border: 1px solid #cbd5e0; /* Tailwind Gray 300 */
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 1rem;
  }
  textarea.form-control {
    min-height: 120px;
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
    color: #e53e3e;
    margin-top: 0.25rem;
    font-size: 0.875rem;
  }
</style>

<div class="card-glass">
  <h2>Create Domain</h2>
  <form method="POST" action="{{ route('domain.store') }}">
    @csrf

    <label for="name" class="form-label">Name</label>
    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <label for="display_name" class="form-label">Display Domain Name</label>
    <input id="display_name" name="display_name" type="text" class="form-control @error('display_name') is-invalid @enderror" value="{{ old('display_name') }}" required autofocus>
    @error('display_name') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <label for="scoring_type" class="form-label mt-4">Scoring Type</label>
    <select id="scoring_type" name="scoring_type" class="form-select @error('scoring_type') is-invalid @enderror" required>
      <option value="" disabled {{ old('scoring_type') ? '' : 'selected' }}>Select Option</option>
      <option value="likert" {{ old('scoring_type') == 'likert' ? 'selected' : '' }}>Likert</option>
      <option value="likert2" {{ old('scoring_type') == 'likert2' ? 'selected' : '' }}>Likert 2</option>
      <option value="objective" {{ old('scoring_type') == 'objective' ? 'selected' : '' }}>Objective</option>
      <option value="mcq" {{ old('scoring_type') == 'mcq' ? 'selected' : '' }}>MCQ</option>
    </select>
    @error('scoring_type') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <label for="description" class="form-label mt-4">Description</label>
    <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>

    <label for="instruction" class="form-label mt-4">Instruction</label>
    <textarea id="instruction" name="instruction" class="form-control">{{ old('instruction') }}</textarea>

    <label for="domain_weightage" class="form-label mt-4">Domain Weightage</label>
    <input id="domain_weightage" name="domain_weightage" type="number" class="form-control @error('domain_weightage') is-invalid @enderror" value="{{ old('domain_weightage') }}" required>
    @error('domain_weightage') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <button type="submit" class="btn btn-primary mt-5">Create</button>
  </form>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
  ClassicEditor.create(document.querySelector('#description'))
    .catch(error => console.error(error));

  ClassicEditor.create(document.querySelector('#instruction'))
    .catch(error => console.error(error));
</script>
@endsection