<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | Forgot Password</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

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

        #forgot-form .input-box {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            gap: 5px;
        }

        #forgot-form .input-box input {
            width: 100%;
            height: 45px;
            border-radius: 30px;
            color: black;
            background: white;
            border: 2px solid #ece9e9;
            padding-left: 20px;
        }

        #forgot-form .input-box label {
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
            .login-section .row>.col-lg-6:last-child {
                display: none;
            }

            .login-left-part {
                margin-top: 45px;
            }
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
                            <img src="{{ asset('images/footerlogo.png') }}" alt="logo"
                                style="width:200px; height:70px;object-fit:contain; margin-left:-17px;">
                        </a>
                    </div>

                    <h3 class="mt-3 fw-bolder mb-0">Forgot Password?</h3>
                    <span class="d-block mt-2">No worries! Enter your email and we’ll send you a reset link.</span>

                    {{-- Session Status Message --}}
                    @if (session('status'))
                        <div class="alert alert-success mt-3 mb-0" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" id="forgot-form" class="mt-4">
                        @csrf
                        <div class="input-box">
                            <label for="email">Email*</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter your registered email" required autofocus>

                            {{-- Error message for email --}}
                            @error('email')
                                <p class="text-danger mt-1 small">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="login-btn">Send Reset Link</button>

                        <p class="mt-3 mb-5 text-center">
                            <a href="{{ route('login') }}" style="color:#9F2D26; font-weight:600;">← Back to Login</a>
                        </p>
                    </form>
                </div>
            </div>

            <div class="col-lg-6" style="background:#9F2D26;">
                <div class="login-right-part" style="position:relative;">
                    <h2 class="position-absolute career-slogan mb-2">
                        "Your Career, Your Journey, Our Expertise."
                    </h2>

                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="swiper-image mt-2">
                                    <img src="{{ asset('images/b1.png') }}" alt=""
                                        style="width:100%; height:50%;object-fit:cover;">
                                    <span class="position-absolute swiper-slogan mb-2">
                                        Consistent Quality and Experience Across All Verticals
                                    </span>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="swiper-image mt-2">
                                    <img src="{{ asset('images/b2.png') }}" alt=""
                                        style="width:100%; height:50%;object-fit:cover;">
                                    <span class="position-absolute swiper-slogan mb-2">
                                        Empowering Growth Through Smart Choices
                                    </span>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="swiper-image mt-2">
                                    <img src="{{ asset('images/b3.png') }}" alt=""
                                        style="width:100%; height:50%;object-fit:cover;">
                                    <span class="position-absolute swiper-slogan mb-2">
                                        Unlock Your Potential With Confidence
                                    </span>
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
    </script>
</body>

</html>
