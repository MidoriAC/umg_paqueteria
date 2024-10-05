@extends('admin.master')
@section('title','Editar Usuarios')
@section('content')
<div class="content">
    <div class="container-fluid">
       <div class="row">
        <div class="col-lg-6">
          <div class="card card-primary card-outline">
            <div class="card-body">
                <h3 class="pt-3"><i class="fas fa-user ml-3"></i> Infomración de usuario</h3>
                <hr>
                <div class="mini_profile">
                    <div class="text-center">
                        <img src="{{ url('../static/img/user.png')}}" class="avatar" width="200px" alt="">
                    </div>
                    <div class="info p-4">
                       <h6 class="title"><strong><i class="fas fa-user"></i> Nombres y Apellidos:</strong> </h6>
                       <h6 class="text ml-4">{{ $u->name}},{{ $u->lastname}}</h6>
                       <h6 class="title"><strong><i class="fas fa-at"></i> E-mail:</strong> </h6>
                       <h6 class="text ml-4">{{ $u->email}}</h6>
                       <h6 class="title"><strong><i class="fas fa-arrow-circle-left"></i> Registro al Sistema:</strong> </h6>
                       <h6 class="text ml-4">{{ $u->created_at}}</h6>
                       <h6 class="title"><strong><i class="fas fa-user-tag"></i> Rol De usuario:</strong> </h6>
                       <h6 class="text ml-4">{{getRoleUserArray(null,$u->role)}}</h6>
                       <h6 class="title"><strong><i class="fas fa-user-clock"></i> Estado De usuario:</strong> </h6>
                       <h6 class="text ml-4">{{getUserStatusArray(null,$u->status)}}</h6>
                    </div>  
                    <div class="text-center p-3">
                        @if(kvfj(Auth::user()->permissions,'user_banned'))
                          @if ($u->status == "100")
                            <a href="{{ url('/admin/user/'.$u->id.'/banned')}}" class="btn btn-success btn-lg">
                              <i class="fas fa-user-check"></i> Activar  Usuario
                            </a>
                          @else
                            <a href="{{ url('/admin/user/'.$u->id.'/banned')}}" class="btn btn-danger btn-lg">
                              <i class="fas fa-user-times"></i> Suspender Usuario
                            </a>
                          @endif
                        @endif
                    </div>
                </div>
            </div>
          </div>
        </div>
        @if(kvfj(Auth::user()->permissions,'user_edit'))
        <div class="col-lg-6">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <div class="inside"  style="background:white;">
                    <h3 class="pt-3"><i class="fas fa-user-edit ml-3"></i> Panel Edición</h3>
                    <hr>
                    <div class="p-4 mini_profile">
                       {!! Form::open(['url' => '/admin/user/'.$u->id.'/edit'])!!}
                       <div class="form-row">
                            <div class="form-group col-md-9">
                                <label for="">Rol de usuario: </label>
                                {!! Form::select('user_type',getRoleUserArray('list',null),$u->role, ['class' => 'form-control'] )!!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            {!! Form::submit('Guardar',['class' => 'btn btn-success'])!!}
                        </div>
                       {!! Form::close() !!}
                    </div>
               </div>
              </div>
            </div>
        </div>
        @endif
      </div>
    </div>  
</div>
@stop 