<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dominio extends Model
{
    public function valores()
    {
        return $this->hasMany('App\Valor');
    }
}
