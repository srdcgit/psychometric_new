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
</style>

<div class="card-glass">
  <h2>Create Career Categories</h2>

  <form method="POST" action="{{ route('careercategory.store') }}">
    @csrf

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
        <textarea id="{{ $field }}" name="{{ $field }}" class="form-control">{{ old($field) }}</textarea>
      </div>
    @endforeach

    <button type="submit" class="btn btn-primary">Create</button>
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
    const el = document.querySelector(`#${id}`);
    if(el){
      ClassicEditor.create(el).catch(console.error);
    }
  });
</script>
@endsection
