@extends('admin.master')
@section('title', 'Mis Datos')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{url('/admin')}}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Mis Datos</li>
                </ol>
              </nav>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <!-- column -->
        <div class="col-12">
            <div class="row">
                <div class="col-lg-6">
                  <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h3 class="pt-3"><i class="fas fa-user-edit ml-3"></i> Editar mis Datos</h3>
                        <hr>
                        <div class="mini_profile">
                            <div class="info p-4">
                             {!! Form::open(['url' =>'admin/account/edit/info'])!!}
                             <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="name">Nombre</label>
                                    {!!Form::text('name',Auth::user()->name, ['class' => 'form-control'])!!}
                                </div>
                            </div> 
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="name">Apellidos</label>
                                    {!!Form::text('lastname',Auth::user()->lastname, ['class' => 'form-control'])!!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="name">E-mail</label>
                                    {!!Form::text('email',Auth::user()->email, ['class' => 'form-control','disabled'])!!}
                                </div>
                            </div>
                             {!! Form::submit('Guardar',['class' => 'btn btn-success'])!!}
                             {!! Form::close() !!}
                            </div>  
                        </div>        
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-primary card-outline">
                      <div class="card-body">
                        <h3 class="pt-3"><i class="fas fa-user-edit ml-3"></i> Editar mi Contraseña</h3>
                        <hr>
                        <div class="p-4 info">
                            {!! Form::open(['url' =>'admin/account/edit/password'])!!}
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="name">Contraseña Actual:</label>
                                    {!!Form::password('apassword', ['class' => 'form-control'])!!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="name">Nueva Contraseña:</label>
                                    {!!Form::password('password', ['class' => 'form-control'])!!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="name">Confirmar Contraseña:</label>
                                    {!!Form::password('cpassword',['class' => 'form-control'])!!}
                                </div>
                            </div>
                            {!! Form::submit('Guardar',['class' => 'btn btn-success'])!!}
                            {!! Form::close() !!}
                        </div>
                      </div>
                    </div>
                </div>
              </div>
        </div>
    </div>
</div>
@stop