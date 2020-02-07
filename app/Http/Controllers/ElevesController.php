<?php

namespace HamzaApp\Http\Controllers;

use HamzaApp\Eleves;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ElevesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      
           return  Eleves::withCount('mois')->get();

    }
    public function pourcentage()
    {
        //
        $pourcentage = [];
        $pourcentage['tout']= Eleves::all()->count();
        $pourcentage['firstYear'] = Eleves::all()->where('annee','1 ére année')->count();
        $pourcentage['secondYear'] = Eleves::all()->where('annee','2em année')->count();
      
           return  $pourcentage;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        
        //
        $this->validate($request, [
            'nom_prenom'         => 'required|string|max:191|unique:eleves',
            'type'         => 'required|string|max:191',
            'num_tel'        => 'required|regex:/^[0-9]+$/',
            'annee'         => 'required|string|max:191'
          
            
        ],[
            'num_tel.regex'=> 'veuillez taper que des numeros!',
            'nom_prenom.required'=> 'veuillez taper un nom et prénom!',
            'type.required'=> 'veuillez taper un type!',
            'annee.required'=> 'veuillez choisir une année',



        ]);
        return Eleves::create([
            'nom_prenom'=> $request['nom_prenom'],
            'num_tel'=> $request['num_tel'],
            'type'=> $request['type'], 
            'annee'=> $request['annee']



        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
                
        $eleve = Eleves::findOrFail($id);
    
        $this->validate($request, [
            'nom_prenom'         => 'required|string|max:191|unique:eleves,nom_prenom,'. $eleve->id,
            'type'         => 'required|string|max:191|unique:eleves,type,'. $eleve->id,
            'annee'         => 'required|string|max:191|unique:eleves,annee,'. $eleve->id,
            'num_tel'        => 'required|regex:/^[0-9]+$/'
            
        ],[
            'num_tel.regex'=> 'veuillez taper que des numeros!',
            'nom_prenom.required'=> 'veuillez taper un nom et prénom!',
            'type.required'=> 'veuillez choisir un type!',
            'annee.regex'=> 'veuillez choisir une année!',


        ]);

        $eleve->update($request->all());
        return ['message'=> 'eleve updated!'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $eleve = Eleves::findOrFail($id);
        $eleve->delete();
        return ['message'=> 'eleve deleted'];
    }
}
