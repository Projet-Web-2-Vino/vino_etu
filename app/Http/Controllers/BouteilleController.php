<?php

namespace App\Http\Controllers;

/*import*/
use App\Models\BouteillePersonalize;
use App\Models\Cellier;
use App\Models\CelliersBouteilles;
use App\Models\Note;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;



class BouteilleController extends Controller
{
    /** 
     * Gestion des variables et vues de bouteille.liste
     * @param $id // le id du cellier
    */
    public function index($id)
    {

        if(Auth::check()){
            $id_usager = Auth::id();

            /* récupération des parametres */
            $type = Request::get('type');
            $pays = Request::get('pays');
            $note = Request::get('note');
            $msg = NULL;
            
            /* Condition si parametre filtre */

            /* Type de vin*/
            if($type){
                $bouteilles = DB::table('vino__cellier_has_vino__bouteille')
                ->select('*')
                ->leftjoin('vino__note', 'vino__bouteille_id', '=', 'vino__note.id_bouteille')
                ->join('vino__bouteille_personalize', 'vino__bouteille_id', '=', 'vino__bouteille_personalize.id')
                ->join('vino__cellier', 'vino__cellier_id', '=', 'vino__cellier.id')
                ->where('vino__cellier_id', $id)
                ->where('type', $type)
                ->orderBy('vino__bouteille_id', 'DESC')
                ->get();
            
                if(!count($bouteilles)){
                    $msg = "Vous n'avez pas de bouteille de ce type dans ce cellier";
                    $bouteilles = $this->listeBouteilles($id);
                }
            /* Pays/Provenance*/    
            }elseif($pays){
                $bouteilles = DB::table('vino__cellier_has_vino__bouteille')
                ->select('*')
                ->leftjoin('vino__note', 'vino__bouteille_id', '=', 'vino__note.id_bouteille')
                ->join('vino__bouteille_personalize', 'vino__bouteille_id', '=', 'vino__bouteille_personalize.id')
                ->join('vino__cellier', 'vino__cellier_id', '=', 'vino__cellier.id')
                ->where('vino__cellier_id', $id)
                ->where('pays', $pays)
                ->orderBy('vino__bouteille_id', 'DESC')
                ->get();

                if(!count($bouteilles)){
                    $msg = "Vous n'avez pas de bouteille de ce pays dans ce cellier";
                    $bouteilles = $this->listeBouteilles($id);
                }
             /* Note */    
            }elseif($note){
                $bouteilles = DB::table('vino__cellier_has_vino__bouteille')
                ->select('*')
                ->leftjoin('vino__note', 'vino__bouteille_id', '=', 'vino__note.id_bouteille')
                ->join('vino__bouteille_personalize', 'vino__bouteille_id', '=', 'vino__bouteille_personalize.id')
                ->join('vino__cellier', 'vino__cellier_id', '=', 'vino__cellier.id')
                ->where('vino__cellier_id', $id)
                ->where('note', $note)
                ->orderBy('vino__bouteille_id', 'DESC')
                ->get();

                if(!count($bouteilles)){
                    $msg = "Vous n'avez pas de bouteille avec cette note dans ce cellier";
                    $bouteilles = $this->listeBouteilles($id);
                }

            }else{
                $bouteilles = $this->listeBouteilles($id);
            }
          

           /* récupérer le pays des vin du cellier pour l'ajouter au dropdown du filtre pays */
            $pays = DB::table('vino__cellier_has_vino__bouteille')
                ->select('pays')
                ->leftjoin('vino__note', 'vino__bouteille_id', '=', 'vino__note.id_bouteille')
                ->join('vino__bouteille_personalize', 'vino__bouteille_id', '=', 'vino__bouteille_personalize.id')
                ->join('vino__cellier', 'vino__cellier_id', '=', 'vino__cellier.id')
                ->where('vino__cellier_id', $id)
                ->groupBy('pays')
                ->get();

            if(!count($pays)){
                    $pays = "N/A";
                    $bouteilles = $this->listeBouteilles($id);
            }

        $cellier = Cellier::find($id);
        $titre = 'bouteille' ; 

        return view('bouteille.liste', [
            'bouteilles' => $bouteilles,
            'id_usager' => $id_usager,
            'id_cellier' => $id,
            'cellier' => $cellier,
            'msg'=> $msg,
            'titre' => $titre,
            'pays' => $pays

        ]);

        }else{

            return redirect('/login');
        }
    }

    /** 
     * Récupère la liste des bouteilles du cellier
     * @param $id // le id du cellier
    */
    public function listeBouteilles($id)
    {
       return $bouteilles = DB::table('vino__cellier_has_vino__bouteille')
                    ->select('*')
                    ->leftjoin('vino__note', 'vino__bouteille_id', '=', 'vino__note.id_bouteille')
                    ->join('vino__bouteille_personalize', 'vino__bouteille_id', '=', 'vino__bouteille_personalize.id')
                    ->join('vino__cellier', 'vino__cellier_id', '=', 'vino__cellier.id')
                    ->where('vino__cellier_id', $id)
                    ->orderBy('vino__bouteille_id', 'DESC')
                    ->get();
    }

    /** 
     * Ajout une bouteille au cellier
     * @param $id // le id du cellier
    */
    public function nouveau(Request $request, $id)
    {
        if(Auth::check()){
            $id_usager = Auth::id();
        
            //Liste des bouteille  
            $bouteillesSAQ = DB::table('vino__bouteille')
            ->get();

            //cellier impliquer
            $cellier = Cellier::find($id);
            $titre = 'formBouteille';
            
            //vue des bouteille du catalogue
            return view('bouteille.nouveau', [
                'bouteillesSAQ' => $bouteillesSAQ, //pour la rechercher
                'cellier' => $cellier,
                'titre' => $titre,
                'id_cellier' => $id
            ]);
        }else{

            return redirect('/login');
        }
    }

    /** 
     * Insertion d'une bouteille au cellier
     * @param $request // les parametres POST de la requête
    */
    public function creer(Request $request)
    {
        
        if(Auth::check()){
            
            $id_usager = Auth::id();
            $quantite = Request::get('quantite');
            $id_cellier = Request::get('id_cellier');
            $code_saq = Request::get('code_saq');
            $nomBouteille = Request::get('nom');
            $type = Request::get('type');
            $pays = Request::get('pays');
            $format = Request::get('format');
            $note = 0;
            $doublon = 0;

            

            $titre = 'bouteille'; // var qui sert à la gestion du bouton milieu du menu du bas

            //dd($code_saq);

            //validation du data
            $this->validateBouteille($request);

            //Détecter si Doublon//
            $bouteilles = DB::table('vino__cellier_has_vino__bouteille')
            ->select('*')
            ->leftjoin('vino__note', 'vino__bouteille_id', '=', 'vino__note.id_bouteille')
            ->join('vino__bouteille_personalize', 'vino__bouteille_id', '=', 'vino__bouteille_personalize.id')
            ->join('vino__cellier', 'vino__cellier_id', '=', 'vino__cellier.id')
            ->where('vino__cellier_id', $id_cellier)
            ->orderBy('vino__bouteille_id', 'DESC')
            ->get();

            //dd($bouteilles);

            foreach ($bouteilles as $data){
                //dd($data);
                if($code_saq == $data->code_saq && $nomBouteille == $data->nom &&$format == $data->format && $type == $data->type){
                    //dd('ici');
                    $quantite = $data->quantite + $quantite;
                    $bouteille = CelliersBouteilles::where('vino__bouteille_id', $data->vino__bouteille_id)
                                ->limit(1)
                                ->update(['quantite' => $quantite]);
                    $doublon = 1;

                    return redirect()
                    ->route('bouteille.liste', [ 'id' => $id_cellier, 'titre' => $titre] )
                    ->withSuccess('Vous avez déjà la bouteille '.$data->nom.', '.$quantite. ' bouteille a été ajoutée à la quantité');
  
                }else{
                    $doublon = 0;
                }
            }
            


            if(!$doublon){
                //Ajout de la bouteille dans vin personalize
                //TODO check duplication//
                $bouteille = BouteillePersonalize::create(Request::except(['quantite', 'id_cellier', 'millesime2' ]));

                //Ajout de la bouteille dans le cellier 
                $idBouteille = $bouteille->id;
                $request2 = [
                    'vino__cellier_id'   => $id_cellier,
                    'vino__bouteille_id' => $idBouteille,
                    'quantite' => $quantite
                ];

                CelliersBouteilles::create($request2);

                //Ajout note 0 par défaut
                $request3 = [
                    'id_usager'   => $id_usager,
                    'note' => $note,
                    'id_bouteille' => $idBouteille
                ];

                Note::create($request3);

            

                //Redirect vers la liste des bouteille du cellier avec un message de succès
                return redirect()
                ->route('bouteille.liste', [ 'id' => $id_cellier, 'titre' => $titre] )
                ->withSuccess('Vous avez ajouter la bouteille '.$bouteille->nom.'!');
            }

        }else{

            return redirect('/login');
        }
    }


    /** 
     * Gestion vue de modification d'une bouteille au cellier
     * @param $idVin, $idCellier
    */
    public function edit($idVin, $idCellier)
    {
        if(Auth::check()){
            $bouteille = BouteillePersonalize::findOrFail($idVin)
                                                ->select('*')
                                                ->join('vino__cellier_has_vino__bouteille', 'vino__bouteille_personalize.id', '=', 'vino__cellier_has_vino__bouteille.vino__bouteille_id')
                                                ->where('id', $idVin)
                                                ->first();
    
            $cellier = Cellier::find($idCellier);
            $titre = 'formBouteille';

            return view('bouteille.edit', [
                'bouteille' => $bouteille,
                'cellier' => $cellier,
                'titre' => $titre,
                'id_cellier' => $idCellier 
            ]);
        }else{
            return redirect('/login');
        }
    }

    /** 
     * Modification dans la bd d'une bouteille au cellier
     * @param $request // les parametres POST de la requête / $idVin, $idCellier
    */
    public function update(Request $request, $idVin, $idCellier)
    {
        if(Auth::check()){
            $this->validateBouteille($request);
            $quantite = Request::get('quantite');

            $request = Request::except(['quantite', 'id_cellier', 'millesime2' ]);

            $bouteille = BouteillePersonalize::findOrFail($idVin)->update($request);
            //dd($bouteille);

            //TODO si ça n'a pas fonctionner

            $request2 = [
                'idCellier'   => $idCellier,
                'idVin' => $idVin,
                'quantite' => $quantite
            ];

            $request3 = new Request;
            $request3::merge($request2);

            $this->quantite($idCellier, $idVin, $quantite);

            // Retourne au formulaire
            return redirect()
                ->route('bouteille.liste', [ 'id' => $idCellier] )
                ->withSuccess('La modification a réussi!');
            }else{

                return redirect('/login');
            }
    }


    /** 
     * Suppression dans la bd d'une bouteille au cellier
     * @param $request // les parametres POST de la requête / $idVin, $idCellier
    */
    public function supprime(Request $request, $idVin, $idCellier)
    {
        if(Auth::check()){
            $id =(int)$idVin;
            $bouteille = BouteillePersonalize::findOrFail($id);
            $bouteille->delete();


            // Retourne au formulaire
            return redirect()
                ->route('bouteille.liste', [ 'id' => $idCellier] )
                ->withSuccess("Vous avez supprimer la bouteille  {$bouteille->nom}  !");

        
        }else{

            return redirect('/login');
        }

    }

   /** 
     * Recherche d'une bouteille du catalogue SAQ
     * 
    */
    public function recherche()
    {
            
            $data = '';
            $recherche = Request::get('recherche');
            // dd($recherche);
            //Requete sur la recherche , limit de 10
            if($recherche != '')
            {
                $data = DB::table('vino__bouteille')
                ->where('nom','like','%' .$recherche. '%')
                ->take(10)
                ->get();
            }
            return json_encode($data);
    }


    public function updateBouteille()
    {
       
        $idVin = Request::get('idVin');
        $idCellier = Request::get('idCellier');
        $quantite = Request::get('quantite');
        $note = Request::get('note');
        //dd($idCellier, $idVin, $quantite, $note);

        if($quantite) $this->quantite($idVin, $idCellier, $quantite);
        if($note) $this->note($idVin, $idCellier, $note);
          
    }



    /** 
     * Modifie la quantité de bouteille
     * 
    */
    public function quantite($idVin, $idCellier, $quantite)
    {
       
        $updated = CelliersBouteilles::where('vino__bouteille_id', $idVin)
                                        ->limit(1)
                                        ->update(['quantite' => $quantite]); 

        
        //dd($updated);
        //TODO si ça n'a pas fonctionner

        // Redirect
        return route('bouteille.liste', [ 'id' => $idCellier] );
          
    }

    /**
     * Fonction qui modifie la note de la  bouteille
     */
    public function note($idVin, $idCellier, $note)
    {
        //dd($request);
       
        $updated = Note::where('id_bouteille', $idVin)
                                        ->limit(1)
                                        ->update(['note' =>$note]); 

        
        //dd($updated);


       // return json_encode($quantite);

        // Redirect
        return redirect()
            ->route('bouteille.liste', [ 'id' => $idCellier] );
          
    }


    /**
     * Fonction qui permet de valider les données de l'usager 
     */
    private function validateBouteille(Request $request)
    {
        
        return Request::validate([
            'nom' => 'required',
            'type' => 'required'
        ]);

         
    }

    
}
