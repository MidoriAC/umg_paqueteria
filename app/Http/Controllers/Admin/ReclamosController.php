<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Reclamo;
use App\Http\Models\User_reclamo;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReclamosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isadmin');
        $this->middleware('user.status');
        $this->middleware('user.permissions'); 
    } 
    public function getReclamos(){
        $rol = Auth::user()->role;
        if($rol == 0){
            $reclamos = Reclamo::all();
        }else{
            $user_id = Auth::id();
            $user_reclamo_ids = User_reclamo::where('user_id', $user_id)->pluck('reclamo_id');
            $reclamos = Reclamo::whereIn('id', $user_reclamo_ids)->get();
        }
        $users = User::where('status','!=',100)->get();
        $data = ['reclamos' => $reclamos,'users' => $users];
        return view('admin.reclamo.home', $data);
    }

    public function postUserReclamos(Request $request,$id){ 
        $rules = [
            'user_id' => 'required',
        ];
        $message = [
           'user_id.required' => 'Se requiere un Usuario',
        ];
        $validator = Validator::make($request->all(), $rules,$message);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
        else:
            $user_reclamo = new User_reclamo();
            $user_reclamo-> reclamo_id = $id;
            $user_reclamo-> user_id = e($request->input('user_id'));
            if($user_reclamo->save()):
                $nombre = DB::table('users')->where('id', $user_reclamo->user_id)->value('name'); 
                $apellido = DB::table('users')->where('id', $user_reclamo->user_id)->value('lastname'); 
                $reclamo = DB::table('reclamo')->where('id', $user_reclamo->reclamo_id)->value('id_envio'); 
                $envio = DB::table('envios')->where('id', $reclamo)->value('codigo'); 
                $final = 'El usuario ' . $nombre . ' ' . $apellido . ' ha sido asignado al reclamo del envío ' . $envio;
                //AUDITORIA
                 $user = Auth::user()->id;
                 $date_zone = date('Y-m-d');    
                 $data = array(["accion" => "Asocio usuario","table" => "Reclamos","name" => $final]);
                 $audit = json_encode($data);
                 DB::insert('insert into auditoria (user_id, homework,created_at) values (?, ?, ?)', [$user, $audit,$date_zone]);
                //AUDITORIA AGREGAR     
                return back()->with('message','Se Guardo con exito')->with('typealert','info ');
            endif;
        endif;
    }
    public function postUserReclamosEstado($id){
        $reclamo = Reclamo::findOrFail($id);
        if($reclamo->estado == "0"):
           $reclamo->estado = "1";
           $msg = "Reclamo Cerrado";
        else:
           $reclamo->estado = "0";
           $msg = "Reclamo Pendiente";
        endif;
        if($reclamo->save()):
           return back()->with('message',$msg)->with('typealert','warning');
        endif;
    }
}
