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
    color: #4a5568;
  }
  select.form-select, input.form-control, textarea.form-control {
    width: 100%;
    border: 1px solid #cbd5e0;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 1rem;
  }
  textarea.form-control {
    min-height: 100px;
  }
  .btn-primary {
    font-size: 1.1rem;
    padding: 0.6rem 1.25rem;
    border-radius: 0.5rem;
    width: 100%;
    margin-top: 1.5rem;
  }
  #image-preview {
    max-height: 120px;
    margin-top: 10px;
    display: none;
    border-radius: 0.5rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
</style>

<div class="card-glass">
  <h2>Create Section</h2>

  <form method="POST" action="{{ route('section.store') }}" enctype="multipart/form-data" novalidate>
    @csrf

    <label for="name">Name</label>
    <input type="text" name="name" id="name" required class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <label for="code" class="mt-4">Code</label>
    <input type="text" name="code" id="code" required class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}">
    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <label for="domain_id" class="mt-4">Domain</label>
    <select name="domain_id" id="domain_id" required class="form-select @error('domain_id') is-invalid @enderror">
      <option value="">Select Domain</option>
      @foreach ($domains as $domain)
        <option value="{{ $domain->name == 'OCEAN' ? 'OCEAN' : ($domain->name == 'WORK VALUES' ? 'WORK VALUES' : $domain->id) }}"
          {{ old('domain_id') == $domain->name || old('domain_id') == $domain->id ? 'selected' : '' }}>
          {{ $domain->name }}
        </option>
      @endforeach
    </select>
    @error('domain_id') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <div id="low-group" class="mt-4">
      <label for="low">Low</label>
      <textarea name="low" id="low" class="form-control">{{ old('low') }}</textarea>
    </div>

    <div id="mid-group" class="mt-4">
      <label for="mid">Mid</label>
      <textarea name="mid" id="mid" class="form-control">{{ old('mid') }}</textarea>
    </div>

    <div id="high-group" class="mt-4">
      <label for="high">High</label>
      <textarea name="high" id="high" class="form-control">{{ old('high') }}</textarea>
    </div>

    <div id="keytraits-group" class="mt-4">
      <label for="keytraits">Key Traits</label>
      <textarea name="keytraits" id="keytraits" class="form-control">{{ old('keytraits') }}</textarea>
    </div>

    <div id="enjoys-group" class="mt-4">
      <label for="enjoys">Enjoys</label>
      <textarea name="enjoys" id="enjoys" class="form-control">{{ old('enjoys') }}</textarea>
    </div>

    <div id="idealenvironments-group" class="mt-4">
      <label for="idealenvironments">Ideal Environments</label>
      <textarea name="idealenvironments" id="idealenvironments" class="form-control">{{ old('idealenvironments') }}</textarea>
    </div>

    <label for="description" class="mt-4">Description</label>
    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>

    <label for="image" class="mt-4">Image</label>
    <input type="file" accept="image/*" name="image" id="image" class="form-control">
    <img id="image-preview" alt="Image Preview" />

    <button type="submit" class="btn btn-primary mt-5">Create</button>
  </form>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
  function toggleFields() {
    const domain = document.getElementById('domain_id').value;
    const showSpecial = domain === 'OCEAN' || domain === 'WORK VALUES';
    ['low-group', 'mid-group', 'high-group'].forEach(id => {
      document.getElementById(id).style.display = showSpecial ? 'block' : 'none';
    });
    ['keytraits-group', 'enjoys-group', 'idealenvironments-group'].forEach(id => {
      document.getElementById(id).style.display = showSpecial ? 'none' : 'block';
    });
  }

  document.getElementById('domain_id').addEventListener('change', toggleFields);
  window.addEventListener('DOMContentLoaded', toggleFields);

  document.getElementById('image').addEventListener('change', function() {
    const [file] = this.files;
    const preview = document.getElementById('image-preview');
    if (file) {
      preview.src = URL.createObjectURL(file);
      preview.style.display = 'block';
    } else {
      preview.src = '';
      preview.style.display = 'none';
    }
  });

  ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
</script>
@endsection
