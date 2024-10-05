<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Auditoria;
use App\Http\Models\Reclamo;
use App\Http\Models\User_reclamo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isadmin');
        $this->middleware('user.status');
        $this->middleware('user.permissions'); 
    } 
    public function getDashboard(){
        $rol = Auth::user()->role;
        if($rol == 0){
            $reclamos = Reclamo::all();
        }else{
            $user_id = Auth::id();
            $user_reclamo_ids = User_reclamo::where('user_id', $user_id)->pluck('reclamo_id');
            $reclamos = Reclamo::whereIn('id', $user_reclamo_ids)->get();
        }
        $data = ['reclamos' => $reclamos];
        return view('admin.home', $data);
    }
    public function getAuditoria(){
        $auditoria = Auditoria::all();
        $users = User::all();
        $filter = ['users' => $users];
        $data['auditoria'] = $auditoria;
        return view('admin.auditoria.home', $data,$filter);
    }
}
