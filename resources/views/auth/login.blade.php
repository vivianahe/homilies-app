@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-[#1e293b] via-[#334155] to-[#475569] flex items-center justify-center px-4 py-10">
    <div
        class="w-full max-w-5xl my-auto bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        <div class="p-8 md:p-14 flex flex-col justify-center">

            <div class="mb-8 text-center">

                <h1 class="text-4xl font-bold text-gray-800">
                    Homilías Padre Uriel Franco
                </h1>

                <p class="text-gray-500 mt-2">
                    Accede a tu cuenta administrativa
                </p>

            </div>

            <form method="POST"
                action="{{ route('login') }}"
                class="space-y-6">

                @csrf

                <div>

                    <label for="email"
                        class="block mb-2 text-sm font-semibold text-gray-700">

                        Correo electrónico

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <i class="fa-solid fa-envelope text-gray-400"></i>
                        </div>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            placeholder="correo@ejemplo.com"
                            required
                            autofocus
                            class="@error('email') border-red-500 @enderror
                            w-full pl-11 pr-4 py-3 rounded-2xl border border-gray-300
                            bg-gray-50 text-gray-800
                            focus:ring-2 focus:ring-sky-500
                            focus:border-sky-500
                            outline-none transition-all duration-200" />

                    </div>
                    @error('email')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div>

                    <label for="password"
                        class="block mb-2 text-sm font-semibold text-gray-700">

                        Contraseña

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="••••••••"
                            required
                            class="@error('password') border-red-500 @enderror
                            w-full pl-11 pr-4 py-3 rounded-2xl border border-gray-300
                            bg-gray-50 text-gray-800
                            focus:ring-2 focus:ring-sky-500
                            focus:border-sky-500
                            outline-none transition-all duration-200" />

                    </div>
                    @error('password')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

                <div class="flex items-center justify-between text-sm">

                    <label class="flex items-center text-gray-600">

                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300 text-sky-500 focus:ring-sky-500">

                        <span class="ml-2">
                            Recordarme
                        </span>

                    </label>

                </div>

                <button
                    type="submit"
                    class="w-full bg-sky-500 hover:bg-sky-600
                    text-white font-semibold py-3 rounded-2xl
                    shadow-lg hover:shadow-xl
                    transition-all duration-300">

                    <i class="fa-solid fa-right-to-bracket mr-2"></i>

                    Iniciar sesión
                </button>

            </form>
        </div>

        <div class="hidden md:block relative overflow-hidden">
            <img
                src="/img/img_login_high_quality.webp"
                alt="Login"
                class="w-full h-full object-cover"
                loading="eager"
                decoding="async">


            <div class="absolute inset-0 bg-black/20"></div>

            <div class="absolute top-10 left-10 z-10">

                <div class="border-l-2 border-white/70 pl-4">

                    <p class="text-white/80 text-xs tracking-[3px] uppercase font-medium">
                        Plataforma administrativa
                    </p>

                    <h2 class="text-white text-2xl font-semibold mt-2">
                        Homilías Padre Uriel Franco   
                    </h2>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection