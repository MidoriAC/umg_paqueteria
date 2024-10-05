<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamo extends Model
{
    protected $table = 'reclamo';
    protected $hidden = ['created_at','updated_at'];

    public function envio(){
        return $this->hasOne(Envios::class,'id','id_envio');
    }
}
