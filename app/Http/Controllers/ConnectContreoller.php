<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class ConnectContreoller extends Controller
{
    public function __construct(){
        $this->middleware('guest')->except(['getLogout']);
    }
    public function getLogin(){
        return view('connect.login');
    }
    public function getRegister(){
        return view('connect.register');
    }
    public function postLogin(Request $request){ 
        $rules = [
          'email' => 'required|email',
          'password' => 'required|min:8'
        ];
        $message = [
          'email.required' => 'El Email es requerido.',
          'email.email' => 'El formato de su Email no es el correcto.',
          'password.required' => 'Su Contraseña es requerido.',
          'password.min' => 'La contraseña debe tener mínimo 8 caracteres.'
        ];
        $validator = Validator::make($request->all(), $rules, $message);
            if($validator->fails()):
                return back()->withErrors($validator)->with('message','Se ha producido un error:')->with('typealert','danger');
            else:
            if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true)):
                if(Auth::user()->status == "100"):
                    return redirect('/logout');
                else: 
                    return redirect('/');
                endif;
            else:
                return back()->with('message','El Correo o Contraeña son incorrectas')->with('typealert','danger');
            endif; 
        endif;
    }
    public function postRegister(Request $request){
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
              return redirect('/login')->with('message','Su cuenta esta registrada')->with('typealert','info');
            endif;
        endif;
    }
    public function getLogout(){
        $status = Auth::user()->status;
        Auth::logout();
        if($status == "100"):
            return redirect('/login')->with('message','Su cuenta está suspendida por favor si desea apelar a esta decisión comunícate con info@contigo.com')->with('typealert','danger');;
        else:
            return redirect('/');
        endif; 
    }
}
