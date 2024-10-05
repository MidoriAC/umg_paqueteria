<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    protected $table = 'asientos';
    protected $fillable = ['numero', 'ocupado', 'vehiculo_id'];
    
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class);
    }
}
