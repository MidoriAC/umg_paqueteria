<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Envios;
use App\Http\Models\Sucursales;
use App\Http\Models\Vehiculos;
use App\Http\Models\Ventas;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use \PDF;
use Illuminate\Support\Facades\Auth;

class EnviosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isadmin');
        $this->middleware('user.status');
        $this->middleware('user.permissions'); 
    }
    //ENVIOS
    public function getEnvios(){
        $departamentos = DB::table('departamentos')->get();
        $sucursales = Sucursales::all();
        $vehiculos = Vehiculos::whereIn('estado',[0, 2])->get();
        $vehiculosEnEnvios = Vehiculos::join('envios', 'vehiculos.id', '=', 'envios.vehiculo_id')
                                        ->whereIn('envios.estado', [0, 1])
                                        ->distinct()
                                        ->get(['vehiculos.*']);

        // Obtenesmos la sucursal del usuario
        $user = Auth::user()->id_sucursal;
        $sucursalUsuario = DB::table('sucursales')
                        ->select(
                            'departamentos.id as id_depto',
                            'departamentos.name as nombre_depto',
                            'municipios.id as id_mun',
                            'municipios.name as nombre_mun',
                        )
                        ->join('departamentos', 'sucursales.departamento_id', '=', 'departamentos.id')
                        ->join('municipios', 'sucursales.municipio_id', '=', 'municipios.id')
                        ->where('sucursales.id', $user)
                        ->first();

        $data = ['departamentos' => $departamentos,'sucursales' => $sucursales,'vehiculos' => $vehiculos,'vehiculosEnEnvios' => $vehiculosEnEnvios, 'sucursalUsuario'=>$sucursalUsuario];
        return view('admin.envios.home',$data);
    }
    public function filterDepartamentoEnvios(Request $request){
        $provincias = DB::table('municipios')
                            ->where('department_id',$request->department_id)
                            ->get();
        if(count($provincias) > 0){
            return response()->json($provincias);
        }  
    }
    public function filterSucursalEnvios(Request $request){
        $sucursales = DB::table('sucursales')
                            ->where('municipio_id',$request->municipio_id)
                            ->get();
        if(count($sucursales) > 0){
            return response()->json($sucursales);
        }  
    }
    public function postEnvios(Request $request){ 
        $rules = [
            'sucursal_emisor_id' => 'required',
            'sucursal_receptor_id' => 'required',
            'dpi_emisor' => 'required',
            'dpi_receptor' => 'required',
            'contraseña' => 'required',
        ];
        $message = [
           'sucursal_emisor_id.required' => 'Se requiere sucursal de emisor',
           'sucursal_receptor_id.required' => 'Se requiere sucursal de receptor',
           'dpi_emisor.required' => 'Se requiere el dpi del emisor',
           'dpi_receptor.required' => 'Se requiere el dpi del receptor',
           'contraseña.required' => 'Se requiere una contraseña',
        ];
        $validator = Validator::make($request->all(), $rules,$message);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
        else:
            $envios = new Envios();
            $envios-> codigo = Str::random(10);
            $envios-> sucursal_emisor_id = e($request->input('sucursal_emisor_id'));
            $envios-> sucursal_receptor_id = e($request->input('sucursal_receptor_id'));
            $envios-> name_emisor = e($request->input('name_emisor'));
            $envios-> dpi_emisor = e($request->input('dpi_emisor'));
            $envios-> name_receptor = e($request->input('name_receptor'));
            $envios-> dpi_receptor = e($request->input('dpi_receptor'));
            $envios-> peso = e($request->input('peso'));
            $envios-> precio = e($request->input('precio'));
            $envios-> vehiculo_id = e($request->input('vehiculo_id'));
            $envios-> fecha_salida = e($request->input('fecha_salida'));
            $envios-> contraseña = e($request->input('contraseña'));
            $envios-> fragil = request('fragil') ? 1 : 0;
            $envios-> estado = 0; 
            if($envios->save()):
                //HISTORIAL ENVIOS AGREGAR 
                $codigo = $envios->codigo;
                $user = Auth::user()->id;
                $data = array(["accion" => "Nuevo Envio","Estado" => "En Espera","name" =>  $codigo]);
                $audit = json_encode($data);
                $data_envio = array(["accion" => "Nuevo Envio","table" => "Envio","name" =>  $codigo]);
                $audit_envio = json_encode($data_envio);
                $date_zone = date('Y-m-d\TH:i');
                DB::insert('insert into historial_envio (user_id, accion,created_at) values (?, ?, ?)', [$user, $audit,$date_zone]);
                DB::insert('insert into auditoria (user_id, homework,created_at) values (?, ?, ?)', [$user, $audit_envio,$date_zone]);
                //HISTORIAL ENVIOS AGREGAR 
                Ventas::create([
                    'envio_id' => $envios->id,
                    'vehiculo_id' => $envios-> vehiculo_id,
                    'sucursal_emisor_id' => $envios-> sucursal_emisor_id,
                    'user_id' =>  Auth::user()->id,
                    'precio' =>  $envios-> precio,
                    'fecha' => $envios-> fecha_salida ,
                ]);
                return back()->with('message','Se Guardo con exito el envio')->with('typealert','info ');
            endif; 
        endif;
    }
    public function postEstadosEnvios(Request $request,$id){ 
        $vehiculo = Vehiculos::findOrFail($id);
        $vehiculo-> estado = e($request->input('estado'));
        // Obtenemos los envíos actualizados
        $enviosActualizados = Envios::where('vehiculo_id', $id)
        ->where('estado', '!=', 4)
        ->get();

        // Actualizamos el estado de los envíos
        Envios::where('vehiculo_id', $id)
        ->where('estado', '!=', 4)
        ->update(['estado' => $request->input('estado')]);

        if($vehiculo->save()):
           // HISTORIAL ENVIOS AGREGAR
            foreach ($enviosActualizados as $envio) {
                $codigo = $envio->codigo;
                $user = Auth::user()->id;
                if ($vehiculo-> estado == 0) {
                    $data = array(["accion" => "Envio", "Estado" => "En Espera", "name" => $codigo]);
                }elseif ($vehiculo-> estado  == 1) {
                    $data = array(["accion" => "Envio", "Estado" => "En Ruta", "name" => $codigo]);
                }elseif ($vehiculo-> estado  == 2) {
                    $data = array(["accion" => "Envio", "Estado" => "Ya Llego", "name" => $codigo]);
                }
                $audit = json_encode($data);
                $date_zone = date('Y-m-d\TH:i');
                DB::insert('insert into historial_envio (user_id, accion, created_at) values (?, ?, ?)', [$user, $audit, $date_zone]);
            }
            //HISTORIAL ENVIOS AGREGAR 
            return back()->with('message','Se Guardo con exito')->with('typealert','info ');
        endif;
    }
    
    public function getEnviosEdit($id){
        $departamentos = DB::table('departamentos')->get();
        $sucursales = Sucursales::all();
        $vehiculos = Vehiculos::whereIn('estado',[0, 2])->get();
        $envio = Envios::findOrFail($id);

        $data = ['departamentos' => $departamentos,'sucursales' => $sucursales,'vehiculos' => $vehiculos,'envio' => $envio];
        return view('admin.envios.edit',$data);
    }
    public function postEnviosEdit(Request $request,$id){ 
        $rules = [
            'sucursal_emisor_id' => 'required',
            'sucursal_receptor_id' => 'required',
            'dpi_emisor' => 'required',
            'dpi_receptor' => 'required',
            'contraseña' => 'required',
        ];
        $message = [
           'sucursal_emisor_id.required' => 'Se requiere sucursal de emisor',
           'sucursal_receptor_id.required' => 'Se requiere sucursal de receptor',
           'dpi_emisor.required' => 'Se requiere el dpi del emisor',
           'dpi_receptor.required' => 'Se requiere el dpi del receptor',
           'contraseña.required' => 'Se requiere una contraseña',
        ];
        $validator = Validator::make($request->all(), $rules,$message);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
        else:
            $envio = Envios::findOrFail($id);
            $envio-> sucursal_emisor_id = e($request->input('sucursal_emisor_id'));
            $envio-> sucursal_receptor_id = e($request->input('sucursal_receptor_id'));
            $envio-> name_emisor = e($request->input('name_emisor'));
            $envio-> dpi_emisor = e($request->input('dpi_emisor'));
            $envio-> name_receptor = e($request->input('name_receptor'));
            $envio-> dpi_receptor = e($request->input('dpi_receptor'));
            $envio-> peso = e($request->input('peso'));
            $envio-> precio = e($request->input('precio'));
            $envio-> vehiculo_id = e($request->input('vehiculo_id'));
            $envio-> fecha_salida = e($request->input('fecha_salida'));
            $envio-> contraseña = e($request->input('contraseña'));
            $envio-> fragil = request('fragil') ? 1 : 0;
            if($envio->save()):
                //HISTORIAL ENVIOS AGREGAR 
                $codigo = $envio->codigo;
                $user = Auth::user()->id;
                $data = array(["accion" => "Edito Envio","Estado" => "En Espera","name" =>  $codigo]);
                $audit = json_encode($data);
                $data_envio = array(["accion" => "Edito Envio","table" => "Envio","name" =>  $codigo]);
                $audit_envio = json_encode($data_envio);
                $date_zone = date('Y-m-d\TH:i');
                DB::insert('insert into historial_envio (user_id, accion,created_at) values (?, ?, ?)', [$user, $audit,$date_zone]);
                DB::insert('insert into auditoria (user_id, homework,created_at) values (?, ?, ?)', [$user, $audit_envio,$date_zone]);
                //HISTORIAL ENVIOS AGREGAR 
                return back()->with('message','Se Edito con exito el envio')->with('typealert','info ');
            endif; 
        endif;
    }

    public function generatePDF($id){
        $envio = Envios::findOrFail($id);
        $pdf = FacadePdf::loadView('admin.envios.vista',['envio' => $envio])->setPaper('8.5x14');
        return $pdf->stream('Clientes.pdf');
    }

    //RECEPCION
    public function getRecepcion(){
        $envios = Envios::whereIn('estado',[2,3])->orderby('estado', 'desc')->get();
        $data = ['envios' => $envios];
        return view('admin.recepcion.home',$data);
    }
    public function getStadoRecepcion($id){
        $envios = Envios::findOrFail($id);
        if($envios->estado == "2"):
           $envios->estado = "3";
           $msg = "Entregado";
        else:
           $envios->estado = "2";
           $msg = "Ya Llego"; 
        endif;
        if($envios->save()):
            if($envios->estado == "2"):
               //HISTORIAL ENVIOS AGREGAR 
               $codigo = $envios->codigo;
               $user = Auth::user()->id;
               $data = array(["accion" => "Envio","Estado" => "Ya Llego","name" =>  $codigo]);
               $audit = json_encode($data);
               $date_zone = date('Y-m-d\TH:i');
               DB::insert('insert into historial_envio (user_id, accion,created_at) values (?, ?, ?)', [$user, $audit,$date_zone]);
               //HISTORIAL ENVIOS AGREGAR 
            else:
               //HISTORIAL ENVIOS AGREGAR 
               $codigo = $envios->codigo;
               $user = Auth::user()->id;
               $data = array(["accion" => "Envio","Estado" => "Entregado","name" =>  $codigo]);
               $audit = json_encode($data);
               $date_zone = date('Y-m-d\TH:i');
               DB::insert('insert into historial_envio (user_id, accion,created_at) values (?, ?, ?)', [$user, $audit,$date_zone]);
               //HISTORIAL ENVIOS AGREGAR 
            endif;
           return back()->with('message',$msg)->with('typealert','warning');
        endif;
    } 
}
