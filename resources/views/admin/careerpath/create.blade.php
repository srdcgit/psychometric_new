<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Create Career Paths</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4">
        <form method="POST" action="{{ route('careerpath.store') }}">
            @csrf



            {{-- Section --}}
            <div class="mt-4">
                <x-input-label for="section_id" :value="__('Section')" />
                <select name="section_id" id="section_id" required class="block w-full mt-1">
                    <option value="">Select Option</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="careers">Add Careers</label>
                <small class="text-muted">(Search and select multiple careers.)</small>

                <div class="multi-select-wrapper">
                    <div class="selected-options" id="selectedCareers"></div>

                    <input type="text" id="searchCareerInput" class="search-input form-control mb-2" placeholder="Search Careers">

                    <div class="options-list" id="careerOptionsList"></div>
                </div>
            </div>

            <!-- Hidden Select Field for Careers -->
            <select name="careers[]" id="careers-select" multiple class="d-none">
                @foreach ($careers as $career)
                    <option value="{{ $career->id }}">{{ strip_tags($career->name) }}</option>
                @endforeach
            </select>


            {{-- Submit --}}
            <div class="mt-4">
                <x-primary-button>{{ __('Create') }}</x-primary-button>
            </div>
        </form>
    </div>

    {{-- Select2 CSS & JS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const careers = @json($careers);
            const selectedCareersDiv = document.getElementById('selectedCareers');
            const searchCareerInput = document.getElementById('searchCareerInput');
            const careerOptionsList = document.getElementById('careerOptionsList');
            const hiddenCareerSelect = document.getElementById('careers-select');

            let selectedCareers = [];

            function renderCareerOptions(filter = '') {
                careerOptionsList.innerHTML = '';
                const filtered = careers.filter(c =>
                    c.name.toLowerCase().includes(filter.toLowerCase()) &&
                    !selectedCareers.some(sel => sel.id === c.id)
                );

                if (filtered.length > 0) {
                    filtered.forEach(career => {
                        const option = document.createElement('div');
                        option.textContent = career.name;
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
                    span.innerHTML = `${career.name} <i onclick="removeCareer(${career.id})">&times;</i>`;
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

            // Restore old input if available
            @if(old('careers'))
                const oldCareers = @json(old('careers'));
                oldCareers.forEach(id => {
                    const career = careers.find(c => c.id == id);
                    if (career) selectedCareers.push(career);
                });
                renderSelectedCareers();
            @endif
        });
        </script>


</x-app-layout>
