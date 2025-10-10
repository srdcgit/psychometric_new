<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        html,
        body {
            overflow-x: hidden;
            height: 100%;
        }

        .sign-email-text {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding-inline: 10px;
        }

        #login-form .input-box {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            gap: 5px;

        }

        #login-form .input-box input {
            width: 100%;
            height: 45px;
            border-radius: 30px;
            color: black;
            background: white;
            border: 2px solid #ece9e9;
            padding-left: 20px;
        }

        #login-form .input-box label {
            font-weight: bolder;
        }

        .form-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-info label {
            font-weight: bolder;
        }

        .form-info span a {
            color: #9F2D26;
            font-weight: 600;
        }

        .login-btn {
            width: 100%;
            height: 45px;
            background: #9F2D26;
            color: white;
            border-radius: 30px;
            margin-top: 30px;
        }


        /* right-part */

        .swiper {
            width: 100%;
            height: 690px;
            position: relative;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            /* background: #444; */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .career-slogan {
            /* position:absolute;
                                                    top:50px !important;
                                                    left:50%;
                                                    transform:translateX(-50%); */
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



        .google-logo-btn {
            width: 80px;
            height: 80px;
            border: 1px solid gainsboro;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            /* align-content: center; */
            flex-wrap: wrap !important;
        }

        .google-logo-btn svg {
            width: 40px;
            height: 40px;
        }


        .social-media-login-btns {
            scale: 0.9;
        }


        @media only screen and (max-width:991px) {
            .login-section .row>.col-lg-6:last-child {
                display: none;
            }

            .login-left-part {
                margin-top: 45px;
            }

            .sign-email-text {
                font-size: 11px;
                top: -9px;
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

    <section class="login-section" style="height:100%;">

        <div class="row align-items-stretch" style="height:100%;">
            <div class="col-lg-6" style="padding-inline:11.5vw;">

                <div class="login-left-part" style="scale:1;">
                    <div class="logo mt-2">
                        <a href="#">
                            <img src="{{ asset('images/footerlogo.png') }}" alt="login"
                                style="width:200px; height:70px;object-fit:contain; margin-left:-17px;">
                        </a>

                    </div>
                    <h3 class="mt-3 fw-bolder mb-0">Welcome Back</h3>
                    <span class="d-block mt-2">See your growth and consulting support</span>
                    <form method="POST" action="{{ route('login') }}" id="login-form" class="mt-5">
                        @csrf

                        <div class="input-box">
                            <label for="email-username">Email*</label>
                            <input type="text" id="username" name="email" value="" placeholder="Email"
                                required autocomplete="username">

                            {{-- Error message for email --}}
                            @error('email')
                                <p class="text-danger mt-1 small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-box mt-3 position-relative">
                            <label for="password">Password*</label>
                            <input type="password" id="password" name="password" placeholder="Password" required
                                autocomplete="current-password">
                            <span class="fa-solid fa-eye-slash toggle-password" data-target="password"></span>

                            {{-- Error message for password --}}
                            @error('password')
                                <p class="text-danger mt-1 small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-info mt-3">
                            <div class="remember-me-div d-flex justify-content-center align-items-center gap-2">
                                <input type="checkbox" name="" id="remember" style="accent-color:#9F2D26">
                                <label for="remember">Remember me</label>
                            </div>
                            <span><a href="{{ route('password.request') }}">Forgot Password?</a></span>
                        </div>

                        <button type="submit" class="login-btn" id="recaptcha">Sign In</button>

                        <p class="mt-3 mb-5"><span class="text-black fw-bold">Not registered yet?</span> <a
                                href="{{ route('register') }}" style="color:#9F2D26; font-weight:600;">Create an
                                Account</a>
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



    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>


    <script>
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const inputId = this.getAttribute('data-target');
            const input = document.getElementById(inputId);

            this.classList.toggle("fa-eye");

            if (input.type === "password" && this.classList.contains("fa-eye-slash")) {
                input.type = "text";

            } else {
                input.type = "password";

            }
        });
    </script>


    <script>
        var swiper = new Swiper(".mySwiper", {
            pagination: {
                el: ".swiper-pagination",
            },
            autoplay: true,
        });
    </script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
