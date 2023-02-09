@extends('layouts.master')
@section('content')
 

<x-guest-layout>
       <!-- Session Status -->
       
{{-- Section Front-End refait avec TailwindCSS --}}

    <div class="logZone sm:w-full md:w-9/12   flex rounded-lg shadow-xl" >
        <div class="w-full h-auto hidden lg:block lg:w-1/2 bg-cover rounded-lg lg:rounded-r-none"
            style="background-image: url('https://images.pexels.com/photos/2909085/pexels-photo-2909085.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')">
        </div>
        <div class="w-full lg:w-1/2 bg-white rounded-lg lg:rounded-l-none py-24 px-12">
            <h3 class="titleLog font-bold text-3xl text-red-600 text-center tracking-widest uppercase mb-4">Connexion</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">

                     <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    {{-- <input type="text" id="username" class="w-full p-3 text-md border rounded shadow focus:outline-none focus:shadow-outline" placeholder="Username" /> --}}
                </div>

                <div class="mb-4">

                         <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    {{-- <input type="password" id="password" class="w-full p-3 text-md border rounded shadow focus:outline-none focus:shadow-outline" placeholder="***********" /> --}}
                </div>

                <div class="mb-4">
                    {{-- Section Login --}}
                    <x-primary-button >
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>

                <hr class="mb-4 border-t" />
                <div class="text-sm text-center">
                    Vous n'avez pas de compte?
                    <a href="/register" class="text-blue-500 pl-2">Cliquez-ici !</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>


@endsection