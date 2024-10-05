@extends('admin.master')
@section('title', 'Envios')
@section('enviosjscss')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single,
    .select2-selection .select2-selection--single {
        border: 1px solid #d2d6de;
        border-radius: .25rem !important;
        padding: 6px 12px;
        height: 40px !important
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px;
        position: absolute;
        top: 6px !important;
        right: 1px;
        width: 20px
    }
  </style>
@endsection
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{url('/admin')}}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Envios</li>
                </ol>
            </nav>
            @if(kvfj(Auth::user()->permissions,'add_envios'))
            <p class="d-inline-flex gap-1">
                <button class="btn btn-info text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Registrar Envio
                </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body ">
                    {!! Form::open(['url' => 'admin/envios','files'=>'true']) !!}
                        <div class="row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class="card">
                                    <div class="card-header">
                                        EMISOR
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="fname"><strong>DEPARTAMENTO</strong></label>
                                                <select class="selectEnvios" name="departamento_id" id="departamentos" required>
                                                <option value="{{ $sucursalUsuario->id_depto }}">{{$sucursalUsuario->nombre_depto}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>MUNICIPIOS</strong></label>
                                                <select class="selectEnvios" name="municipio_id" id="provincias" required>
                                                <option value="">Todos los municipios</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>SUCURSAL</strong></label>
                                                <select class="selectEnvios" name="sucursal_emisor_id" id="sucursal" required>
                                                    <option value="">Todas las sucursales</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="fname"><strong>NOMBRE Y APELLIDOS </strong></label>
                                                <input type="text" class="form-control" placeholder="Ejem:Jose" name="name_emisor" required>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="lname"><strong>dpi</strong></label>
                                                <input type="text" class="form-control" placeholder="Ejem:785247125" name="dpi_emisor" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        RECEPTOR
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="fname"><strong>DEPARTAMENTO</strong></label>
                                                <select class="selectEnvios" name="departamento_id" id="departamentostwo" required>
                                                <option value="">Todas los departamentos</option>
                                                @foreach($departamentos as $departamento)
                                                    <option value="{{ $departamento->id}}">{{ $departamento->name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>MUNICIPIOS</strong></label>
                                                <select class="selectEnvios" name="municipio_id" id="provinciastwo" required>
                                                <option value="">Todos los municipios</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>SUCURSAL</strong></label>
                                                <select class="selectEnvios" name="sucursal_receptor_id" id="sucursaltwo" required>
                                                    <option value="">Todas las sucursales</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="fname"><strong>NOMBRE Y APELLIDOS </strong></label>
                                                <input type="text" class="form-control" placeholder="Ejem:Sebastian" name="name_receptor" required>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="lname"><strong>dpi</strong></label>
                                                <input type="text" class="form-control" placeholder="Ejem:10662548" name="dpi_receptor" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <div class="card">
                                    <div class="card-header">
                                        DATOS DE ENVIO
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="fname"><strong>PESO(En Kilogramos)</strong></label>
                                                <input type="number" step="any" class="form-control" placeholder="Ejem:10" name="peso" required>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>PRECIO</strong></label>
                                                <input type="number" step="any" class="form-control" placeholder="Ejem:50" name="precio" required>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>Vehiculos</strong></label>
                                                <select class="selectEnvios" name="vehiculo_id" id="vehiculos" required>
                                                    <option value="">Todos los Vehiculos</option>
                                                    @foreach($vehiculos as $vehiculo)
                                                        <option value="{{ $vehiculo->id}}">{{ $vehiculo->marca}} / {{ $vehiculo->modelo}} / {{ $vehiculo->n_placa}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="fname"><strong>Fecha</strong></label>
                                                <input type="date" class="form-control" placeholder="Ejem:10" name="fecha_salida" required>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>Contraseña</strong></label>
                                                <input type="number" class="form-control" placeholder="Ejemplo:123456" name="contraseña" required >
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>Fragil</strong></label><br>
                                                <input form="tarea" type="checkbox" checked class="form-check-input" name="fragil" id="exampleCheck1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br> 
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
    <div class="col-12">
        <hr>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($vehiculosEnEnvios as $vehiculo)
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-transparent border-info text-center">
                            <h3> {{$vehiculo->marca}} </h3>
                        </div>
                        <div class="card-body">
                            <h3 class="card-text">Placa: {{$vehiculo->n_placa}} </h3>
                            <h3 class="card-text">Model: {{$vehiculo->modelo}} </h3>
                            <h3 class="card-text">Carga: {{number_format($vehiculo->carga,2)}} kg</h3>
                            <?php
                                $carga_disponible = DB::table('envios')->where('vehiculo_id',$vehiculo->id)->whereIn('estado',[0,1])->sum('peso');
                            ?>
                            <h3 class="card-text">Carga Registrada: {{number_format($carga_disponible,2)}} kg</h3>
                            <h3 class="card-text">Carga Disponible: {{number_format($vehiculo->carga - $carga_disponible,2)}} kg</h3>
                            @if ($vehiculo->carga - $carga_disponible == 0)
                            <div class="alert alert-danger" role="alert">
                                El vehiculo ya esta cargado esta listo para salir a su ruta
                            </div>
                            @endif
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#vehiculo-{{$vehiculo->id}}">
                              Ver Detalles
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="vehiculo-{{$vehiculo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Envios Asociados al Vehiculo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                            $envios = DB::table('envios')->whereIn('estado', [0, 1])->where('vehiculo_id',$vehiculo->id)->get();    
                                        ?> 
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                  <tr>
                                                    <th>Código</th>
                                                    <th>Emisor</th>
                                                    <th>Receptor</th>
                                                    <th>Emisor sucursal</th>
                                                    <th>Receptor sucursal</th>
                                                    <th>Peso</th>
                                                    <th>Contraseña</th>
                                                    <th>Estado</th>
                                                    <th>PDF</th>
                                                    <th>Editar</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($envios as $envio)
                                                    <tr>
                                                        <td>{{ $envio->codigo }}</td>
                                                        <td>{{ $envio->name_emisor }}</td>
                                                        <td>{{ $envio->name_receptor }}</td>
                                                        <?php
                                                            $sucursal_emisor =  DB::table('sucursales')->where('id',$envio->sucursal_emisor_id)->value('sucursal');    
                                                            $sucursal_receptor = DB::table('sucursales')->where('id',$envio->sucursal_receptor_id)->value('sucursal');    
                                                        ?>
                                                        <td>{{ $sucursal_emisor }}</td>
                                                        <td>{{ $sucursal_receptor }}</td>
                                                        <td>{{number_format($envio->peso,3)}} kg</td>
                                                        <td>{{ $envio->contraseña }}</td>
                                                        <td>
                                                            @if($envio->estado == 0)
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#envios-{{$vehiculo->id}}">
                                                                En Espera
                                                            </button>
                                                            @elseif($envio->estado == 1)
                                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#envios-{{$vehiculo->id}}">
                                                                En Ruta
                                                            </button>
                                                            @else
                                                            <button type="button" class="btn btn-succes btn-sm" data-bs-toggle="modal" data-bs-target="#envios-{{$vehiculo->id}}">
                                                                Ya Llego 
                                                            </button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('admin/envio/' . $envio->id . '/pdf') }}" target="_blank" class="btn btn-primary btn-sm"> PDF</a>
                                                        </td>
                                                        <th>
                                                            @if(kvfj(Auth::user()->permissions,'edit_envios'))
                                                                <a class="btn btn-info" href="{{ url('/admin/envio/'.$envio->id.'/edit') }}">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                              </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @if(kvfj(Auth::user()->permissions,'add_envios_estado'))
                            <!--ESTADO DE VEHICULO-->
                                @if($vehiculo->estado == 0)
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#envios-{{$vehiculo->id}}">
                                    En Espera
                                </button>
                                @elseif($vehiculo->estado == 1)
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#envios-{{$vehiculo->id}}">
                                    En Ruta
                                </button>
                                @else
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#envios-{{$vehiculo->id}}">
                                    En Espera
                                </button>
                                @endif
                            @else
                                @if($vehiculo->estado == 0)
                                <button type="button" class="btn btn-danger" >
                                    En Espera
                                </button>
                                @elseif($vehiculo->estado == 1)
                                <button type="button" class="btn btn-warning">
                                    En Ruta
                                </button>
                                @else
                                <button type="button" class="btn btn-danger">
                                    En Espera
                                </button>
                                @endif
                            @endif
                            <!-- Modal -->
                            <div class="modal fade" id="envios-{{$vehiculo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open(['url' => 'admin/envio/'.$vehiculo->id.'/estado_auto']) !!}
                                            <div class="row"> 
                                                <div class="form-group">
                                                    <label for="fname"><strong>Estado</strong></label>
                                                    <select class="form-select" name="estado" id="estado" required>
                                                        <option value="0">En Espera</option>
                                                        <option value="1">En Ruta</option>
                                                        <option value="2">Ya Llego</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-grid gap-2">
                                                {!! Form::submit('Guardar',['class' => 'btn btn-success'])!!}
                                            </div> 
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            @endforeach
        </div>
    </div>
</div>
@stop
@section('enviosjs')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
 $(document).ready(function() {
    $('.selectEnvios').select2({
        width: '100%'
     });
});
</script>
<script>
   $(document).ready(function () {
        $('#departamentostwo').on('change', function () {
            var department_id = this.value;
            $('#provinciastwo').html('');
            $.ajax({
                url: '{{ url('admin/envios/filtro_departamento') }}?department_id='+ department_id,
                type: 'get',
                success: function (res) {
                    $('#provinciastwo').html('<option value="">Seleccione el municipio</option>');
                    $.each(res, function (key, value) {
                      $('#provinciastwo').append('<option value="' + value.id + '">'  + value.name + '</option>');
                    });
                }
            }); 
        });
        $('#provinciastwo').on('change', function () {
            var municipio_id = this.value;
            $('#sucursaltwo').html('');
            $.ajax({
                url: '{{ url('admin/envios/filtro_sucursal') }}?municipio_id='+ municipio_id,
                type: 'get',
                success: function (res) {
                    $('#sucursaltwo').html('<option value="">Seleccione la sucursal</option>');
                    $.each(res, function (key, value) {
                      $('#sucursaltwo').append('<option value="' + value.id + '">'  + value.sucursal + '</option>');
                    });
                }
            }); 
        });
      });
</script>
<script>
    $(document).ready(function () {
         $('#departamentos').on('change', function () {
             var department_id = this.value;
             $('#provincias').html('');
             $.ajax({
                 url: '{{ url('admin/envios/filtro_departamento') }}?department_id='+ department_id,
                 type: 'get',
                 success: function (res) {
                     $('#provincias').html('<option value="">Seleccione el municipio</option>');
                     $.each(res, function (key, value) {
                       $('#provincias').append('<option value="' + value.id + '">'  + value.name + '</option>');
                     });
                 }
             }); 
         });
         $('#provincias').on('change', function () {
             var municipio_id = this.value;
             $('#sucursal').html('');
             $.ajax({
                 url: '{{ url('admin/envios/filtro_sucursal') }}?municipio_id='+ municipio_id,
                 type: 'get',
                 success: function (res) {
                     $('#sucursal').html('<option value="">Seleccione la sucursal</option>');
                     $.each(res, function (key, value) {
                       $('#sucursal').append('<option value="' + value.id + '">'  + value.sucursal + '</option>');
                     });
                 }
             }); 
         });
       });
 </script>
@endsection