<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial_envio extends Model
{
    protected $table = 'historial_envio';
    protected $casts = ['accion' => 'array'];
}
