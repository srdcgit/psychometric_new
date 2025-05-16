<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Psychometric Career Assessment
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
      font-family: 'Montserrat', sans-serif;
    }
  </style>
 </head>
 <body>
  <header style="padding:10px">
                    <a href="#">
                        <img style="max-height: 60px;padding-bottom:10px" src="https://identity.zpsdemo.in/assets/images/general/logo_white.png" alt="Identity">
                    </a>
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4" style="margin-top:-50px" >
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
  <div class="relative bg-[#2a4a56] min-h-screen flex flex-col items-center justify-center px-4 py-12 text-white text-center">
   <h1 style="color: white;
    margin-inline: auto;
    width: 70%;
    font-size: 2.5em;
    font-weight: 700;
    text-shadow: 2px 2px black;">
    The World’s Most Powerful
    <br/>
    Psychometric Career Assessment
   </h1>
   <p style="color: white;
    width: 730px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 18px;
    font-weight: 600;
    line-height:40px;
    margin: 0;
    margin-inline: auto !important;
    opacity: 1;">
    Using advanced machine learning, psychometrics, and career satisfaction data,
    <span class="bg-yellow-300 text-black font-semibold rounded px-1.5 py-0.5">
     CareerMap
    </span>
    has reimagined what a career test can be.
    <br/>
    CareerMap brings to you scientific and meticulously designed
    <br/>
    Psychometric Career Assessment to discover your true potential and interest.
   </p>
   <button class="relative bg-red-500 hover:bg-red-600 text-white font-semibold rounded px-6 py-2 mb-12 drop-shadow-md" type="button">
    Request a Call Back
   </button>
   <div class="relative flex flex-col sm:flex-row justify-center gap-12 max-w-4xl w-full text-left text-white text-xs sm:text-sm">
    <div class="flex flex-col items-start max-w-[120px]">
     <span class="mb-1 font-semibold text-xs">
      Rating
     </span>
     <div class="flex items-center space-x-1 text-yellow-400 text-lg">
      <i class="fas fa-star">
      </i>
      <i class="fas fa-star">
      </i>
      <i class="fas fa-star">
      </i>
      <i class="fas fa-star">
      </i>
      <i class="fas fa-star-half-alt">
      </i>
     </div>
     <span class="mt-1 text-[12px] text-white/80">
      4.5 out of 5
     </span>
    </div>
    <div class="flex flex-col max-w-[120px]">
     <span class="text-2xl font-bold leading-none">
      500 M
     </span>
     <span class="text-[12px] font-normal mt-1">
      questions answered
     </span>
    </div>
    <div class="flex flex-col max-w-[120px]">
     <span class="text-2xl font-bold leading-none">
      500 +
     </span>
     <span class="text-[12px] font-normal mt-1">
      degrees and careers
     </span>
    </div>
    <div class="flex flex-col max-w-[120px]">
     <span class="text-2xl font-bold leading-none">
      140 +
     </span>
     <span class="text-[12px] font-normal mt-1">
      parameters and traits
     </span>
    </div>
   </div>
   <div class="fixed right-4 bottom-4 flex flex-col gap-3 z-50">
    <button aria-label="WhatsApp" class="w-12 h-12 rounded-full bg-green-500 text-white flex items-center justify-center shadow-lg">
     <i class="fab fa-whatsapp fa-lg">
     </i>
    </button>
    <button aria-label="Chat" class="w-12 h-12 rounded-full bg-green-500 text-white flex items-center justify-center shadow-lg">
     <i class="fas fa-comment-alt fa-lg">
     </i>
    </button>
   </div>
  </div>
   @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
 </body>
</html>
