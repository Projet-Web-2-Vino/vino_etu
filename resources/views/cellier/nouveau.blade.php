@extends('layouts.master')
@section('content')

@if (session()->has('success'))
<div class="text-emerald-600 text-center font-semibold my-10">{{ session('success') }}</div>
@endif
<form action="{{ route('cellier.creer')}}" method="POST">
    {{-- Token pour la securiter du formulaire --}}
    @csrf
    @csrf
    <div class="relative p-4 bg-white">
        <div class="max-w-full mx-auto">
            <div class="flex items-center space-x-3">
                    <div class="w-12 mr-1">
                        <img src="https://static.thenounproject.com/png/5003274-200.png" alt="">
                    </div>
                    <h2 class="text-xl">Ajout cellier</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                    <div class="flex flex-col">
                        <label class="leading-loose">Nom :</label>
                            {{-- Section pour le nom du cellier --}}
                            <input class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" name="nom_cellier" type="text" value="{{ old('nom_cellier')}}" />
                            @error('nom_cellier')
                            <span style="color:red"> {{ $message }}</span>
                            @enderror
                            <input name="id_usager" type="hidden" value="{{Auth::id()}}" />
                        </div>
                        <!--
                        <div class="flex flex-col">
                            <label class="leading-loose">Description</label>
                            <input type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" >
                        </div>
                    -->
                        </div>
                        <div class="flexBtnForm pt-4 flex flex-wrap justify-end">
                            <a class="flex justify-center items-center  text-gray-900 px-4 py-3 rounded-md focus:outline-none" href='/cellier'>
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Annuler
                            </a>
                            {{-- Section pour le bouton ajouter --}}
                            <form action="{{ route('cellier.creer')}}" method="POST">
                                @csrf
                            <button class="bg-slate-900 flex justify-center items-center  text-white px-4 py-3 rounded-md focus:outline-none">Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
</form>
@endsection

   {{-- Section pour le navbar du bas --}}
   @include('layouts.bottomNav')