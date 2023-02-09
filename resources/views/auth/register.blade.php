@extends('layouts.master')
@section('content')
 

<x-guest-layout>
       <!-- Session Status -->
       
{{-- Section Front-End refait avec TailwindCSS --}}

    <div class="mt-20 logZone w-9/12   flex rounded-lg shadow-xl" >
        <div class="w-full  hidden lg:block lg:w-1/2 bg-cover rounded-lg lg:rounded-r-none"
            style="background-image: url('https://images.pexels.com/photos/2909085/pexels-photo-2909085.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')">
        </div>
        <div class="w-full lg:w-1/2 bg-white rounded-lg lg:rounded-l-none py-24 px-12">
            <h3 class="titleLog font-bold text-3xl text-red-600 text-center tracking-widest uppercase mb-4">Inscription</h3>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="mb-4">
                     <!-- Name -->
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required  autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />  
                </div>

                
                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    
                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                  

                    <div class="mb-4">
                        {{-- Section Login --}}
                        <x-primary-button >
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
    
                <hr class="mb-4 border-t" />
                <div class="text-sm text-center">
                    Déjà un compte ?
                    <a href="/login" class="text-blue-500 pl-2">Cliquez-ici !</a>
                </div>
                

                
        </div>
    </div>
</x-guest-layout>


@endsection