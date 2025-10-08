@extends('layouts.app')

@section('content')
<style>
  .card-glass {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px) saturate(1.1);
    border-radius: 1rem;
    box-shadow: 0 12px 32px rgba(31,45,61,0.1), 0 1.5px 5px rgba(60,72,88,0.07);
    padding: 2.5rem 3rem;
    max-width: 700px;
    margin: 40px auto;
  }
  h2 {
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
  }
  label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: block;
    color: #4a5568; /* Tailwind Gray 700 */
  }
  input.form-control, select.form-select, textarea.form-control {
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
    min-width: 140px;
  }
  .btn-secondary {
    background-color: #e2e8f0; /* Tailwind Gray 200 */
    color: #2d3748; /* Tailwind Gray 800 */
    border-radius: 0.5rem;
    padding: 0.6rem 1.25rem;
    font-size: 1rem;
  }
  .btn-secondary:hover {
    background-color: #cbd5e0;
  }
  .form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
  }
</style>

<div class="card-glass">
  <h2>Edit Domain</h2>

  @if ($errors->any())
    <div class="alert alert-danger mb-4">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('domain.update', $domain->id) }}">
    @csrf
    @method('PUT')

    <label for="name">Domain Name</label>
    <input type="text" id="name" name="name" value="{{ old('name', $domain->name) }}" required
           class="form-control @error('name') is-invalid @enderror" />
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <label for="description" class="mt-4">Description</label>
    <textarea id="description" name="description"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $domain->description) }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror

    <label for="instruction" class="mt-4">Instruction</label>
    <textarea id="instruction" name="instruction"
              class="form-control @error('instruction') is-invalid @enderror">{{ old('instruction', $domain->instruction) }}</textarea>
    @error('instruction')<div class="invalid-feedback">{{ $message }}</div>@enderror

    <label for="scoring_type" class="mt-4">Scoring Type</label>
    <select id="scoring_type" name="scoring_type" required
            class="form-select @error('scoring_type') is-invalid @enderror">
      <option value="" disabled>Select Option</option>
      <option value="likert" {{ old('scoring_type', $domain->scoring_type) == 'likert' ? 'selected' : '' }}>Likert</option>
      <option value="likert2" {{ old('scoring_type', $domain->scoring_type) == 'likert2' ? 'selected' : '' }}>Likert 2</option>
      <option value="objective" {{ old('scoring_type', $domain->scoring_type) == 'objective' ? 'selected' : '' }}>Objective</option>
    </select>
    @error('scoring_type')<div class="invalid-feedback">{{ $message }}</div>@enderror

    <label for="domain_weightage" class="mt-4">Domain Weightage</label>
    <input type="number" id="domain_weightage" name="domain_weightage" value="{{ old('domain_weightage', $domain->domain_weightage) }}" required
           class="form-control @error('domain_weightage') is-invalid @enderror" />
    @error('domain_weightage')<div class="invalid-feedback">{{ $message }}</div>@enderror

    <div class="form-actions">
      <a href="{{ route('domain.index') }}" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Update Domain</button>
    </div>
  </form>
</div>

<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
  ClassicEditor.create(document.querySelector('#description'))
    .catch(error => console.error(error));

  ClassicEditor.create(document.querySelector('#instruction'))
    .catch(error => console.error(error));
</script>
@endsection
