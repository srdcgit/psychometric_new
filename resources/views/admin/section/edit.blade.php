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
    color: #4a5568; /* Gray-700 */
  }
  select.form-select, input.form-control, textarea.form-control {
    width: 100%;
    border: 1px solid #cbd5e0; /* Gray-300 */
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 1rem;
  }
  textarea.form-control {
    min-height: 100px;
  }
  img#image-preview {
    max-height: 120px;
    margin-top: 10px;
    border-radius: 0.5rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    display: none;
  }
  .btn-primary {
    font-size: 1.1rem;
    padding: 0.6rem 1.25rem;
    border-radius: 0.5rem;
  }
  .btn-secondary {
    background-color: #e2e8f0; /* Gray-200 */
    color: #2d3748; /* Gray-800 */
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
  <h2>Edit Section</h2>

  @if ($errors->any())
    <div class="alert alert-danger mb-4">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('section.update', $section->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="name">Section Name</label>
    <input type="text" name="name" id="name" value="{{ old('name', $section->name) }}" required class="form-control @error('name') is-invalid @enderror">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <label for="code" class="mt-4">Code</label>
    <input type="text" name="code" id="code" value="{{ old('code', $section->code) }}" required class="form-control @error('code') is-invalid @enderror">
    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <label for="domain_id" class="mt-4">Domain</label>
    <select name="domain_id" id="domain_id" required class="form-select @error('domain_id') is-invalid @enderror">
      <option value="">Select Domain</option>
      @foreach ($domains as $domain)
        @php
          $currentDomain = $section->domain ? $section->domain->name : '';
          $isSelected = old('domain_id', $currentDomain) == $domain->name || old('domain_id', $section->domain_id) == $domain->id;
          $value = ($domain->name == 'OCEAN' || $domain->name == 'Work Values') ? $domain->name : $domain->id;
        @endphp
        <option value="{{ $value }}" {{ $isSelected ? 'selected' : '' }}>
          {{ $domain->name }}
        </option>
      @endforeach
    </select>
    @error('domain_id') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <div id="low-group" class="mt-4">
      <label for="low">Low</label>
      <textarea name="low" id="low" rows="3" class="form-control">{{ old('low', $section->low) }}</textarea>
    </div>

    <div id="mid-group" class="mt-4">
      <label for="mid">Mid</label>
      <textarea name="mid" id="mid" rows="3" class="form-control">{{ old('mid', $section->mid) }}</textarea>
    </div>

    <div id="high-group" class="mt-4">
      <label for="high">High</label>
      <textarea name="high" id="high" rows="3" class="form-control">{{ old('high', $section->high) }}</textarea>
    </div>

    <div id="keytraits-group" class="mt-4">
      <label for="keytraits">Key Traits</label>
      <textarea name="keytraits" id="keytraits" rows="3" class="form-control">{{ old('keytraits', $section->keytraits) }}</textarea>
    </div>

    <div id="enjoys-group" class="mt-4">
      <label for="enjoys">Enjoys</label>
      <textarea name="enjoys" id="enjoys" rows="3" class="form-control">{{ old('enjoys', $section->enjoys) }}</textarea>
    </div>

    <div id="idealenvironments-group" class="mt-4">
      <label for="idealenvironments">Ideal Environments</label>
      <textarea name="idealenvironments" id="idealenvironments" rows="3" class="form-control">{{ old('idealenvironments', $section->idealenvironments) }}</textarea>
    </div>

    <label for="description" class="mt-4">Description</label>
    <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $section->description) }}</textarea>

    <label for="image" class="mt-4">Image</label>
    <input type="file" accept="image/*" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
    <div class="mt-2">
      @if($section->image)
        <img src="{{ asset($section->image) }}" alt="Current Image" style="max-height:120px; border-radius: 0.5rem;"/>
      @endif
      <img id="image-preview" src="#" alt="New Image Preview" style="display:none; max-height:120px; margin-top: 10px; border-radius: 0.5rem;" />
    </div>
    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <div class="form-actions">
      <a href="{{ route('section.index') }}" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Update Section</button>
    </div>
  </form>
</div>

<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
  function toggleFields() {
    const domain = document.getElementById('domain_id').value;
    const showSpecial = domain === 'OCEAN' || domain === 'Work Values';
    ['low-group', 'mid-group', 'high-group'].forEach(id => {
      document.getElementById(id).style.display = showSpecial ? 'block' : 'none';
    });
    ['keytraits-group', 'enjoys-group', 'idealenvironments-group'].forEach(id => {
      document.getElementById(id).style.display = showSpecial ? 'none' : 'block';
    });
  }

  document.getElementById('domain_id').addEventListener('change', toggleFields);
  window.addEventListener('DOMContentLoaded', toggleFields);

  document.getElementById('image').addEventListener('change', function(e) {
    const [file] = this.files;
    const img = document.getElementById('image-preview');
    if (file) {
      img.src = URL.createObjectURL(file);
      img.style.display = 'block';
    } else {
      img.style.display = 'none';
      img.src = '#';
    }
  });

  ClassicEditor.create(document.querySelector('#description')).catch(error => {
    console.error(error);
  });
</script>
@endsection
