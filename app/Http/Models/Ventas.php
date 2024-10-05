<?php

namespace App\Http\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table = 'ventas';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = []; 
    
    public function vehi(){
        return $this->hasOne(Vehiculos::class,'id','vehiculo_id'); 
    }

    public function env(){
        return $this->hasOne(Envios::class,'id','envio_id');
    }

    public function suc(){
        return $this->hasOne(Sucursales::class,'id','sucursal_emisor_id');
    }

    public function usuario(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
