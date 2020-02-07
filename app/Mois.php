<?php

namespace HamzaApp;

use Illuminate\Database\Eloquent\Model;

class Mois extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'titre', 'eleves_id','payments_id','created_at', 'updated_at'
    ];
    public function eleves(){
        return $this->belongsTo('HamzaApp\Eleves');
    }
    public function payments(){
        return $this->belongsTo('HamzaApp\Payments');
    }
    public function seances(){
        return $this->hasMany('HamzaApp\Seances');
    }
}
