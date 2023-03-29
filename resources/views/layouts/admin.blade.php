<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title> @yield('head-title') Laravel Boolfolio</title>

    <!-- Fontawesome 6 cdn -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css'
        integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=='
        crossorigin='anonymous' referrerpolicy='no-referrer' />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    @yield('body_css')

    <div id="app">

        <header id="admin_header" class="navbar navbar-dark bg-black shadow ">
            <div class="container-fluid ms-5 me-5">
                <div class="row row-cols-3 row-cols-md-2 w-100 justify-content-between">
                    <div class="col h-100 d-md-none">
                        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="col h-100 d-flex">
                        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">Boolfolio</a>
                    </div>
                    <div class="col h-100 d-flex justify-content-end pe-5">
                        <div class="navbar-nav">
                            <div class="nav-item ms-2 position-relative ">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle m-0" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right position-absolute end-0 start-0" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">{{__('Dashboard')}}</a>
                                    <a class="dropdown-item" href="{{ url('profile') }}">{{__('Profile')}}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div id="admin_main">
            <div class="container-fluid h-100">
                <div class="row h-100">
                    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-black navbar-dark sidebar collapse">
                        <div class="position-sticky top-0 pt-3">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}"
                                        href="{{ route('admin.dashboard') }}">
                                        <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i> Dashboard
                                    </a>
                                </li>
                            </ul>
                            <h6 class="text-white mt-4 mb-2">
                                Gestione Progetti
                            </h6>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.projects.index' ? 'active' : '' }}"
                                        href="{{ route('admin.projects.index') }}">
                                        <i class="fa-solid fa-folder fa-lg fa-fw"></i> Progetti
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.types.index' ? 'active' : '' }}"
                                        href="{{ route('admin.types.index') }}">
                                        <i class="fa-solid fa-sitemap fa-lg fa-fw"></i> Tipologie
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.technologies.index' ? 'active' : '' }}"
                                        href="{{ route('admin.technologies.index') }}">
                                        <i class="fa-solid fa-toolbox"></i> Tecnologie
                                    </a>
                                </li>
                            </ul>
                            <h6 class="text-white mt-4 mb-2">
                                Gestione Profilo
                            </h6>
                            <ul class="nav flex-column">
                                <li class="nav-item">

                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'profile' ? 'bg-secondary' : '' }}"
                                        href="{{ url('profile') }}">{{ __('Profile') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>


                        </div>
                    </nav>

                    <main class="col-md-9 ms-sm-auto bg-light col-lg-10 px-md-4 h-100">
                        @yield('content')
                    </main>
                </div>
            </div>

        </div>
    </div>
    @yield('body_js')
    {{-- <script>
        const header = document.querySelector('header');
        const headerHeight = header.offsetHeight;
        document.documentElement.style.setProperty('--header-height', `${headerHeight}px`);
    </script> --}}
</body>

</html>
