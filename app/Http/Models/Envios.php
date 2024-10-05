<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Envios extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'envios';
    protected $hidden = ['created_at','updated_at'];

    public function vehi(){
        return $this->hasOne(Vehiculos::class,'id','vehiculo_id'); 
    }

    public function suc_emis(){
        return $this->hasOne(Sucursales::class,'id','sucursal_emisor_id'); 
    }

    public function suc_recep(){
        return $this->hasOne(Sucursales::class,'id','sucursal_receptor_id'); 
    }

}
