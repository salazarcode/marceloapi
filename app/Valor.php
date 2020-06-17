<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valor extends Model
{
    protected $table = 'valores';
    
    public function dominio()
    {
        return $this->belongsTo('App\Dominio');
    }
}
