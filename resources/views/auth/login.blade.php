@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-gray-600 to-gray-500 h-screen">
    <div class="flex flex-col items-center flex-1 h-full justify-center px-4 sm:px-0">
        <div class="flex flex-col sm:flex-row rounded-lg shadow-lg w-full sm:w-3/4 lg:w-1/2 bg-white sm:mx-0">
            <div class="flex flex-col w-full md:w-1/2 p-4">
                <div class="flex flex-col flex-1 justify-center mb-8">
                    <h1 class="text-2xl leading-tight tracking-tight text-gray-900 text-center font-thin">
                        Acceda a su cuenta
                    </h1>
                    <div class="w-full mt-2">
                        <div class="card">

                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}" class="form-horizontal w-3/4 mx-auto">
                                    @csrf

                                    <div class="py-4">
                                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                                            Correo electrónico
                                        </label>
                                        <input v-model="email" type="email" name="email" id="email" aria-label="Correo electrónico" value="{{ old('email') }}" aria-describedby="email-help" class=" @error('email') is-invalid @enderror bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name@company.com" required />
                                        <div id="email-help" class="text-sm text-gray-500">
                                            Ingresa tu correo electrónico
                                        </div>
                                        @error('email')
                                        <p class="text-red-600">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                        @enderror
                                    </div>
                                    <!--<div class="row mb-3">
                                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                                            Correo electrónico
                                        </label>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>-->
                                    <div class="py-4">
                                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
                                            Contraseña
                                        </label>
                                        <input v-model="password" type="password" name="password" id="password" aria-label="Contraseña" aria-describedby="password-help" placeholder="••••••••" class="@error('password') is-invalid @enderror bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required />
                                        <div id="password-help" class="text-sm text-gray-500">
                                            Ingresa tu contraseña.
                                        </div>
                                        @error('password')
                                        <p class="text-red-600">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                        @enderror
                                    </div>
                                    <!--<div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>-->


                                    <div class="py-2">
                                        <button type="submit" class="w-full text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            Iniciar sesión
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden md:block md:w-1/2 rounded-r-lg" style="background: url('/img/img_login.jpg'); background-size: cover; background-position: center center;">
            </div>
        </div>
    </div>
</div>
@endsection