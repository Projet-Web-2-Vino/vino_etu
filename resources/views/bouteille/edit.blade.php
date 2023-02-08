@extends ('layouts.master')
@section('content')

<!-- Début form modif -->



        {{-- Section Formulaire Modification de bouteil --}}
        <div class="relative p-4 bg-white mb-20">
            <div class="max-w-full mx-auto">
                <div class="mb-5 flex items-center space-x-3">
                        <div class="w-12 mr-1">
                            <img src="https://static.thenounproject.com/png/5003274-200.png" alt="">
                        </div>
                        <h2 class="text-xl">Modifier la bouteille  {{$bouteille->nom}} </h2>
                    </div>

						<form id="formModifBouteille" action="{{ route('bouteille.update', ['idVin' => $bouteille->vino__bouteille_id, 'idCellier' => $bouteille->vino__cellier_id ])}}" method="POST">
							@csrf
                        {{-- Section Nom de la bouteille --}}
                        <div class="divide-y divide-gray-200">
                            <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                                <div class="flex flex-col">
                                    <label class="leading-loose">Nom</label>
                                    <input class="mb-3 px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" id="nom" name="nom" type="text" value="{{ old('nom', $bouteille->nom)}}" required>
                                </div>


                                <label class="formlabel leading-loose" for="type">Type  :</label>
								<ul id="radioLi" class="m-0 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex">
								<li  class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
									<div  class="flex items-center pl-3">
										
										<input type="radio" name="type" id="rouge" value="1" @if($bouteille->type == "1") checked @endif class="w-4 h-4 text-red-900 bg-gray-100 border-gray-300 focus:ring-red-900">
										<label for="rouge" class="radiolabel w-full py-3 ml-2 text-gray-600 font-normal">Rouge</label>

										<input type="radio" name="type" id="blanc" value="2"  @if($bouteille->type == "2") checked @endif class="w-4 h-4 text-red-900 bg-gray-100 border-gray-300 focus:ring-red-900">
										<label for="blanc" class=" radiolabel w-full py-3 ml-2 text-gray-600 font-normal">Blanc</label>

										<input type="radio" name="type" id="rose" value="3"  @if($bouteille->type == "3") checked @endif class="w-4 h-4 text-red-900 bg-gray-100 border-gray-300 focus:ring-red-900">
										<label for="rose" class="radiolabel w-full py-3 ml-2 text-gray-600 font-normal">Rosé</label>
										
									</div>
								</li>
								</ul>
								@error('type')
								<span style="color:red"> {{ $message }}</span>
								@enderror

                                {{-- Section Pays, Format, Millesime, Description --}}
                                <div class="flex flex-col">
                                    <label class="leading-loose">Pays</label>
                                    <input class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" id="pays" name="pays" type="text" value="{{ old('pays', $bouteille->pays)}}">
                                    <label class="leading-loose">Format</label>
                                    <input class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" id="format" name="format" type="text" value="{{ old('format', $bouteille->format)}}">
									

							

                                  <?php $years = range(2000, strftime("%Y", time())); ?>
                                  <label class="formlabel leading-loose" for="millesime2">Millesime :</label>
                                  <select id="millesime2" name="millesime2" class="mb-3 px-4 py-2 border focus:ring-gray-500 focus:border-red-200 w-full sm:text-sm border-gray-300 rounded-md text-gray-600">
                                     
                                      <option value="" >Année </option>
                                      <?php foreach($years as $year) : ?>
                                        <option value="<?php echo $year; ?>" {{ old('millesime2') == $year ? "selected" : "" }}><?php echo $year; ?></option>
                                      <?php endforeach; ?>
                                    </select>
 
                                    <input name="millesime" type="hidden" value="">

                                    	 <!-- obligatoire -->
                                       
								<label class="formlabel leading-loose" for="quantite">Quantité  :</label>
								<input id="quantite" name="quantite"  type="number" min="1" value="{{ old('quantite', $bouteille->quantite)}}"  class="mb-3 px-4 py-2 border focus:ring-gray-500 focus:border-red-200 w-full sm:text-sm border-gray-300 rounded-md text-gray-600">


                                    <label class="leading-loose">Description</label>
                                    <textarea class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" id="description" name="description">{{ old('description', $bouteille->description)}}</textarea>
                                </div>
                            </div>
                        </div>
          
                   
					
                        {{-- Section pour le bouton ajouter et supprimer 
                            <div class="pt-4 flex flex-wrap items-center space-x-4">
                                
                                <form action="{{ route('bouteille.supprime', ['idVin' => $bouteille->id, 'idCellier' => $cellier->id ]) }}" method="POST">
                                    @csrf
                                    <button class="bg-red-800 flex justify-center items-center  text-white px-3 py-3 rounded-md focus:outline-none">Supprimer</button>
                                </form>  --}}


                                <div class="flexBtnForm pt-4 flex flex-wrap flex justify-end">
                                    <a class="flex justify-center items-center  text-gray-900 px-4 py-3 rounded-md focus:outline-none" href='{{ route('bouteille.liste', ['id' => $bouteille->vino__cellier_id]) }}'>
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Annuler
                                    </a>
                                    
                                   
                                  
                                    <button id="sauvegarde" class="bg-red-800 flex justify-center items-center text-white px-4 py-3 rounded-md focus:outline-none">Sauvegarder</button>
                                    
                                </div>

                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
  
{{-- Section pour le navbar du bas --}}
@include('layouts.bottomNav')


@endsection

<!-- SCRIPT-->
<script>


    window.addEventListener("load",function(){
    document.getElementById("sauvegarde").onclick= function(e) {
          e.preventDefault();

          var form = document.getElementById("formModifBouteille");
          form.millesime.value = form.millesime2.value
        //  console.log(form.millesime.value );

          form.millesime2.remove();

          form.submit();
        
      } 
    })
    
    
    </script>