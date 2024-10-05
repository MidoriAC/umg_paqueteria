<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Asiento;
use App\Http\Models\Vehiculos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VehiculosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isadmin');
        $this->middleware('user.status');
        $this->middleware('user.permissions'); 
    }
    public function getVehiculos(){
        $vehiculos = Vehiculos::all();
        $data = ['vehiculos' => $vehiculos];
        return view('admin.vehiculos.home',$data);
    }
    public function postVehiculos(Request $request){ 
        $rules = [
            'marca' => 'required',
            'modelo' => 'required',
            'n_placa' => 'required',
            'carga' => 'required',
        ];
        $message = [
           'marca.required' => 'Se requiere una Marca',
           'modelo.required' => 'Se requiere un Modelo',
           'n_placa.required' => 'Se requiere el Numero de Placa',
           'carga.required' => 'Se requiere la cantidad de carga en kilos',
        ];
        $validator = Validator::make($request->all(), $rules,$message);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
        else:
            $vehiculos = new Vehiculos();
            $vehiculos-> marca = e($request->input('marca'));
            $vehiculos-> modelo = e($request->input('modelo'));
            $vehiculos-> n_placa = e($request->input('n_placa'));
            $vehiculos-> color = e($request->input('color'));
            $vehiculos-> carga = e($request->input('carga'));
            $vehiculos-> tipo = 0;
            if($vehiculos->save()):
                if ($request->cantidad_asientos != 0) {
                    for ($i = 1; $i <= $request->cantidad_asientos; $i++) {
                        $asiento = new Asiento();
                        $asiento->numero = $i;
                        $asiento->ocupado = false;
                        $asiento->vehiculo_id = $vehiculos->id;
                        $asiento->save();
                    }   
                }
                //AUDITORIA
                $user = Auth::user()->id;
                $date_zone = date('Y-m-d');    
                $vehiculos = $vehiculos-> n_placa;
                $data = array(["accion" => "Nuevo Vehiculo ","table" => "Vehiculos","name" => $vehiculos]);
                $audit = json_encode($data);
                DB::insert('insert into auditoria (user_id, homework,created_at) values (?, ?, ?)', [$user, $audit,$date_zone]);
                //AUDITORIA AGREGAR     
                return back()->with('message','Se Guardo con exito el vehiculo')->with('typealert','info ');
            endif;
        endif;
    }
    public function getVehiculosEdit($id){
        $vehiculo = Vehiculos::findOrFail($id);
        $data = ['vehiculo' => $vehiculo];
        return view('admin.vehiculos.edit',$data);
    }
    public function postVehiculosEdit(Request $request,$id){ 
        $rules = [
            'marca' => 'required',
            'modelo' => 'required',
            'n_placa' => 'required',
            'carga' => 'required',
        ];
        $message = [
           'marca.required' => 'Se requiere una Marca',
           'modelo.required' => 'Se requiere un Modelo',
           'n_placa.required' => 'Se requiere el Numero de Placa',
           'carga.required' => 'Se requiere la cantidad de carga en kilos',
        ];
        $validator = Validator::make($request->all(), $rules,$message);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
        else:
            $vehiculo = Vehiculos::findOrFail($id);
            $vehiculo-> marca = e($request->input('marca'));
            $vehiculo-> modelo = e($request->input('modelo'));
            $vehiculo-> n_placa = e($request->input('n_placa'));
            $vehiculo-> color = e($request->input('color'));
            $vehiculo-> carga = e($request->input('carga'));
            if($vehiculo->save()):
                //AUDITORIA
                $user = Auth::user()->id;
                $date_zone = date('Y-m-d');    
                $vehiculo = $vehiculo-> n_placa;
                $data = array(["accion" => "Edito Vehiculo ","table" => "Vehiculos","name" => $vehiculo]);
                $audit = json_encode($data);
                DB::insert('insert into auditoria (user_id, homework,created_at) values (?, ?, ?)', [$user, $audit,$date_zone]);
                //AUDITORIA AGREGAR  
                return back()->with('message','Se Edito con exito el vehiculo')->with('typealert','info ');
            endif;
        endif;
    }
}
