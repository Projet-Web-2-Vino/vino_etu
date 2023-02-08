
@extends('layouts.master')
@section('content')

<!-- Feedback success -->
@if (session()->has('success'))
<div class="text-emerald-600 text-center font-semibold my-10">{{ session('success') }}</div>
@endif


<div class="relative p-4 bg-white mb-20">
	<div class="max-w-full mx-auto">
		<div class="mb-5 flex items-center space-x-3">
				<div class="w-12 mr-1">
					<img src="https://static.thenounproject.com/png/5003274-200.png" alt="">
				</div>
				<h2 class="text-xl">Ajouter une bouteille au cellier {{$cellier->nom_cellier}} </h2>
			</div>

		<hr class="my-2">	
		<p class="bg-gray-700 text-white p-2 text-center">Vous pouvez rechercher une bouteille provenant du catalogue</p>
		<hr class="my-2">
		<!-- Zone recherche -->
		<form name="recherche" id="rechercheForm"  method="POST">
			@csrf

			<div class="relative">
				<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
					<svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
				</div>
				<input type="search" name="recherche" id="recherche" onblur="resetForm()" onkeyup="fetchData()"  class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50" placeholder="Recherche dans le catalogue par nom">
			</div>
		</form>

	
		<!-- Output catalogue -->
		<table class="pl-10 text-md text-gray-900 border border-gray-300 rounded-lg bg-gray-50" id="listeAutoComplete">

			<tbody class="transition-all" id="tbodyfordata">
				<!-- Data catalogue apparait ici -->
			</tbody>
		</table>
		<!-- Fin zone recherche -->

		<hr class="my-2">	
		<p class="bg-gray-700 text-white p-2 text-center">Vous pouvez aussi entrer vos propres bouteilles</p>
		<hr class="my-2">


		<form id="formAjoutBouteille" action="{{ route('bouteille.creer')}}" method="POST">
			@csrf

			<!-- Caché essentiel -->
			<input id="id_cellier" name="id_cellier" type="hidden" value="{{$cellier->id}}">

				
							
						
							<div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
							<div class="flex flex-col">

								<!-- Obligatoire -->
								<label class="" for="nom">Nom  :</label>
								<input id="nom" name="nom" type="text" placeholder="Nom *" value="{{ old('nom') }}" class="mb-3 px-4 py-2 border focus:ring-gray-500 focus:border-red-200 w-full sm:text-sm border-gray-300 rounded-md text-gray-600">
								@error('nom')
								<span style="color:red"> {{ $message }}</span>
								@enderror
								
								<label class="formlabel leading-loose" for="type">Type  :</label>
								<ul id="radioLi" class="my-3 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex">
								<li  class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
									<div  class="flex items-center pl-3">
										
										<input type="radio" name="type" id="rouge" value="1" {{ old("type") == '1' ? 'checked' : '' }} class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-900">
										<label for="rouge" class="radiolabel w-full py-3 ml-2 text-gray-600 font-normal">Rouge</label>

										<input type="radio" name="type" id="blanc" value="2"  {{ old("type") == '2' ? 'checked' : '' }} class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300">
										<label for="blanc" class=" radiolabel w-full py-3 ml-2 text-gray-600 font-normal">Blanc</label>

										<input type="radio" name="type" id="rose" value="3"  {{ old("type") == '3' ? 'checked' : '' }} class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300">
										<label for="rose" class="radiolabel w-full py-3 ml-2 text-gray-600 font-normal">Rosé</label>
										
									</div>
								</li>
								</ul>
								@error('type')
								<span style="color:red"> {{ $message }}</span>
								@enderror

								
								
								
								 <!-- Pas obligatoire -->
								 <label class="formlabel leading-loose" for="pays">Pays/Provenance  :</label>
								<input id="pays" name="pays" type="text" placeholder="Pays/Provenance" value="{{ old('pays') }}" class="mb-3 px-4 py-2 border focus:ring-gray-500 focus:border-red-200 w-full sm:text-sm border-gray-300 rounded-md text-gray-600">
								
								<label class="formlabel leading-loose" for="format">Format :</label>
								<input id="format" name="format" type="text" value="{{ old('format') }}" placeholder="Format : 750ml, 1L" class="mb-3 px-4 py-2 border focus:ring-gray-500 focus:border-red-200 w-full sm:text-sm border-gray-300 rounded-md text-gray-600">
								

								 <!-- Pas obligatoire -->
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
								<input id="quantite" name="quantite" placeholder="Quantité" type="number" min="1" value="{{ old('quantite'), 1 }}"  class="mb-3 px-4 py-2 border focus:ring-gray-500 focus:border-red-200 w-full sm:text-sm border-gray-300 rounded-md text-gray-600">

								
								
		  						
								
								 <label class="formlabel leading-loose" for="description">Description :</label>
								<textarea placeholder="Description / Note" id="description" name="description" class="mb-3 px-4 py-2 border focus:ring-gray-500 focus:border-red-200 w-full sm:text-sm border-gray-300 rounded-md text-gray-600">{{ old('description'), 1 }}</textarea>
								
								<!-- Caché non obligatoire -->
								<input id="url_saq" name="url_saq" type="hidden" value="">
								<input id="code_saq" name="code_saq" type="hidden" value="">
								<input id="image" name="image" type="hidden" value="">
								<input id="prix_saq" name="prix_saq" type="hidden" value="">
								<input id="url_img" name="url_img" type="hidden" value="">
								
							</div>
							<!--
							<div class="flex flex-col">
								<label class="leading-loose">Description</label>
								<input type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" >
							</div>
						-->
							</div>
							<div class="flexBtnForm pt-4 flex flex-wrap flex justify-end">
								<div class="grow flex flex-wrap">
									<a class="flex justify-center   text-gray-900 px-4 py-2" href='/cellier'>
									<svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Annuler
									</a>
									<a class="flex justify-center   text-gray-900 px-4 py-2" onclick="resetForm()">
										<svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Effacer
									</a>
								</div>
								{{-- Section pour le bouton ajouter --}}
								<form action="{{ route('cellier.creer')}}" method="POST">
									@csrf
								<button class="btnAjouterForm bg-red-800 flex justify-center items-center  text-white px-8 py-2 rounded-md focus:outline-none">Ajouter</button>
								</form>
								
							</div>
						
		
	</div>
</div>
{{-- Section pour le navbar du bas --}}
@include('layouts.bottomNav')
@endsection




<!-- SCRIPT-->
<script>


window.addEventListener("load",function(){
document.getElementById("rechercheForm").onkeypress = function(e) {
	//console.log(e.charCode)
    var key = e.charCode || e.keyCode || 0;     
    if (key == 13) {
      //alert("No Enter!");
      e.preventDefault();
    }
  } 
})



    function fetchData()
	{
       
		resetForm()
		//recherche Value
		let elRecherche = document.getElementById('recherche').value;

		//Liste recherche
		let liste = document.getElementById('listeAutoComplete');
		//console.log(liste)

		//recherche Url
        const url = "{{route('bouteille.recherche')}}";
		//console.log(url);

		const options = {
				headers: {
				"Content-Type": "application/json",
				"Accept": "application/json",
				"X-Requested-With": "XMLHttpRequest",
				"X-CSRF-Token": document.querySelector('input[name="_token"]').value
				},
				method: "post",
				credentials: "same-origin",
				body: JSON.stringify({
				recherche: elRecherche
				})
			}

		fetch(url, options)
		.then((resp) => resp.json()) //Transforme  data en json
		.then(function(data){
			

			var tbodyref  = document.getElementById('tbodyfordata');
			console.log(tbodyref);
			tbodyref.innerHTML = '';
			let bouteilles = data;
			//console.log(bouteilles);
			bouteilles.map(function(bouteille){
				let tr = createNode('tr'),
					nom = createNode('td');
					id = bouteille.id
					nom.innerText = bouteille.nom;
					nom.setAttribute('data-id', bouteille.id)
					append(tr,nom);
					append(tbodyref,tr);

					/*
      					* Gestionnaire d'évènement clique sur l'élément tr ( nom de la bouteille ) 
     					  qui permet de faire la sélection parmi les choix de la liste
    				*/
					tr.addEventListener("click", function(evt){
						//console.log(evt.target.dataset.id)
						if(evt.target.tagName == "TD"){
						
						injectBouteilleInfo(bouteille)

						//vide la recherche
						console.log(liste);
						liste.innerHTML = '<tbody class="transition-all" id="tbodyfordata"></tbody>';
						document.getElementById('recherche').value = '';

						//Rendre les inputs du form readonly
						readOnly();


						}
					});

				});			
		})
		.catch(function(error){
			console.log(error);
		})
	}

	//Creation de l'élément de recherche
	function createNode(element)
	{
		return document.createElement(element);
	}

	//Injection de l'élément de recherche
	function append(parent,el)
	{
		return parent.appendChild(el);
	}


	function injectBouteilleInfo(bte)
	{

		//console.log(bte)
		var form = document.getElementById('formAjoutBouteille')
		
		//Injecter les info de la bouteille dans le formulaire si vient de la recherche
		for (const property in bte) {
			  prop = `${property}`;
			  value = `${bte[property]}`;
			 // console.log(prop);
			 // console.log(value);

			 // radio bouton
			  if (prop == 'type'){
				//console.log(typeof value)
				valueBte = value
				switch (valueBte) {
					case '1':
					//console.log(document.getElementById("rouge"))
					document.getElementById("rouge").checked =true;
					break;
					case '2':
					document.getElementById("blanc").checked =true;
					break;
					case '3':
					document.getElementById("rose").checked =true;
					break;
				}
			  }else{
				form[prop].value = value;
			  } 
			  
			   //ajout d'une quantite par defaut
			   form.quantite.value = 1;
		}
		
	}

	function resetForm(){
		var form = document.getElementById('formAjoutBouteille')
		form.reset();
		form.nom.readOnly = false
		form.pays.readOnly = false
		form.format.readOnly = false
		form.millesime.value = ""
		form.millesime2.value = ""
		form.millesime2.disabled = false

		/*radio group*/
		document.querySelector('#radioLi').style.border = "1px solid #D1C9DB"
		form.type.forEach(element => {
				element.disabled = false
				element.nextSibling.nextSibling.style.display = "inline-block"
				element.style.display = "inline-block"
		});
	}

	function readOnly()
	{

		var form = document.getElementById('formAjoutBouteille')
		
		form.nom.readOnly = true
		form.pays.readOnly = true
		form.format.readOnly = true

		/*detection millesime*/
		let annee = form.nom.value.match(/(\d{4}-\d{4}|\d{4})/g)
		if(annee){
			annee = annee[0];
			form.millesime2.value = annee
			form.millesime2.style.border = "none"
			form.millesime.value = annee
			console.log(form.millesime)
			form.millesime2.disabled = true
		}
		
		//console.log(annee);
		

		
		
		/*disable les autres options... dans ce cas-ci provenant du catalogue=rouge*/
		document.querySelector('#radioLi').style.border = "none"
		form.type.forEach(element => {
			if(!element.checked) {
				element.disabled = true
				element.nextSibling.nextSibling.style.display = "none"
				element.style.display = "none"
				
			} 
		});
		
		
	}

</script>
