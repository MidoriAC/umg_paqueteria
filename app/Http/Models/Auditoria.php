<?php

namespace App\Http\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    //definimos el campo deleted
    protected $dates = ['deleted_at'];
    protected $table = 'auditoria';
    protected $hidden = ['created_at','updated_at'];
    protected $casts = ['homework' => 'array'];

    public function user_auditoria(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
