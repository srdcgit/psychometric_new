<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Career Paths</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4">
        <form action="{{ route('careerpath.update', $career->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Section --}}
            <div class="mt-4">
                <x-input-label for="section_id" :value="__('Section')" />
                <select name="section_id" id="section_id" required class="block w-full mt-1">
                    <option value="">Select Option</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}" {{ old('section_id', $career->section_id) == $section->id ? 'selected' : '' }}>
                            {{ $section->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <br>

            <div class="form-group">
                <label for="careers">Add Careers</label>
                <small class="text-muted">(Search and select multiple careers.)</small>

                <div class="multi-select-wrapper">
                    <div class="selected-options" id="selectedCareers"></div>

                    <input type="text" id="searchCareerInput" class="search-input form-control mb-2"
                        placeholder="Search Careers">

                    <div class="options-list" id="careerOptionsList"></div>
                </div>
            </div>

            <!-- Hidden Select Field for Careers -->
            <select name="careers[]" id="careers-select" multiple class="d-none">
                @foreach ($careers as $career_option)
                    <option value="{{ $career_option->id }}">{!! $career_option->name !!}</option>
                @endforeach
            </select>

            {{-- Submit --}}
            <div class="mt-4">
                <x-primary-button>{{ __('Update') }}</x-primary-button>
            </div>
        </form>
    </div>

    <style>
        .multi-select-wrapper {
            position: relative;
        }
        
        .selected-options {
            min-height: 40px;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 8px;
            background-color: white;
        }
        
        .search-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 14px;
        }
        
        .options-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            max-height: 200px;
            overflow-y: auto;
            z-index: 10;
            display: none;
        }
        
        .options-list div {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .options-list div:hover {
            background-color: #f3f4f6;
        }
        
        .options-list div:last-child {
            border-bottom: none;
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const careers = @json($careers);
            const selectedCareersDiv = document.getElementById('selectedCareers');
            const searchCareerInput = document.getElementById('searchCareerInput');
            const careerOptionsList = document.getElementById('careerOptionsList');
            const hiddenCareerSelect = document.getElementById('careers-select');

            let selectedCareers = [];

            // Load existing selected careers
            @if($career->careers)
                const existingCareers = @json($career->careers);
                existingCareers.forEach(career => {
                    selectedCareers.push(career);
                });
            @endif

            function renderCareerOptions(filter = '') {
                careerOptionsList.innerHTML = '';
                const filtered = careers.filter(c => {
                    const cleanName = c.name.replace(/<[^>]*>/g, '').trim();
                    return cleanName.toLowerCase().includes(filter.toLowerCase()) &&
                        !selectedCareers.some(sel => sel.id === c.id);
                });

                if (filtered.length > 0) {
                    filtered.forEach(career => {
                        const option = document.createElement('div');
                        const cleanName = career.name.replace(/<[^>]*>/g, '').trim();
                        option.textContent = cleanName;
                        option.dataset.id = career.id;
                        option.onclick = () => selectCareer(career);
                        careerOptionsList.appendChild(option);
                    });
                    careerOptionsList.style.display = 'block';
                } else {
                    careerOptionsList.style.display = 'none';
                }
            }

            function renderSelectedCareers() {
                selectedCareersDiv.innerHTML = '';
                Array.from(hiddenCareerSelect.options).forEach(opt => opt.selected = false);

                selectedCareers.forEach(career => {
                    const span = document.createElement('span');
                    span.className = 'inline-flex items-center bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full mr-2 mb-2';
                    
                    const cleanName = career.name.replace(/<[^>]*>/g, '').trim();
                    const text = document.createTextNode(cleanName);
                    span.appendChild(text);

                    const removeIcon = document.createElement('button');
                    removeIcon.type = 'button';
                    removeIcon.className = 'ml-2 text-blue-600 hover:text-blue-800 font-bold text-lg leading-none';
                    removeIcon.innerHTML = '×';
                    removeIcon.onclick = () => removeCareer(career.id);

                    span.appendChild(removeIcon);
                    selectedCareersDiv.appendChild(span);

                    const option = hiddenCareerSelect.querySelector(`option[value="${career.id}"]`);
                    if (option) option.selected = true;
                });
            }

            function selectCareer(career) {
                if (!selectedCareers.find(c => c.id === career.id)) {
                    selectedCareers.push(career);
                    renderSelectedCareers();
                    searchCareerInput.value = '';
                    renderCareerOptions();
                }
            }

            function removeCareer(id) {
                selectedCareers = selectedCareers.filter(c => c.id !== id);
                renderSelectedCareers();
                renderCareerOptions();
            }

            searchCareerInput.addEventListener('input', e => renderCareerOptions(e.target.value));
            searchCareerInput.addEventListener('focus', () => renderCareerOptions(searchCareerInput.value));

            document.addEventListener('click', e => {
                if (!e.target.closest('.multi-select-wrapper')) {
                    careerOptionsList.style.display = 'none';
                }
            });

            // Initial render
            renderSelectedCareers();
            renderCareerOptions();
        });
    </script>
</x-app-layout>
