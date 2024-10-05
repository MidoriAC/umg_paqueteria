<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Sucursales extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'sucursales';
    protected $hidden = ['created_at','updated_at'];

    public function depart(){
        return $this->hasOne(Departamentos::class,'id','departamento_id'); 
    }
    public function provin(){
        return $this->hasOne(Provincias::class,'id','municipio_id');
    }
}
