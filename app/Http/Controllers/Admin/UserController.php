<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('isadmin');
        // $this->middleware('user.status');
        // $this->middleware('user.permissions'); 
       
    }
    public function getUsers(){
        $users = User::orderBy('id','Desc')->where('id_sucursal', 1)->get();
        $usuarios = User::where('id_sucursal', Auth::user()->id_sucursal)->get();
        $conductores = DB::table('conductor')
        ->where('id_sucursal', Auth::user()->id_sucursal)
        ->get();

        $data = ['users' => $users, 'usuarios' => $usuarios, 'conductores' => $conductores];
        return view('admin.users.home', $data);
    }
    public function postUsers(Request $request){
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'number' => 'required|unique:users,number',
            'password' => 'required|min:8',
            'cpassword' => 'required|min:8|same:password'
          ];
        $message = [
            'name.required' => 'Su nombre es requerido.',
            'lastname.required' => 'Sus Apellidos son requerido.',
            'email.required' => 'El Email es requerido.',
            'email.email' => 'El formato de su Email no es el correcto.',
            'email.unique' => 'El Email ya está en uso por otro usuario.',
            'number.required' => 'El celular es requerido.',
            'number.unique' => 'El celular ya está en uso por otro usuario.',
            'password.required' => 'Su Contraseña es requerido.',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
            'cpassword.required' => 'Es necesario confirmar su contraseña.',
            'cpassword.min' => 'La contraseña debe tener mínimo 8 caracteres.',
            'cpassword.same' => 'Las contraseñas no coinciden.',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
        else:
            $user = new User();
            $user->role = 2;
            $user->status = 0;
            $user->name = e($request->input('name'));
            $user->lastname = e($request->input('lastname'));
            $user->email = e($request->input('email'));
            $user->number = e($request->input('number'));
            $user->password = Hash::make($request->input('password'));
            if($user->save()):
              return back()->with('message','Su cuenta esta registrada')->with('typealert','info');
            endif;
        endif;
    }

    public function getUsersEdit($id){
        $u = User::findOrFail($id);
        $data = ['u' => $u];
        return view('admin.users.edit',$data); 
    }
    public function posttUsersEdit(Request $request,$id){
        $u = User::findOrFail($id);
        $u->role = $request->input('user_type');
        if($request->input('user_type') == "0" || $request->input('user_type') == "1"):
            if(is_null($u->permissions)):
                $permissions = [
                   'dashboard' => true,
                   'user_account' => true,
                ];
                $permissions = json_encode($permissions);
                $u->permissions = $permissions;
                $u->status = 1;
            endif;
        else:
            $u->permissions = null; 
        endif;
        if($u->save()):
            if($request->input('user_type') == "0" || $request->input('user_type') == "1"):
                return redirect('/admin/user/'.$u->id.'/permission')->with('message','El rol del usuario ya se actualizo con éxito asígnele los permisos correspondientes')->with('typealert','info');
            else:
                return back()->with('message','El rol del usario ya se actualizo con exito')->with('typealert','info');
            endif;         
        endif;
    }

    public function getUsersPermission($id){
        $u = User::findOrFail($id);
        $data = ['u' => $u];
        return view('admin.users.permission',$data);
    }
    public function postUsersPermission(Request $request,$id){
        $u = User::findOrFail($id);
        $u->permissions = $request->except(['_token']);
        if($u->save()):
            return back()->with('message','Los permisos del usuario fueron actualizados con exito')->with('typealert','warning');
        endif;
    }

    public function getUsersBanned($id){
        $u = User::findOrFail($id);
        if($u->status == "100"):
           $u->status = "1";
           $msg = "Usuario Activo nuevamente";
        else:
           $u->status = "100";
           $u->role = "2";
           $msg = "Usuario suspendido con éxito";
        endif;
        if($u->save()):
           return back()->with('message',$msg)->with('typealert','warning');
        endif;
    }

    public function getAccountEdit(){
        return view('admin.users.mi_dato');
    }
    public function postAccountEditPassword(Request $request){
        $rules = [
            'apassword' => 'required|min:8',
            'password' => 'required|min:8',
            'cpassword' => 'required|min:8|same:password'
          ];
          $message = [
            'apassword.required' => 'Digite su contraseña actual',
            'apassword.min' => 'La contraseña actual debe poseer minimo 8 caracteres',
            'password.required' => 'Digite su nueva contraseña',
            'password.min' => 'La nueva contraseña debe poseer minimo 8 caracteres',
            'cpassword.required' => 'Confirme su nueva contraseña',
            'cpassword.min' => 'La nueva contraseña debe poseer minimo 8 caracteres',
            'cpassword.same' => 'Las contraseñas no coinciden'
          ];
          $validator = Validator::make($request->all(), $rules, $message);
          if($validator->fails()):
              return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
          else:
            $u = User::find(Auth::id());
            if(Hash::check($request->input('apassword'), $u->password)):
               $u->password = Hash::make($request->input('password'));
               if($u->save()):
                return back()->with('message','Su contraseña se actualizo')->with('typealert','success');
               endif;
            else:
                return back()->with('message','Su contraseña actual es errónea: ')->with('typealert','danger');
            endif;   
          endif;
    } 
    public function postAccountEditInfo(Request $request){
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
          ];
         $message = [
            'name.required' => 'El nombre es requiredo',
            'lastname.required' => 'Sus apellidos son requiredo',
          ];
        $validator = Validator::make($request->all(), $rules, $message);
        if($validator->fails()):
           return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
        else:
            $u = User::find(Auth::id());
            $u->name = e($request->input('name'));
            $u->lastname = e($request->input('lastname'));
            if($u->save()):
                return back()->with('message','Sus datos se actualizaron con éxito')->with('typealert','success');
            endif;
        endif;
    }


    //*Lógica para almacenar conductores:

    public function postConductor(Request $request) {
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'licencia' => 'required',
            'foto_dpi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_licencia' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_usuario_app' => 'required|exists:users,id',
        ];
    
        $message = [
            'nombre.required' => 'El nombre es requerido.',
            'apellido.required' => 'El apellido es requerido.',
            'telefono.required' => 'El número de teléfono es requerido.',
            'licencia.required' => 'La licencia es requerida.',
            'foto_dpi.required' => 'La foto DPI es requerida.',
            'foto_licencia.required' => 'La foto de licencia es requerida.',
            'id_usuario_app.required' => 'El usuario asignado en app es requerido.',
            'id_usuario_app.exists' => 'El usuario seleccionado no existe.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $message);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error:')->with('typealert', 'danger');
        } else {
            // Almacenar las imágenes
            $fotoDpiPath = $request->file('foto_dpi')->store('public/conductores/fotos_dpi');
            $fotoLicenciaPath = $request->file('foto_licencia')->store('public/conductores/fotos_licencia');
    
            // Insertar los datos en la tabla conductor
            DB::table('conductor')->insert([
                'nombre' => e($request->input('nombre')),
                'apellido' => e($request->input('apellido')),
                'telefono' => e($request->input('telefono')),
                'licencia' => e($request->input('licencia')),
                'dpi' => e($request->input('dpi')),
                'foto_dpi' => $fotoDpiPath,
                'foto_licencia' => $fotoLicenciaPath,
                'id_usuario_app' => $request->input('id_usuario_app'),
                'id_sucursal' => Auth::user()->id_sucursal,
                'created_at' => now(),
                'updated_at' => now(),
                'estado' => 1,
            ]);
    
            return back()->with('message', 'El conductor se ha registrado con éxito')->with('typealert', 'success');
        }
    }

    public function getConductorEdit($id) {
        $conductor = DB::table('conductor')->where('id', $id)->first();
        $data = ['conductor' => $conductor];
        return view('admin.users.edit-conductor', $data);
    }
    
    public function postConductorEdit(Request $request, $id) {
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'licencia' => 'required',
            'dpi' => 'required',
            'foto_dpi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_licencia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    
        $message = [
            'nombre.required' => 'El nombre es requerido.',
            'apellido.required' => 'El apellido es requerido.',
            'telefono.required' => 'El número de teléfono es requerido.',
            'licencia.required' => 'La licencia es requerida.',
            'dpi.required' => 'El DPI es requerido.',
            'foto_dpi.image' => 'La foto DPI debe ser una imagen.',
        'foto_licencia.image' => 'La foto de licencia debe ser una imagen.',
        'foto_dpi.mimes' => 'La foto DPI debe ser un archivo de tipo: jpeg, png, jpg, gif.',
        'foto_licencia.mimes' => 'La foto de licencia debe ser un archivo de tipo: jpeg, png, jpg, gif.',
        'foto_dpi.max' => 'La foto DPI no debe exceder los 2MB.',
        'foto_licencia.max' => 'La foto de licencia no debe exceder los 2MB.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $message);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error:')->with('typealert', 'danger');
        } else {
            $conductor = DB::table('conductor')->where('id', $id)->first();
    
            if ($request->hasFile('foto_dpi')) {
                $fotoDpiPath = $request->file('foto_dpi')->store('public/conductores/fotos_dpi');
                DB::table('conductor')->where('id', $id)->update(['foto_dpi' => $fotoDpiPath]);
            }
    
            if ($request->hasFile('foto_licencia')) {
                $fotoLicenciaPath = $request->file('foto_licencia')->store('public/conductores/fotos_licencia');
                DB::table('conductor')->where('id', $id)->update(['foto_licencia' => $fotoLicenciaPath]);
            }
    
            return back()->with('message', 'Las fotos se han actualizado con éxito')->with('typealert', 'success');
        }
    }
    
    public function getConductorSuspend($id) {
        DB::table('conductor')->where('id', $id)->update(['estado' => 0]);
        return back()->with('message', 'El conductor ha sido suspendido con éxito')->with('typealert', 'warning');
    }
    
    public function getConductorActivate($id) {
        DB::table('conductor')->where('id', $id)->update(['estado' => 1]);
        return back()->with('message', 'El conductor ha sido activado con éxito')->with('typealert', 'success');
    }
}
