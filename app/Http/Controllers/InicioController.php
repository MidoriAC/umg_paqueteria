<?php

namespace App\Http\Controllers;

use App\Http\Models\Anuncios;
use App\Http\Models\Envios;
use App\Http\Models\Historial_envio;
use App\Http\Models\Reclamo;
use App\Http\Models\Sucursales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InicioController extends Controller
{
    public function getInicio(){
        $anuncios = Anuncios::where('estado',1)->get();
        $sucursales = Sucursales::all();
        $data = ['anuncios' => $anuncios,'sucursales' => $sucursales];
        return view('welcome',$data);
    }
    public function getConsulta(Request $request){
        $name = $request->get('name');
        if ($name !== null && $name !== '' && $name !== '0') {
            $query = Historial_envio::query();
            if ($name != null) {
                $query->whereJsonContains('accion', ['name' => $name]);
            }
            $auditoria = $query->get();
        } else {
            $auditoria = [];
        }
        //dd($auditoria); 
        $data['auditoria'] = $auditoria;
        return view('consulta',$data);
    }
    public function getReclamo(){
        return view('reclamo');
    }
    public function postReclamo(Request $request){ 
        $rules = [
            'codigo' => 'required|exists:envios,codigo',
            'telefono' => 'required',
            'nombre' => 'required',
            'reclamo_text' => 'required',
        ];
        $message = [
           'codigo.required' => 'Se requiere un código',
           'codigo.exists' => 'El código proporcionado no esta asignado a un envio',
           'telefono.required' => 'Se requiere un Telefono',
           'nombre.required' => 'Se requiere un nombre',
           'reclamo_text.required' => 'Se requiere la descripcion',
        ];
        $validator = Validator::make($request->all(), $rules,$message);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
        else: 
            $codigo = $request->input('codigo');
            $id_reclamo = Envios::where('codigo',$codigo)->value('id');
            $reclamo = new Reclamo();
            $reclamo-> id_envio =  $id_reclamo;
            $reclamo-> name = e($request->input('nombre'));
            $reclamo-> telefono = e($request->input('telefono'));
            $reclamo-> correo = e($request->input('correo'));
            $reclamo-> estado = 0;
            $reclamo-> texto = e($request->input('reclamo_text'));
            if($request->hasFile('imagen_reclamo')):
                $path = '/'.date('y-m-d');
                $fileBas = trim($request->file('imagen_reclamo')->getClientOriginalExtension());
                $namebas = Str::slug(str_replace($fileBas ,'',$request->file('imagen_reclamo')->getClientOriginalName()));
                $filename2 = rand(1,999).'-'.$namebas.'.'.$fileBas;
                $reclamo->file_path = date('y-m-d');
                $reclamo->archivo = $filename2;
            else:
                $reclamo->file_path = date('y-m-d');
                $reclamo->archivo = 'sin_pdf.pdf';
            endif;
            if($reclamo->save()):
                if($request->hasFile('imagen_reclamo')):
                    $request->imagen_reclamo->storeAs($path,$filename2,'uploads');
                endif;
                return back()->with('message','Se Guardo con exito un asesor se comunicara por Email o WhatsApp estate atento')->with('typealert','info ');
            endif;
        endif;
    }
}
