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

            <!-- Acá colocar el nuevo if para validación de creación del conductor -->
            <p class="d-inline-flex gap-1">
    <button class="btn btn-info text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExampleConductor" aria-expanded="false" aria-controls="collapseExampleConductor">
        Registrar Conductor
    </button>
</p>
<div class="collapse" id="collapseExampleConductor">
    <div class="card card-body ">
    {!! Form::open(['url' => '/admin/conductor', 'enctype' => 'multipart/form-data']) !!}
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="fname"><strong>NOMBRE</strong></label>
                <input type="text" class="form-control" placeholder="Ejem:Jose" name="nombre" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="lname"><strong>APELLIDO</strong></label>
                <input type="text" class="form-control" placeholder="Ejem:Diaz" name="apellido" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="telefono"><strong>NÚMERO DE TELÉFONO</strong></label>
                <input type="text" class="form-control" placeholder="Ejem:999085095" name="telefono" required>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="dpi"><strong>NÚMERO DE DPI</strong></label>
                <input type="text" class="form-control" placeholder="Ejem:3240587541401" name="dpi" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="foto_dpi"><strong>FOTO DPI</strong></label>
                <input type="file" class="form-control" name="foto_dpi" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="licencia"><strong>NÚMERO DE LICENCIA</strong></label>
                <input type="text" class="form-control" placeholder="Ejem:3240587541401" name="licencia" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="foto_licencia"><strong>FOTO LICENCIA</strong></label>
                <input type="file" class="form-control" name="foto_licencia" required>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="id_usuario_app"><strong>USUARIO ASIGNADO EN APP</strong></label>
                <select class="form-control" name="id_usuario_app" required>
                    <option value="">Seleccione un usuario</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }} {{ $usuario->lastname }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="d-grid gap-2">
            {!! Form::submit('Guardar',['class' => 'btn btn-success']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>



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
                            <h4 class="card-title">Lista de conductores</h4>
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

<div class="container-fluid">
    <div class="row">
        <!-- column -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <div>
                            <h4 class="card-title">Lista de conductores</h4>
                        </div>
                        <div class="table-responsive">
                            <table id="conductores" class="table">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Apellido</td>
                                        <td>Número de Teléfono</td>
                                        <td>Número de Licencia</td>
                                        <td>Número de DPI</td>
                                        <td>Estado del Conductor</td>
                                        <td>Detalles</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($conductores as $conductor)
                                    <tr>
                                        <td>{{ $conductor->nombre }}</td>
                                        <td>{{ $conductor->apellido }}</td>
                                        <td>{{ $conductor->telefono }}</td>
                                        <td>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#licenciaModal{{ $conductor->id }}">
                                                {{ $conductor->licencia }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#dpiModal{{ $conductor->id }}">
                                                {{ $conductor->dpi }}
                                            </a>
                                        </td>
                                        @if($conductor->estado == 1)
                                            <td>Activo</td>
                                        @else
                                            <td>Suspendido</td>
                                        @endif
                                        <td>
                                            <div class="opts">
                                                <a href="{{url('/admin/conductor/'.$conductor->id.'/edit')}}" class="btn btn-outline-info">
                                                    <i class="fas fa-user-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal para Licencia -->
                                    <div class="modal fade" id="licenciaModal{{ $conductor->id }}" tabindex="-1" aria-labelledby="licenciaModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="licenciaModalLabel">Imagen de Licencia</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ Storage::url($conductor->foto_licencia) }}" class="img-fluid" alt="Licencia">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal para DPI -->
                                    <div class="modal fade" id="dpiModal{{ $conductor->id }}" tabindex="-1" aria-labelledby="dpiModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="dpiModalLabel">Imagen de DPI</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ Storage::url($conductor->foto_dpi) }}" class="img-fluid" alt="DPI">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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