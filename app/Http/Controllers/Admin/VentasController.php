<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Ventas;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isadmin');
        $this->middleware('user.status');
        $this->middleware('user.permissions'); 
    }
    public function getVentas(){
        $ventas = Ventas::all();
        $data = ['ventas' => $ventas,];
        return view('admin.ventas.home',$data);
    }
}
