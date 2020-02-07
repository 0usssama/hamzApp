<?php

namespace HamzaApp\Http\Controllers;

use HamzaApp\Eleves;
use HamzaApp\Payments;
use Illuminate\Http\Request;
use HamzaApp\Mois;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      $payments = Payments::all();
    
      foreach ($payments as $payment) {
        
        $eleve = Eleves::find($payment->eleves_id)->nom_prenom;
        if(Eleves::find($payment->eleves_id)){
            $eleve = Eleves::find($payment->eleves_id)->nom_prenom;
            $payment->eleve = $eleve;

        };
        if(Mois::find($payment->mois_id)){
            $mois = Mois::find($payment->mois_id)->titre;
            $payment->mois = $mois;
        }
       
        
      }

      return $payments;
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
        $this->validate($request, [
            'montant'        => 'required|regex:/^[0-9]+$/',
            'versement'        => 'required|regex:/^[0-9]+$/',

            'eleves_id'        => 'required|regex:/^[0-9]+$/',
            'mois_id'        => 'required|regex:/^[0-9]+$/'
            
        ],[
            'eleves_id.regex'=> 'veuillez selectioner un éléve!',
            'mois_id.regex'=> 'veuillez selectioner un mois!',
            'montant_id.regex'=> 'veuillez taper que des numéro!',
            'versement.regex'=> 'veuillez taper que des numéro!',


        ]);
        Payments::create([
            'eleves_id'=> $request->eleves_id, 
            'montant'=> $request->montant,
            'versement'=> $request->versement,
            'mois_id'=> $request->mois_id

        ]);

        
        $paymentsInserted = Payments::latest()->first();

        $versements = Payments::all()->where('mois_id', $request->mois_id)->sum('versement');
        
        if($versements >= $request->montant){
            $moisToUpdate = Mois::findOrFail($request->mois_id);
            $moisToUpdate->update([
                'payments_id'=> $paymentsInserted->id,
                'updated_at'=> date('Y-m-d')
            ]);
        }
      
       //return ['message'=> 'payment added'];
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
        return Payments::all()->where('mois_id', $id);
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
        $payment = Payments::findOrFail($id);
        $payment->delete();
        return ['message'=>'payment deleted'];
    }
}
