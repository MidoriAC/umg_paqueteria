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
                  <li class="breadcrumb-item"><a href="{{url('/admin/envios')}}" class="link">Envios</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Editar Envios</li>
                </ol>
            </nav>
            @if(kvfj(Auth::user()->permissions,'edit_envios'))
                <div class="card card-body ">
                    {!! Form::open(['url' => 'admin/envio/'.$envio->id.'/edit','files'=>'true']) !!}
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
                                                <select class="selectEnvios" name="departamento_id" id="departamentos" >
                                                <option value="">Todas los departamentos</option>
                                                @foreach($departamentos as $departamento)
                                                    <option value="{{ $departamento->id}}">{{ $departamento->name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>MUNICIPIOS</strong></label>
                                                <select class="selectEnvios" name="municipio_id" id="provincias" >
                                                <option value="">Todos los municipios</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>SUCURSAL</strong></label>
                                                <select class="selectEnvios" name="sucursal_emisor_id" id="sucursal" required>
                                                    @if($envio->sucursal_emisor_id == null) 
                                                        <option value="">Todas las sucursales</option>
                                                    @else
                                                        <option value="{{$envio->sucursal_emisor_id }}">{{$envio->suc_emis->sucursal}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="fname"><strong>NOMBRE Y APELLIDOS </strong></label>
                                                <input type="text" class="form-control" placeholder="Ejem:Jose" value="{{ $envio->name_emisor }}" name="name_emisor" required>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="lname"><strong>dpi</strong></label>
                                                <input type="text" class="form-control" placeholder="Ejem:785247125" value="{{ $envio->dpi_emisor }}" name="dpi_emisor" required>
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
                                                <select class="selectEnvios" name="departamento_id" id="departamentostwo" >
                                                <option value="">Todas los departamentos</option>
                                                @foreach($departamentos as $departamento)
                                                    <option value="{{ $departamento->id}}">{{ $departamento->name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>MUNICIPIOS</strong></label>
                                                <select class="selectEnvios" name="municipio_id" id="provinciastwo" >
                                                <option value="">Todos los municipios</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>SUCURSAL</strong></label>
                                                <select class="selectEnvios" name="sucursal_receptor_id" id="sucursaltwo" required>
                                                    @if($envio->sucursal_receptor_id == null) 
                                                    <option value="">Todas las sucursales</option>
                                                    @else
                                                    <option value="{{$envio->sucursal_receptor_id }}">{{$envio->suc_recep->sucursal}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="fname"><strong>NOMBRE Y APELLIDOS </strong></label>
                                                <input type="text" class="form-control" placeholder="Ejem:Sebastian" value="{{ $envio->name_receptor }}" name="name_receptor" required>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="lname"><strong>dpi</strong></label>
                                                <input type="text" class="form-control" placeholder="Ejem:10662548" value="{{ $envio->dpi_receptor }}" name="dpi_receptor" required>
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
                                                <input type="number" step="any" class="form-control" value="{{ $envio->peso }}" placeholder="Ejem:10" name="peso" required>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>PRECIO</strong></label>
                                                <input type="number" step="any" class="form-control" value="{{ $envio->precio }}" placeholder="Ejem:50" name="precio" required>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>Vehiculos</strong></label>
                                                <select class="selectEnvios" name="vehiculo_id" id="vehiculos" required>
                                                    <option value="{{$envio->vehiculo_id }}">{{$envio->vehi->marca}} / {{ $envio->vehi->modelo}} / {{ $envio->vehi->n_placa}}</option>
                                                    @foreach($vehiculos as $vehiculo) 
                                                        <option value="{{ $vehiculo->id}}">{{ $vehiculo->marca}} / {{ $vehiculo->modelo}} / {{ $vehiculo->n_placa}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="fname"><strong>Fecha salida</strong></label>
                                                <input type="date" class="form-control" placeholder="Ejem:10" value="{{ $envio->fecha_salida }}" name="fecha_salida" required>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>Contraseña</strong></label>
                                                <input type="number" class="form-control" placeholder="Ejemplo:123456" value="{{ $envio->contraseña }}"  name="contraseña" required >
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="lname"><strong>Fragil</strong></label><br>
                                                <input type="checkbox" name="fragil" {{ $envio->fragil == 1 ? "checked='checked'" : ''}} class="form-check-input"> 
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
            @endif
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