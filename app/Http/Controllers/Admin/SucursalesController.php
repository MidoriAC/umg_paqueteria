<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Sucursales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SucursalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isadmin');
        $this->middleware('user.status');
        $this->middleware('user.permissions'); 
    }
    public function getSucursales(){
        $departamentos = DB::table('departamentos')->get();
        $sucursales = Sucursales::all();
        $data = ['departamentos' => $departamentos,'sucursales' => $sucursales];
        return view('admin.sucursales.home',$data);
    }
    public function filterDepartamento(Request $request){
        $provincias = DB::table('municipios')
                            ->where('department_id',$request->department_id)
                            ->get();
        if(count($provincias) > 0){
            return response()->json($provincias);
        }  
    }
    public function postSucursales(Request $request){ 
        $rules = [
            'departamento_id' => 'required',
            'municipio_id' => 'required',
            'sucursal' => 'required',
            'hora_apertura' => 'required',
            'hora_cierre' => 'required',
        ];
        $message = [
           'departamento_id.required' => 'Se requiere un Departamento',
           'municipio_id.required' => 'Se requiere un municipio',
           'sucursal.required' => 'Se requiere la Sucursal',
           'hora_apertura.required' => 'Se requiere la hora de apertura',
           'hora_cierre.required' => 'Se requiere la hora de cierre',
        ];
        $validator = Validator::make($request->all(), $rules,$message);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
        else:
            $sucursales = new Sucursales();
            $sucursales-> departamento_id = e($request->input('departamento_id'));
            $sucursales-> municipio_id = e($request->input('municipio_id'));
            $sucursales-> sucursal = e($request->input('sucursal'));
            $sucursales-> telefono = e($request->input('telefono'));
            $sucursales-> hora_apertura = e($request->input('hora_apertura'));
            $sucursales-> hora_cierre = e($request->input('hora_cierre'));
            if($request->hasFile('imagen_tienda')):
                $path = '/'.date('y-m-d');
                $fileBas = trim($request->file('imagen_tienda')->getClientOriginalExtension());
                $namebas = Str::slug(str_replace($fileBas ,'',$request->file('imagen_tienda')->getClientOriginalName()));
                $filename2 = rand(1,999).'-'.$namebas.'.'.$fileBas;
                $sucursales->file_path = date('y-m-d');
                $sucursales->imagen_tienda = $filename2;
            else:
                $sucursales->file_path = date('y-m-d');
                $sucursales->imagen_tienda = 'sin_pdf.pdf';
            endif;
            if($sucursales->save()):
                //AUDITORIA
                  $user = Auth::user()->id;
                  $date_zone = date('Y-m-d');    
                  $sucursal = $sucursales-> sucursal;
                  $data = array(["accion" => "Nueva Sucursal ","table" => "Sucursales","name" => $sucursal]);
                  $audit = json_encode($data);
                  DB::insert('insert into auditoria (user_id, homework,created_at) values (?, ?, ?)', [$user, $audit,$date_zone]);
                //ADD 
                //AUDITORIA AGREGAR 
                if($request->hasFile('imagen_tienda')):
                    $fl = $request->imagen_tienda->storeAs($path,$filename2,'uploads');
                endif;
                return back()->with('message','Se Guardo con exito la sucursal  ')->with('typealert','info ');
            endif;
        endif;
    }
    public function getSucursalesEdit($id){
        $sucursal = Sucursales::findOrFail($id);
        $departamentos = DB::table('departamentos')->get();
        $data = ['departamentos' => $departamentos,'sucursal' => $sucursal];
        return view('admin.sucursales.edit',$data);
    }
    public function postSucursalesEdit(Request $request,$id){ 
        $rules = [
            'departamento_id' => 'required',
            'municipio_id' => 'required',
            'sucursal' => 'required',
            'hora_apertura' => 'required',
            'hora_cierre' => 'required',
        ];
        $message = [
           'departamento_id.required' => 'Se requiere un Departamento',
           'municipio_id.required' => 'Se requiere un Municipio',
           'sucursal.required' => 'Se requiere la Sucursal',
           'hora_apertura.required' => 'Se requiere la hora de apertura',
           'hora_cierre.required' => 'Se requiere la hora de cierre',
        ];
        $validator = Validator::make($request->all(), $rules,$message);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
        else:
            $sucursal = Sucursales::findOrFail($id);
            $sucursal-> departamento_id = e($request->input('departamento_id'));
            $sucursal-> municipio_id = e($request->input('municipio_id'));
            $sucursal-> sucursal = e($request->input('sucursal'));
            $sucursal-> telefono = e($request->input('telefono'));
            $sucursal-> hora_apertura = e($request->input('hora_apertura'));
            $sucursal-> hora_cierre = e($request->input('hora_cierre'));
            if($request->hasFile('imagen_tienda')):
                $path = $sucursal->file_path;
                $fileExt = trim($request->file('imagen_tienda')->getClientOriginalExtension());
                $edit = 'editado';
                $name = Str::slug(str_replace($fileExt ,'',$request->file('imagen_tienda')->getClientOriginalName()));
                $filename = rand(1,999).'-'.$edit.'-'.$name.'.'.$fileExt;
                $sucursal->imagen_tienda = $filename; 
            endif;
            if($sucursal->save()):
                //AUDITORIA
                $user = Auth::user()->id;
                $date_zone = date('Y-m-d');    
                $sucursal = $sucursal-> sucursal;
                $data = array(["accion" => "Edito Sucursal ","table" => "Sucursales","name" => $sucursal]);
                $audit = json_encode($data);
                DB::insert('insert into auditoria (user_id, homework,created_at) values (?, ?, ?)', [$user, $audit,$date_zone]);
                //AUDITORIA
                if($request->hasFile('imagen_tienda')):
                    $fl = $request->imagen_tienda->storeAs($path,$filename,'uploads');
                endif;
                return back()->with('message','Se Edito con exito la sucursal  ')->with('typealert','info ');
            endif;
        endif;
    }
    
}
