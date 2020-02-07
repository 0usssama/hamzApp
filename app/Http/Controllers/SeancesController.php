<?php

namespace HamzaApp\Http\Controllers;

use HamzaApp\Mois;
use HamzaApp\Seances;
use Illuminate\Http\Request;

class SeancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        return ['message'=> 'it works'];
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
        $date = date('Y-m-d H:i:s');
        $seance= Seances::findOrFail($id);
        $mois = Mois::findOrFail($seance->mois_id);
       
        if($seance->type_seance == "seance 1"){

            $seance->update([

                'etat_seance' => $request->etat_seance,
                'cloture_date'=> $date
                
                ]);
        
            $mois->update([
                'created_at'=> $date
            ]);

        }elseif ($seance->type_seance == "seance 4") {
            # code...
            $seance->update([

                'etat_seance' => $request->etat_seance,
                'cloture_date'=> $date
                
                ]);
                  $mois->update([
                    'updated_at'=> $date
                ]);
                return 'ça marche! seance 4';
        }else{
            $seance->update([

                'etat_seance' => $request->etat_seance,
                'cloture_date'=> $date
                
                ]);
        }
        
        //return ['message'=> 'eleve updated!', "seance_id"=> $seance->type_seance];
        
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
    }
}
