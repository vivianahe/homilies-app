<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSRF Token -->
    <meta name="google-site-verification" content="HMpumuD7tWmikrpJlPLxGri6Au_OBy9oF78cKJAm2xg" />
    <!--<meta name="csrf-token" content="{{ csrf_token() }}">-->
    <link rel="icon" href="{{ 'favicon32.png' }}" type="image/x-icon">
    <title>{{ config('app.name', 'Homilías') }}</title>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <div id="app">
        @guest
        {{-- El navbar no se mostrará si no se ha iniciado sesión --}}
        @else
        <nav class="fixed top-0 z-50 w-full bg-gray-800 border-b border-gray-700">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start">
                        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                                </path>
                            </svg>
                        </button>
                        <a href="/" class="flex ml-2 md:mr-24">
                            <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-white">Homilías Uriel</span>
                        </a>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center ml-3">
                            <p class="text-md text-white font-bold px-2" role="none">
                                {{ auth()->user()->name }}
                            </p>
                            <div>
                                <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-700" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="w-10 h-10 rounded-full" src="/img/user.png" />
                                </button>
                            </div>
                            <div class="z-50 hidden my-4 text-base list-none bg-gray-800 divide-y divide-gray-100 rounded shadow" id="dropdown-user">
                                <div class="px-4 py-3" role="none">
                                    <p class="text-sm text-white" role="none">
                                        {{ auth()->user()->name }}
                                    </p>
                                    <p class="text-sm font-medium text-white truncate" role="none">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>
                                <ul class="py-1" role="none">
                                    <li>
                                        <a href="/homilyAllAdm" class="block px-4 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-700" role="menuitem">
                                            Homilías
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/prayerView" class="block px-4 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-700" role="menuitem">
                                            Oración de la mañana
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/userView" class="block px-4 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-700" role="menuitem">
                                            Usuarios
                                        </a>
                                    </li>
                                    <li>
                                        <a class="block px-4 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-700" role="menuitem" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Cerrar sesión
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 
    h-screen pt-20 transition-transform -translate-x-full 
    border-r sm:translate-x-0 bg-gray-800 border-gray-700" aria-label="Sidebar">
            <div class="h-full px-3 pb-4 overflow-y-auto bg-gray-800">
                <ul class="space-y-2 font-medium">
                    <li class="hover:text-gray-900">
                        <a href="/homilyAllAdm" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                            <i class="fas fa-bible text-gray-500 group-hover:text-white"></i>
                            <span class="ml-3">Homilías</span>
                        </a>
                    </li>
                    <li class="text-white hover:text-gray-900">
                        <a href="/prayerView" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                            <i class="fas fa-praying-hands text-gray-500 group-hover:text-white"></i>
                            <span class="ml-3">Oración de la mañana</span>
                        </a>
                    </li>
                    <li class="text-white hover:text-gray-900">
                        <a href="/userView" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group">
                            <i class="fas fa-user-friends text-gray-500 group-hover:text-white"></i>
                            <span class="ml-3">Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-arrow-right-from-bracket text-gray-500 group-hover:text-white"></i>
                            <span class="ml-3">Cerrar Sesión</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </aside>
        @endguest
        <div>
            @yield('content')
        </div>
    </div>
</body>

</html>