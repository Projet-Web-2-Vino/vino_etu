<?php

namespace App\Http\Controllers;

/* Import */
use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CellierController extends Controller
{

    /** 
     * Gestion des variables et vues de cellier.index
     * 
    */
    public function index(Request $request)
    {
       
      if(Auth::check()){ 
       $titre = 'cellier' ;
       $field = User::findOrFail(Auth::id());
       if(Auth::check()){
            $id_usager = Auth::id();
            $celliers = Cellier::where('id_usager' , $id_usager)->withCount('bouteilles')->get();
            if ($field->is_admin == 1) {
                return redirect('/admin');
            } else {
                return view('cellier.index', [
                    'celliers' => $celliers,   
                    'id_usager' => $id_usager,
                    'titre' => $titre
                ]);
            }
        } else{
            return redirect('/login');
        }
        
    }else{
        return redirect('/login');
    }
}


    /*
     Retourne la vue pour ajouter un cellier
    */
    public function nouveau(Request $request)
    {

        if(Auth::check()){ 
            $titre = "formCellier" ;
                Auth::check();
            $id_usager = Auth::id();
            
            $celliers = DB::table('vino__cellier')->where('id_usager', $id_usager)
            ->get();

            //vue creation ceillier 
            return view('cellier.nouveau', [
                'celliers' => $celliers,
                'titre' => $titre
            ]);

        }else{
            return redirect('/login');
        }
    }

     /** 
     * Gestion vue de modification d'une bouteille au cellier
     * @param $request // les parametres POST de la requête
    */
    public function creer(Request $request)
    {
        if(Auth::check()){ 
            $this->validateCellier($request);

            $cellier = Cellier::create($request->all());

            //Redirect avec message de succès
            return redirect()
            ->route('cellier.index')
            ->withSuccess('Vous avez créé le cellier '.$cellier->nom_cellier.'!');
        }else{
            return redirect('/login');
        }
    }


     /** 
     * Gestion vue de modification d'une bouteille au cellier
     * @param $id, l'identifiant du cellier
    */
    public function edit($id)
    {
        if(Auth::check()){
            //dd($id);
            $cellier = Cellier::findOrFail($id);
            $titre = 'cellier' ;
            return view('cellier.edit', [
                'cellier' => $cellier,
                'titre' => $titre
            ]);
        }else{
            return redirect('/login');
        }
    }



    /** 
     * Modification dans la bd d'un cellier
     * @param $request // les parametres POST de la requête 
     *        $id, l'identifiant du cellier 
    */
    public function update(Request $request, $id)
    {
        if(Auth::check()){ 
           
            $this->validateCellier($request);
            $cellier = Cellier::findOrFail($id)->update($request->all());

        // Retourne au formulaire
        return redirect()
            ->route('cellier.index')
            ->withSuccess('La modification a réussi!');
        }else{
            return redirect('/login');
        }
    }


    /** 
     * Suppression dans la bd d'un cellier
     * @param  $id, l'identifiant du cellier 
    */
    public function supprime($id)
    {
        if(Auth::check()){ 
            $cellier = Cellier::find($id);
            $nomCellier = $cellier->nom_cellier;
            $cellier->delete();

            // Retourne au cellier
            return redirect()
                ->route('cellier.index')
                ->withSuccess("Vous avez supprimer le cellier  {$nomCellier}  !");
    
        }else{
            return redirect('/login');
        }
    }


    /**
     * Fonction qui permet de valider les données de l'usager
     */
    private function validateCellier(Request $request)
    {
        $request->validate([
            'nom_cellier' => 'required'
        ]);
    }


}
