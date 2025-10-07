<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img style="max-height: 44px;" src="https://identity.zpsdemo.in/assets/images/general/logo_white.png" alt="Identity">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @php
            $user = Auth::user();
            $isAdmin = $user && $user->rolls && $user->rolls->slug === 'admin';
            $isInstitute = $user && $user->rolls && $user->rolls->slug === 'institute';
        @endphp

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                </li>

                @if ($isAdmin)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('institute.index') ? 'active' : '' }}" href="{{ route('institute.index') }}">{{ __('Institute') }}</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ (request()->routeIs('careercategory.index') || request()->routeIs('careerpath.index') || request()->routeIs('career.index')) ? 'active' : '' }}" href="#" id="careerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('Career') }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="careerDropdown">
                            <li><a class="dropdown-item" href="{{ route('careercategory.index') }}">{{ __('Career Category') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('career.index') }}">{{ __('Career') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('careerpath.index') }}">{{ __('Career Paths') }}</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}" href="{{ route('students.index') }}">{{ __('Students') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('domain.index') ? 'active' : '' }}" href="{{ route('domain.index') }}">{{ __('Domain') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('section.index') ? 'active' : '' }}" href="{{ route('section.index') }}">{{ __('Section') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('question.index') ? 'active' : '' }}" href="{{ route('question.index') }}">{{ __('Question') }}</a>
                    </li>
                @elseif ($isInstitute)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('institutestudent.index') ? 'active' : '' }}" href="{{ route('institutestudent.index') }}">{{ __('Student List') }}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('assessment.index') ? 'active' : '' }}" href="{{ route('assessment.index') }}">{{ __('Assessment') }}</a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
