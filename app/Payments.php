<?php

namespace HamzaApp;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    //
    protected $fillable = [
         'eleves_id','montant', 'versement', 'mois_id'
    ];
    public function eleves(){
        return $this->belongsTo('HamzaApp\Eleves');
    }
}
