<?php

namespace HamzaApp;

use Illuminate\Database\Eloquent\Model;

class Tests extends Model
{
    //
    protected $fillable = [
        'titre', 'eleves_id', 'note', 'observation'
    ];
}
