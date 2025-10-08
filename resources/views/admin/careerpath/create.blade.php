@extends('layouts.app')

@section('content')
<style>
.header-gradient {
    background: linear-gradient(90deg, #624bff 0, #29b6f6 100%);
    color: #fff;
    border-radius: 1rem;
    box-shadow: 0 8px 24px rgba(60,72,88,0.1);
}
.card-glass {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(8px) saturate(1.2);
    border-radius: 1rem;
    box-shadow: 0 12px 32px rgba(31,45,61,0.08), 0 1.5px 5px rgba(60,72,88,0.05);
    padding: 2rem;
    max-width: 640px;
    margin: 0 auto;
}
.form-label {
    font-weight: 600;
}
.multi-select-wrapper {
    position: relative;
}
.selected-options {
    min-height: 40px;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    padding: 8px;
    background-color: white;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}
.selected-options span {
    background-color: #dbeafe; /* Tailwind blue-100 */
    color: #1e40af; /* Tailwind blue-800 */
    padding: 4px 10px;
    border-radius: 9999px; /* fully rounded */
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
}
.selected-options button {
    background: none;
    border: none;
    color: #1e40af;
    margin-left: 8px;
    cursor: pointer;
    font-weight: bold;
    font-size: 1.1rem;
    line-height: 1;
}
.search-input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-top: none;
    border-radius: 0 0 0.375rem 0.375rem;
    font-size: 14px;
}
.options-list {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 0 0 0.375rem 0.375rem;
    max-height: 200px;
    overflow-y: auto;
    z-index: 20;
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

<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center header-gradient p-4 mb-4 rounded">
        <div class="d-flex align-items-center gap-3">
            <!-- Career SVG icon -->
           <svg height="40px" width="40px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffffff;} </style> <g> <path class="st0" d="M275.175,74.728c20.637,0,37.372-16.728,37.372-37.364C312.547,16.727,295.812,0,275.175,0 c-20.629,0-37.357,16.727-37.357,37.364C237.818,58,254.546,74.728,275.175,74.728z"></path> <polygon class="st0" points="372.199,419.995 282.451,419.995 282.451,354.645 192.737,354.645 192.737,289.282 102.993,289.282 102.993,223.918 26.559,223.918 26.559,250.56 76.359,250.56 76.359,315.923 166.103,315.923 166.103,381.287 255.817,381.287 255.817,446.637 345.568,446.637 345.568,512 460.237,512 460.237,485.366 372.199,485.359 "></polygon> <path class="st0" d="M477.983,181.243c-0.636-4.242-4.588-7.168-8.838-6.532l-17.934,2.695l-1.532-10.195 c-0.636-4.147-4.494-6.987-8.635-6.373l-1.878,0.282c-0.261-1.734-0.86-3.447-1.85-5.022l-25.897-41.411 c-2.796-4.466-7.052-7.819-12.053-9.488L352.48,83.334c-15.857-7.392-34.21-6.597-49.42,1.821l-9.748,59.294l-36.128-30.63 l-28.882,18.187l-42.183-19.799c-6.554-3.671-14.82-1.495-18.714,4.92l-0.535,0.867c-1.922,3.187-2.514,6.994-1.618,10.601 c0.888,3.606,3.194,6.705,6.387,8.612l50.277,30.002c6.25,3.736,13.874,4.408,20.687,1.836l29.777-16.041l14.119,56.952 l-46.932-0.238c-7.905-0.022-15.412,3.483-20.456,9.574c-5.044,6.091-7.088,14.119-5.586,21.887l15.788,81.282 c1.748,9.003,10.282,15.03,19.35,13.672l0.679-0.102c8.982-1.344,15.347-9.458,14.516-18.498l-5.347-58.24l70.819,1.648 c10.167,0.231,19.889-4.156,26.443-11.937c6.554-7.775,9.22-18.108,7.262-28.094l-1.814-9.205l-14.564-82.2l37.534,5.542 l27.458,31.844c-1.618,1.648-2.565,3.902-2.204,6.359l1.532,10.21l-17.927,2.695c-4.249,0.636-7.168,4.595-6.525,8.844l7.363,48.99 c0.644,4.241,4.596,7.168,8.838,6.532l76.101-11.446c4.242-0.636,7.161-4.596,6.525-8.844L477.983,181.243z M295.162,168.496 c0-2.558,2.074-4.625,4.624-4.625s4.624,2.067,4.624,4.625c0,2.558-2.074,4.624-4.624,4.624S295.162,171.054,295.162,168.496z M304.714,199.018c-2.551,0-4.625-2.066-4.625-4.624s2.074-4.624,4.625-4.624c2.55,0,4.624,2.066,4.624,4.624 S307.265,199.018,304.714,199.018z M416.745,172.644c4.329,4.205,10.984,5,16.157,1.719l0.304-0.195 c2.182-1.38,3.801-3.316,4.827-5.484l4.104-0.621l0.318,0.232l1.532,10.202l-25.781,3.873L416.745,172.644z"></path> <path class="st0" d="M393.667,384.835c6.286,6.568,16.67,6.965,23.44,0.888l0.485-0.426c6.749-6.055,7.486-16.381,1.676-23.353 l-38.701-51.932l-12.342-60.126c-0.838,1.207-1.698,2.4-2.652,3.534c-9.205,10.932-22.692,17.204-36.992,17.204l-6.576-0.152 l14.43,46.909c3.338,6.908,7.681,13.296,12.873,18.968L393.667,384.835z"></path> <polygon class="st0" points="273.983,118.899 285.913,125.026 290.848,111.818 284.41,98.075 268.766,107.757 "></polygon> </g> </g></svg>
            <div>
                <h2 class="fs-3 fw-bold mb-0">Create Career Path</h2>
                <div class="fs-6 mt-1">Add new career paths with associated sections and careers.</div>
            </div>
        </div>
    </div>

    <div class="card-glass">
        <form method="POST" action="{{ route('careerpath.store') }}">
            @csrf

            <!-- Sections Multi-select -->
            <div class="mb-4">
                <label for="searchSectionInput" class="form-label">Sections</label>
                <div class="multi-select-wrapper">
                    <div class="selected-options" id="selectedSections"></div>
                    <input type="text" id="searchSectionInput" class="search-input" placeholder="Search Sections">
                    <div class="options-list" id="sectionOptionsList"></div>
                </div>
                <select name="sections[]" id="sections-select" multiple class="d-none">
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}">{{ strip_tags($section->name) }}</option>
                    @endforeach
                </select>
                @error('sections') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Careers Multi-select -->
            <div class="mb-4">
                <label for="searchCareerInput" class="form-label">Careers</label>
                <small class="text-muted d-block mb-2">Search and select multiple careers.</small>
                <div class="multi-select-wrapper">
                    <div class="selected-options" id="selectedCareers"></div>
                    <input type="text" id="searchCareerInput" class="search-input" placeholder="Search Careers">
                    <div class="options-list" id="careerOptionsList"></div>
                </div>
                <select name="careers[]" id="careers-select" multiple class="d-none">
                    @foreach($careers as $career)
                        <option value="{{ $career->id }}">{!! strip_tags($career->name) !!}</option>
                    @endforeach
                </select>
                @error('careers') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mt-4 d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Create Career Path</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sections = @json($sections);
    const selectedSectionsDiv = document.getElementById('selectedSections');
    const searchSectionInput = document.getElementById('searchSectionInput');
    const sectionOptionsList = document.getElementById('sectionOptionsList');
    const hiddenSectionSelect = document.getElementById('sections-select');

    let selectedSections = [];

    function renderSectionOptions(filter = '') {
        sectionOptionsList.innerHTML = '';
        const filtered = sections.filter(s => {
            const cleanName = (s.name ?? '').toString().replace(/<[^>]*>/g, '').trim();
            return cleanName.toLowerCase().includes(filter.toLowerCase()) &&
                !selectedSections.some(sel => sel.id === s.id);
        });

        if (filtered.length > 0) {
            filtered.forEach(section => {
                const option = document.createElement('div');
                const cleanName = (section.name ?? '').toString().replace(/<[^>]*>/g, '').trim();
                option.textContent = cleanName;
                option.dataset.id = section.id;
                option.onclick = () => selectSection(section);
                sectionOptionsList.appendChild(option);
            });
            sectionOptionsList.style.display = 'block';
        } else {
            sectionOptionsList.style.display = 'none';
        }
    }

    function renderSelectedSections() {
        selectedSectionsDiv.innerHTML = '';
        Array.from(hiddenSectionSelect.options).forEach(opt => opt.selected = false);

        selectedSections.forEach(section => {
            const span = document.createElement('span');
            span.className = 'inline-flex items-center bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full mr-2 mb-2';

            const cleanName = (section.name ?? '').toString().replace(/<[^>]*>/g, '').trim();
            const text = document.createTextNode(cleanName);
            span.appendChild(text);

            const removeIcon = document.createElement('button');
            removeIcon.type = 'button';
            removeIcon.className = 'ml-2 text-blue-600 hover:text-blue-800 font-bold text-lg leading-none';
            removeIcon.innerHTML = '×';
            removeIcon.onclick = () => removeSection(section.id);

            span.appendChild(removeIcon);
            selectedSectionsDiv.appendChild(span);

            const option = hiddenSectionSelect.querySelector(`option[value="${section.id}"]`);
            if (option) option.selected = true;
        });

        // Maintain order
        selectedSections.forEach(section => {
            const option = hiddenSectionSelect.querySelector(`option[value="${section.id}"]`);
            if (option) hiddenSectionSelect.appendChild(option);
        });
    }

    function selectSection(section) {
        if (!selectedSections.find(s => s.id === section.id)) {
            selectedSections.push(section);
            renderSelectedSections();
            searchSectionInput.value = '';
            renderSectionOptions();
        }
    }

    function removeSection(id) {
        selectedSections = selectedSections.filter(s => s.id !== id);
        renderSelectedSections();
        renderSectionOptions();
    }

    searchSectionInput.addEventListener('input', e => renderSectionOptions(e.target.value));
    searchSectionInput.addEventListener('focus', () => renderSectionOptions(searchSectionInput.value));

    // Careers
    const careers = @json($careers);
    const selectedCareersDiv = document.getElementById('selectedCareers');
    const searchCareerInput = document.getElementById('searchCareerInput');
    const careerOptionsList = document.getElementById('careerOptionsList');
    const hiddenCareerSelect = document.getElementById('careers-select');

    let selectedCareers = [];

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

    // Hide options if clicked outside
    document.addEventListener('click', e => {
        if (!e.target.closest('.multi-select-wrapper')) {
            careerOptionsList.style.display = 'none';
            sectionOptionsList.style.display = 'none';
        }
    });

    // Restore old inputs
    @if (old('sections'))
        const oldSections = @json(old('sections'));
        oldSections.forEach(id => {
            const section = sections.find(s => s.id == id);
            if (section) selectedSections.push(section);
        });
        renderSelectedSections();
    @endif

    @if (old('careers'))
        const oldCareers = @json(old('careers'));
        oldCareers.forEach(id => {
            const career = careers.find(c => c.id == id);
            if (career) selectedCareers.push(career);
        });
        renderSelectedCareers();
    @endif
});
</script>

@endsection
