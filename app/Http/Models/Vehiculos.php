<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Vehiculos extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'vehiculos';
    protected $hidden = ['created_at','updated_at'];

    public function asientos()
    {
        return $this->hasMany(Asiento::class);
    }
}
