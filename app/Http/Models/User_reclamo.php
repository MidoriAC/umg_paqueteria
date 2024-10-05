<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_reclamo extends Model
{
    protected $table = 'user_reclamo';
    protected $hidden = ['created_at','updated_at'];
}
