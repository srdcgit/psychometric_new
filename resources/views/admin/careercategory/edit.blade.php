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
    color: #4a5568;
    margin-bottom: 0.5rem;
    display: block;
  }
  textarea.form-control {
    width: 100%;
    border-radius: 0.375rem;
    border: 1px solid #cbd5e0;
    padding: 0.5rem;
    min-height: 120px;
    font-size: 1rem;
  }
  .btn-primary {
    width: 100%;
    padding: 0.75rem 1.25rem;
    font-size: 1.1rem;
    border-radius: 0.5rem;
    margin-top: 2rem;
  }
  .btn-group {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
  }
  .btn-secondary {
    background-color: #e2e8f0;
    color: #2d3748;
    padding: 0.75rem 1.25rem;
    border-radius: 0.5rem;
    font-size: 1rem;
    text-decoration: none;
    display: inline-block;
  }
  .btn-secondary:hover {
    background-color: #cbd5e0;
    color: #1a202c;
    text-decoration: none;
  }
</style>

<div class="card-glass">
  <h2>Edit Career Categories</h2>

  @if ($errors->any())
    <div class="alert alert-danger mb-4">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('careercategory.update', $career->id) }}" method="POST">
    @csrf
    @method('PUT')

    @foreach ([
      'name' => 'Career Category Name',
      'hook' => 'Hook',
      'what_is_it' => 'What is it?',
      'example_roles' => 'Example roles',
      'subjects' => 'Subjects',
      'core_apptitudes_to_highlight' => 'Core aptitudes to highlight',
      'value_and_personality_edge' => 'Value and personality edge',
      'why_it_could_fit_you' => 'Why it could fit you',
      'early_actions' => 'Early actions',
      'india_study_pathways' => 'India study pathways',
      'future_trends' => 'Future trends'
    ] as $field => $label)
      <div class="mb-4">
        <label for="{{ $field }}">{{ $label }}</label>
        <textarea id="{{ $field }}" name="{{ $field }}" class="form-control">{{ old($field, $career->$field) }}</textarea>
      </div>
    @endforeach

    <div class="btn-group">
      <a href="{{ route('careercategory.index') }}" class="btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Update Career Category</button>
    </div>
  </form>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
  const editorIds = [
    'name',
    'hook',
    'what_is_it',
    'example_roles',
    'subjects',
    'core_apptitudes_to_highlight',
    'value_and_personality_edge',
    'why_it_could_fit_you',
    'early_actions',
    'india_study_pathways',
    'future_trends'
  ];
  editorIds.forEach(id => {
    const el = document.getElementById(id);
    if (el) {
      ClassicEditor.create(el).catch(console.error);
    }
  });
</script>
@endsection
