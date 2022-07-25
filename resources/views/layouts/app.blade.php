<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('sass/app.scss') }}" rel="stylesheet">


    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/icon.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/comment.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/form.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/button.min.css" rel="stylesheet">
    <link href="{{ asset('/vendor/laravelLikeComment/css/style.css') }}" rel="stylesheet">



    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

      <style>
        .images-preview-div img
        {
        padding: 10px;
        max-width: 200px;
        }
        .preview-image img
        {
                padding: 10px;
                max-width: 100px;
        }


        h2{
        text-align: center;
        font-size:22px;
        margin-bottom:50px;
    }
    body{
        background:#f2f2f2;
    }
    .section{
        margin-top:150px;
        padding:50px;
        background:#fff;
    }




    .sidenav {
  height: 100%;
  width: 160px;
  position: fixed;
  z-index: 1;

  left: 0;

  overflow-x: hidden;
  padding-top: 20px;
}

.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.main {
  margin-left: 160px; /* Same as the width of the sidenav */
  font-size: 28px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}

header {
  position: sticky;
  position: -webkit-sticky;
  top: 0; /* required */
}

.dropdown:hover .dropdown-menu {
  display: block;
}

.dropdown:hover .dropdown-menu {
  display: block;
}
.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  right: 0;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1;}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
  background-color: #3e8e41;
}
.center {
  margin: auto;
  width: 60%;
  padding: 10px;
}
        </style>

<script>
    window.Laravel={!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>



</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans">
    <div id="app">
        <header class="bg-blue-900 py-6 header z-10 ">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline hidden md:block">
                        AnyBlog
                    </a>
                    {{-- <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                        <i class="fa fa-home md:hidden" style="font-size:36px;color:white"></i>
                    </a> --}}

                    <form action="/search" method="GET" role="search">
                    <div class="pt-2 pl-2 relative mx-auto text-gray-600">
                        <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                          type="search" name="search" placeholder="Search">
                          <a href="/search" class=" mt-1">
                        <button type="submit" class="absolute right-0 top-0 mt-3.5 pt-2 mr-4">
                          <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                            viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                            width="512px" height="512px">
                            <path
                              d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                          </svg>
                        </button>
                        </a>
                      </div>
                    </form>
                </div>
                <nav class="space-x-4 text-gray-300 text-sm sm:text-base">
                    @guest
                    <div class="flex">
                        <a class="pr-4 no-underline hover:underline hidden md:block" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                            <a class="no-underline hover:underline hidden md:block" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    </div>
                        <div class="md:hidden">
                            <div class="dropdown" style="float:right;">
                                <i class="fas fa-bars dropbtn"></i>
                                <div class="dropdown-content">
                                    <a class="no-underline hover:underline" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    @if (Route::has('register'))
                                        <a class="no-underline hover:underline" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    @endif
                                </div>
                              </div>
                        </div>
                    @else
                    <div class="flex hidden md:block">


                        {{-- Notification --}}
                        <notification :userid="{{ auth()->id() }}"
                            :unreads="{{ auth()->user()->unreadNotifications }}"
                            ></notification>




                        <a href="/profile/{{ Auth::user()->id }}" class="pr-4">
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <a href="{{ route('logout') }}"
                           class="no-underline hover:underline"
                           onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    </div>
                    <div class="md:hidden">
                        <div class="dropdown" style="float:right;">
                            <i class="fas fa-bars dropbtn"></i>
                            <div class="dropdown-content">
                                <a href="/profile/{{ Auth::user()->id }}" class="pr-4">
                                    <span>{{ Auth::user()->name }}</span>
                                </a>
                                <a href="{{ route('logout') }}"
                                class="no-underline hover:underline"
                                onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                          </div>
                    </div>
                    @endguest
                </nav>
            </div>
            @if(Auth::check())
                <div class="grid grid-cols-2 gap-4 center flex items-stretch md:hidden place-items-center">
                    <a href="{{ url('/') }}" >
                        <i class="fa fa-home " style="color:white"></i>
                    </a>
                    <a href="/notifications2">
                        <i class="fas fa-bell" style="color:white"></i>
                    </a>
                </div>

            @endif

        </header>


        @yield('content')
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="{{ asset('/vendor/laravelLikeComment/js/script.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/main.js') }}"></script>


    @yield('scripts')


</body>
</html>
