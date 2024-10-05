@extends('admin.master')
@section('title', 'Usuarios')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{url('/admin')}}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                </ol>
              </nav>
            @if(kvfj(Auth::user()->permissions,'user_new'))
            <p class="d-inline-flex gap-1">
                <button class="btn btn-info text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Registrar Usuario
                </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body ">
                    {!! Form::open(['url' => '/admin/user'])!!}
                    <div class="row">
                        <div class="col-md-4 form-group">
                          <label for="fname"><strong>NOMBRE</strong></label>
                          <input type="text" class="form-control" placeholder="Ejem:Jose" name="name">
                        </div>
                        <div class="col-md-4 form-group">
                          <label for="lname"><strong>APELLIDOS</strong></label>
                          <input type="text" class="form-control" placeholder="Ejem:Diaz" name="lastname">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="lname"><strong>EMAIL</strong></label>
                            <input type="text" class="form-control" placeholder="Ejem:jldm605@gmail.com" name="email">
                          </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4 form-group">
                          <label for="fname"><strong>NUMERO</strong></label>
                          <input type="number" class="form-control" placeholder="Ejem:999085095" name="number">
                        </div>
                        <div class="col-md-4 form-group">
                          <label for="lname"><strong>CONTRASEÑA</strong></label>
                          <input  type="password" step="any"  class="form-control" placeholder="********" name="password">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="lname"><strong>CONFIRMAR CONTRASEÑA</strong></label>
                            <input  type="password" step="any"  class="form-control" placeholder="********" name="cpassword">
                          </div>
                    </div> 
                    <div class="d-grid gap-2">
                        {!! Form::submit('Guardar',['class' => 'btn btn-success'])!!}
                    </div>
                {!! Form::close() !!}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <!-- column -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- title -->
                    <div class="">
                        <div>
                            <h4 class="card-title">Lista</h4>
                        </div>
                        <div class="table-responsive">
                            <table id="usuarios" class="table">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Apellidos</td>
                                        <td>Email</td>
                                        <td>Estado de usuario </td>
                                        <td>Rol</td>
                                        <td>Detalles</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name}}</td>
                                        <td>{{ $user->lastname}}</td>
                                        <td>{{ $user->email}}</td>
                                        <td>{{getUserStatusArray(null,$user->status)}}</td>
                                        <td>{{getRoleUserArray(null,$user->role)}}</td>
                                        <td>
                                            <div class="opts">
                                            <a href="{{url('/admin/user/'.$user->id.'/edit')}}" class="btn btn-outline-info">
                                                <i class="fas fa-user-edit"></i>
                                            </a>
                                            <a href="{{url('/admin/user/'.$user->id.'/permission')}}" class="btn btn-outline-info">
                                                <i class="fas fa-user-lock"></i>
                                              </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop