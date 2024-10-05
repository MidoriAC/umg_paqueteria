<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Anuncios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class AnuncioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isadmin');
        $this->middleware('user.status');
        $this->middleware('user.permissions'); 
    }
    //ENVIOS
    public function getAnuncio(){
        $departamentos = DB::table('departamentos')->get();
        $anuncios = Anuncios::all();
        $data = ['departamentos' => $departamentos,'anuncios' => $anuncios];
        return view('admin.anuncios.home',$data);
    }
    public function postAnuncio(Request $request){ 
        $rules = [
            'titulo' => 'required',
            'texto' => 'required',
        ];
        $message = [
           'titulo.required' => 'Se requiere un Titulo',
           'texto.required' => 'Se requiere una Texto',
        ];
        $validator = Validator::make($request->all(), $rules,$message);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
        else:
            $anuncio = new Anuncios();
            $anuncio-> titulo = e($request->input('titulo'));
            $anuncio-> texto = $request->input('texto');
            $anuncio-> sucursal_id = e($request->input('sucursal_id'));
            if($request->hasFile('imagen_anuncio')):
                $path = '/'.date('y-m-d');
                $fileBas = trim($request->file('imagen_anuncio')->getClientOriginalExtension());
                $namebas = Str::slug(str_replace($fileBas ,'',$request->file('imagen_anuncio')->getClientOriginalName()));
                $filename2 = rand(1,999).'-'.$namebas.'.'.$fileBas;
                $anuncio->file_path = date('y-m-d');
                $anuncio->imagen_anuncio = $filename2;
            else:
                $anuncio->file_path = date('y-m-d');
                $anuncio->imagen_anuncio = 'sin_pdf.pdf';
            endif;
            if($anuncio->save()):
                //AUDITORIA
                 $user = Auth::user()->id;
                 $date_zone = date('Y-m-d');    
                 $anuncio = $anuncio-> titulo;
                 $data = array(["accion" => "Nuevo Anuncio ","table" => "Anuncios","name" => $anuncio]);
                 $audit = json_encode($data);
                 DB::insert('insert into auditoria (user_id, homework,created_at) values (?, ?, ?)', [$user, $audit,$date_zone]);
                //AUDITORIA AGREGAR     
                if($request->hasFile('imagen_anuncio')):
                    $fl = $request->imagen_anuncio->storeAs($path,$filename2,'uploads');
                endif;
                return back()->with('message','Se Guardo con exito')->with('typealert','info ');
            endif;
        endif;
    }

    public function getAnuncioEdit($id){
        $departamentos = DB::table('departamentos')->get();
        $anuncio = Anuncios::findOrFail($id);
        $data = ['departamentos' => $departamentos,'anuncio' => $anuncio];
        return view('admin.anuncios.edit',$data);
    }

    public function postAnuncioEdit(Request $request,$id){ 
        $rules = [
            'titulo' => 'required',
            'texto' => 'required',
        ];
        $message = [
           'titulo.required' => 'Se requiere un Titulo',
           'texto.required' => 'Se requiere una Texto',
        ];
        $validator = Validator::make($request->all(), $rules,$message);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
        else:
            $anuncio = Anuncios::findOrFail($id);
            $anuncio-> titulo = e($request->input('titulo'));
            $anuncio-> texto = $request->input('texto');
            $anuncio-> sucursal_id = e($request->input('sucursal_id'));
            if($request->hasFile('imagen_anuncio')):
                $path = $anuncio->file_path;
                $fileExt = trim($request->file('imagen_anuncio')->getClientOriginalExtension());
                $edit = 'editado';
                $name = Str::slug(str_replace($fileExt ,'',$request->file('imagen_anuncio')->getClientOriginalName()));
                $filename = rand(1,999).'-'.$edit.'-'.$name.'.'.$fileExt;
                $anuncio->imagen_anuncio = $filename; 
            endif;
            if($anuncio->save()):
                //AUDITORIA
                $user = Auth::user()->id;
                $date_zone = date('Y-m-d');    
                $anuncio = $anuncio-> titulo;
                $data = array(["accion" => "Edito Anuncio ","table" => "Anuncios","name" => $anuncio]);
                $audit = json_encode($data);
                DB::insert('insert into auditoria (user_id, homework,created_at) values (?, ?, ?)', [$user, $audit,$date_zone]);
                //AUDITORIA AGREGAR  
                if($request->hasFile('imagen_anuncio')):
                    $fl = $request->imagen_anuncio->storeAs($path,$filename,'uploads');
                endif;
                return back()->with('message','Se Guardo con exito')->with('typealert','info ');
            endif;
        endif;
    }

    public function getAnuncioDelete($id){
        $anuncio = Anuncios::findOrFail($id);
        if($anuncio->delete()):
            //AUDITORIA Eliminar  Cliente
             $name =  $anuncio-> titulo;
             $user = Auth::user()->id;
             $data = array(["accion" => "Eliminar Anuncio","table" => "Anuncios","name" =>  $name]);
             $date_zone = date('Y-m-d\TH:i');
             $audit = json_encode($data);
             DB::insert('insert into auditoria (user_id, homework,created_at) values (?, ?, ?)', [$user, $audit,$date_zone]);
            //AUDITORIA Eliminar  Cliente
            return back()->with('message','Se Elimino con exito')->with('typealert','danger');
        endif;
    }

    public function getAnuncioEstado($id){
        $anuncio = Anuncios::findOrFail($id);
        if($anuncio->estado == "0"):
           $anuncio->estado = "1";
           $msg = "Visible";
        else:
           $anuncio->estado = "0";
           $msg = "No Visible";
        endif;
        if($anuncio->save()):
           return back()->with('message',$msg)->with('typealert','info');
        endif;
    }
}
