<?php

namespace HamzaApp\Http\Controllers;

use HamzaApp\Tests;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Tests::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return ['message'=> 'raha jouz'];
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

         //
         $this->validate($request, [
            'eleves_id'        => 'required|regex:/^[0-9]+$/',
            'note'        => 'required|regex:/^[0-9]+$/',
            'titre'         => 'required|string|max:191',
            'observation'         => 'required|string'


            
        ],[
            'eleves_id.regex'=> 'veuillez selectioner un éléve!',
            'note.regex'=> 'veuillez taper que des numéros!',
            'titre.required'=> 'veuillez taper un titre!',
            'observation.required'=> 'veuillez taper une observation!',

            

        ]);
        return Tests::create([
            'eleves_id' => $request->eleves_id,
            'note' => $request->note,
            'titre' => $request->titre,
            'observation' => $request->observation
            
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
        $test = Tests::findOrFail($id);
        $this->validate($request, [
            'eleves_id'        => 'required|regex:/^[0-9]+$/',
            'note'        => 'required|regex:/^[0-9]+$/',
            'titre'         => 'required|string|max:191',
            'observation'         => 'required|string'


            
        ],[
            'eleves_id.regex'=> 'veuillez selectioner un éléve!',
            'note.regex'=> 'veuillez taper que des numéros!',
            'titre.required'=> 'veuillez taper un titre!',
            'observation.required'=> 'veuillez taper une observation!',

            

        ]);
        $test->update($request->all());
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
        $test = Tests::findOrFail($id);
        $test->delete();
        return ['message'=>'Test deleted'];

    }
}
