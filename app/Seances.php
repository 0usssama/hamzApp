<?php

namespace HamzaApp;

use Illuminate\Database\Eloquent\Model;

class Seances extends Model
{
    //
    protected $fillable = [
        'type_seance', 'mois_id','etat_seance', 'cloture_date'
    ];
    public function mois(){
        return $this->belongsTo('HamzaApp\Mois');
    }
}
