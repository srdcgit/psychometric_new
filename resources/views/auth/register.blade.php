<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        html,
        body {
            overflow-x: hidden;
            height: 100%;
        }

        #register-form .input-box {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            gap: 5px;
        }

        #register-form .input-box input {
            width: 100%;
            height: 45px;
            border-radius: 30px;
            color: black;
            background: white;
            border: 2px solid #ece9e9;
            padding-left: 20px;
        }

        #register-form .input-box label {
            font-weight: bolder;
        }

        .login-btn {
            width: 100%;
            height: 45px;
            background: #9F2D26;
            color: white;
            border-radius: 30px;
            margin-top: 30px;
        }

        .career-slogan {
            color: transparent;
            background: linear-gradient(45deg, rgb(238, 238, 238), orange, rgb(157, 223, 243), rgb(253, 136, 136));
            -webkit-background-clip: text;
            font-weight: bolder;
            width: 36vw;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            margin: 30px auto 0px;
            font-size: 30px;
            top: 30px;
        }

        .swiper-slogan {
            position: absolute;
            bottom: 50px !important;
            left: 50%;
            transform: translateX(-50%);
            color: transparent;
            background: linear-gradient(45deg, rgb(153, 232, 238), rgb(250, 199, 89));
            -webkit-background-clip: text;
            font-weight: bolder;
            width: 26vw;
            display: inline-block;
            text-align: center;
            margin: 30px auto;
        }

        @media only screen and (max-width:991px) {
            .register-section .row>.col-lg-6:last-child {
                display: none;
            }

            .register-left-part {
                margin-top: 45px;
            }
        }

        .input-box {
            position: relative;
        }

        .input-box input[type="password"],
        .input-box input[type="text"] {
            padding-right: 40px;
            /* Space for the eye icon */
        }

        .toggle-password {
            position: absolute;
            top: 72%;
            right: 25px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 13px;
            color: #555;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .toggle-password:hover {
            color: #9F2D26;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <section class="register-section" style="height:100%;">
        <div class="row align-items-stretch" style="height:100%;">
            <div class="col-lg-6" style="padding-inline:11.5vw;">
                <div class="register-left-part" style="scale:1;">
                    <div class="logo mt-2">
                        <a href="#">
                            <img src="{{ asset('images/footerlogo.png') }}" alt="logo"
                                style="width:200px; height:70px;object-fit:contain; margin-left:-17px;">
                        </a>
                    </div>

                    <h3 class="mt-3 fw-bolder mb-0">Create Your Account</h3>
                    <span class="d-block mt-2">Start your career journey with us today!</span>

                    <form method="POST" action="{{ route('register') }}" id="register-form" class="mt-4">
                        @csrf

                        {{-- Name & Email --}}
                        <div class="row">
                            <div class="col-md-6 input-box">
                                <label for="name">Name*</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    autocomplete="name">
                                @error('name')
                                    <p class="text-danger mt-1 small">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6 input-box">
                                <label for="email">Email*</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    autocomplete="username">
                                @error('email')
                                    <p class="text-danger mt-1 small">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Age & Class --}}
                        <div class="row mt-3">
                            <div class="col-md-6 input-box">
                                <label for="age">Age*</label>
                                <input type="number" id="age" name="age" value="{{ old('age') }}"
                                    required>
                                @error('age')
                                    <p class="text-danger mt-1 small">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6 input-box">
                                <label for="class">Class*</label>
                                <input type="text" id="class" name="class" value="{{ old('class') }}"
                                    required>
                                @error('class')
                                    <p class="text-danger mt-1 small">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- School & Location --}}
                        <div class="row mt-3">
                            <div class="col-md-6 input-box">
                                <label for="school">School*</label>
                                <input type="text" id="school" name="school" value="{{ old('school') }}"
                                    required>
                                @error('school')
                                    <p class="text-danger mt-1 small">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6 input-box">
                                <label for="location">Location*</label>
                                <input type="text" id="location" name="location" value="{{ old('location') }}"
                                    required>
                                @error('location')
                                    <p class="text-danger mt-1 small">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Stream & Career Aspiration --}}
                        <div class="row mt-3">
                            <div class="col-md-6 input-box">
                                <label for="subjects_stream">Subjects / Stream*</label>
                                <input type="text" id="subjects_stream" name="subjects_stream"
                                    value="{{ old('subjects_stream') }}" required>
                                @error('subjects_stream')
                                    <p class="text-danger mt-1 small">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6 input-box">
                                <label for="career_aspiration">Career Aspiration</label>
                                <input type="text" id="career_aspiration" name="career_aspiration"
                                    value="{{ old('career_aspiration') }}">
                                @error('career_aspiration')
                                    <p class="text-danger mt-1 small">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Parental Occupation (full width) --}}
                        <div class="input-box mt-3">
                            <label for="parental_occupation">Parental Occupation</label>
                            <input type="text" id="parental_occupation" name="parental_occupation"
                                value="{{ old('parental_occupation') }}">
                            @error('parental_occupation')
                                <p class="text-danger mt-1 small">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password & Confirm Password --}}
                        <div class="row mt-3">
                            <div class="col-md-6 input-box position-relative">
                                <label for="password">Password*</label>
                                <input type="password" id="password" name="password" placeholder="Enter password"
                                    required autocomplete="new-password">
                                <span class="fa-solid fa-eye-slash toggle-password" data-target="password"></span>
                                @error('password')
                                    <p class="text-danger mt-1 small">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6 input-box position-relative">
                                <label for="password_confirmation">Confirm Password*</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Confirm password" required autocomplete="new-password">
                                <span class="fa-solid fa-eye-slash toggle-password"
                                    data-target="password_confirmation"></span>
                                @error('password_confirmation')
                                    <p class="text-danger mt-1 small">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <button type="submit" class="login-btn">Register</button>

                        <p class="mt-3 mb-5 text-center">
                            <span class="text-black fw-bold">Already registered?</span>
                            <a href="{{ route('login') }}" style="color:#9F2D26; font-weight:600;">Login here</a>
                        </p>
                    </form>

                </div>
            </div>

            <div class="col-lg-6" style="background:#9F2D26 ;">
                {{-- <div class="col-lg-6" style="background:var(--template-color);"> --}}
                <div class="login-right-part" style="position:relative;">

                    <h2 class="position-absolute career-slogan mb-2">"Your Career, Your Journey, Our Expertise."
                    </h2>

                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="swiper-image mt-2">
                                    <img src="{{ asset('images/b1.png') }}" alt=""
                                        style="width:100%; height:50%;object-fit:cover;">

                                    <span class="position-absolute swiper-slogan mb-2">Consistent Quality and
                                        experience
                                        across all verticals</span>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="swiper-image mt-2">
                                    <img src="{{ asset('images/b2.png') }}" alt=""
                                        style="width:100%; height:50%;object-fit:cover;">
                                    <span class="position-absolute swiper-slogan mb-2">Lorem ipsum dolor sit
                                        amet
                                        consectetur adipisicing elit. Placeat, deserunt.</span>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="swiper-image mt-2">
                                    <img src="{{ asset('images/b3.png') }}" alt=""
                                        style="width:100%; height:50%;object-fit:cover;">

                                    <span class="position-absolute swiper-slogan mb-2">Lorem ipsum dolor sit
                                        amet
                                        consectetur adipisicing elit. Placeat, deserunt.</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            pagination: {
                el: ".swiper-pagination",
            },
            autoplay: true,
        });

        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);

                if (input.type === "password") {
                    input.type = "text";
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                } else {
                    input.type = "password";
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                }
            });
        });
    </script>
</body>

</html>
