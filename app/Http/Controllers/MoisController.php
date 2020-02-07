<?php

namespace HamzaApp\Http\Controllers;

use HamzaApp\Eleves;
use Illuminate\Http\Request;
use HamzaApp\Mois;
use HamzaApp\Payments;
use HamzaApp\Seances;
use phpDocumentor\Reflection\Types\Null_;

class MoisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       
      $mois = Mois::all();
        

      foreach ($mois as $unMois ) {
          # code...
          $nbr_seance = Seances::all()->where('mois_id', $unMois->id)->where('cloture_date','<>' ,null)->count();
          $eleve = Eleves::find($unMois->eleves_id)->nom_prenom;
          $unMois->eleve= $eleve;
          $unMois->nbr_seance = $nbr_seance;
      }

      return $mois;
    }

    /**
     * Show one
     *
     * @return \Illuminate\Http\Response
     */
    public function showOne($id)
    {
        //
        return Mois::all()->where('eleves_id', $id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'titre'         => 'required|string|max:191',
            'eleves_id'        => 'required|regex:/^[0-9]+$/'
            
        ],[
            'eleves_id.regex'=> 'veuillez taper que des numeros!',
            'titre.required'=> 'veuillez taper un nom et prénom!'

        ]);
         Mois::create([
            'titre'=> $request['titre'],
            'eleves_id'=> $request['eleves_id'],
           

        ]);
        $monthInserted = Mois::latest()->first();
        Seances::create([
            'type_seance'=> 'seance 1',
            
            'mois_id'=> $monthInserted->id
        ]);
        Seances::create([
            'type_seance'=> 'seance 2',
            
            'mois_id'=> $monthInserted->id
        ]);
        Seances::create([
            'type_seance'=> 'seance 3',
            
            'mois_id'=> $monthInserted->id
        ]);
        Seances::create([
            'type_seance'=> 'seance 4',
            
            'mois_id'=> $monthInserted->id
        ]);

        return ['message'=> 'mois created'];
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
        return Seances::all()->where('mois_id', $id);
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
        $mois = Mois::findOrFail($id);
        $payments= Payments::all()->where('mois_id',$id);
        foreach ($payments as $payment) {
            # code...
            $payment->delete();
        };
        $mois->delete();
        return ['message'=> 'eleve deleted'];
    }
}
