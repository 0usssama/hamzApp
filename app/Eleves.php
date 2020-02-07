<?php

namespace HamzaApp;

use Illuminate\Database\Eloquent\Model;

class Eleves extends Model
{
    //

     protected $fillable = [
        'nom_prenom', 'num_tel', 'type', 'annee'
    ];
    public function mois(){

        return $this->hasMany('HamzaApp\Mois');
    }

    public function payments(){

        return $this->hasMany('HamzaApp\Mois');
    }
}
