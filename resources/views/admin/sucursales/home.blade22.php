@extends('admin.master')
@section('title', 'Sucursales')
@section('sucursalescss')
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
                  <li class="breadcrumb-item active" aria-current="page">Sucursales</li>
                </ol>
            </nav>
            @if(kvfj(Auth::user()->permissions,'add_sucursales'))
            <p class="d-inline-flex gap-1">
                <button class="btn btn-info text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Registrar Sucursales
                </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body ">
                    {!! Form::open(['url' => 'admin/sucursales','files'=>'true']) !!}
                        <div class="row">
                            <div class="col-md-4 form-group">
                              <label for="fname"><strong>DEPARTAMENTO</strong></label>
                              <select class="selectSucursales" name="departamento_id" id="departamentos" required>
                                <option value="">Todas los departamentos</option>
                                @foreach($departamentos as $departamento)
                                  <option value="{{ $departamento->id}}">{{ $departamento->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-4 form-group">
                              <label for="lname"><strong>MUNICIPIOS</strong></label>
                              <select class="selectSucursales" name="municipio_id" id="provincias" required>
                                <option value="">Todos los municipios</option>
                              </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="lname"><strong>SUCURSAL</strong></label>
                                <input type="text" class="form-control" placeholder="Ejem:Chorrillos-Av.El Inti 102" name="sucursal" required>
                            </div>
                        </div>
                        <br>  
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="lname"><strong>TELEFONO</strong></label>
                                <input type="number" class="form-control" placeholder="999085085" name="telefono" required>
                            </div>
                            <div class="col-md-4 form-group">
                              <label for="fname"><strong>HORA DE APERTURA</strong></label>
                              <input type="time" class="form-control" id="hora" name="hora_apertura" value="08:00" required>
                            </div>
                            <div class="col-md-4 form-group">
                              <label for="lname"><strong>HORA DE CIERRE</strong></label>
                              <input type="time" class="form-control" id="hora" name="hora_cierre"  value="18:00" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                              <label for="fname"><strong>IMAGEN DE SUCURSAL</strong></label>
                              <input class="form-control form-control-lg" id="formFileLg" type="file" name="imagen_tienda">
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
                        <br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">DEPARTAMENTO</th>
                                    <th scope="col">MUNICIPIOS</th>
                                    <th scope="col">SUCURSAL</th>
                                    <th scope="col">TELEFONO</th>
                                    <th scope="col">HORARIO</th>
                                    <th scope="col">IMAGEN</th>
                                    <th scope="col">EDITAR</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($sucursales as $sucursal)   
                                    <tr>
                                        <th>{{$sucursal->depart->name}}</th>
                                        <td>{{$sucursal->provin->name}}</td>
                                        <td>{{$sucursal->sucursal}}</td>
                                        <td>{{$sucursal->telefono}}</td>
                                        <td>{{$sucursal->hora_apertura}}-{{$sucursal->hora_cierre}}</td>
                                        <td>
                                            @if($sucursal->imagen_tienda == 'sin_pdf.pdf')
                                            <a  disabled class="text-danger"><i class="fas mr-2 fa-file-pdf"></i>Sin Imagen</a>
                                            @else
                                            <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verimagen-{{$sucursal->id}}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="verimagen-{{$sucursal->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Imagen de sucursal</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img alt="" width="450" class="img-fluid" src="{{ asset('uploads/'.$sucursal->file_path.'/'.$sucursal->imagen_tienda) }}"/>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                               
                                            @endif 
                                        </td>
                                        <th>
                                            @if(kvfj(Auth::user()->permissions,'edit_sucursales'))
                                                <a class="btn btn-info" href="{{ url('/admin/sucursales/'.$sucursal->id.'/edit') }}">
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
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('sucursalesjs')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
 $(document).ready(function() {
    $('.selectSucursales').select2({
        width: '100%'
     });
});
</script>
<script>
   $(document).ready(function () {
        $('#departamentos').on('change', function () {
            var department_id = this.value;
            $('#provincias').html('');
            $.ajax({
                url: '{{ url('admin/sucursales/filtro_departamento') }}?department_id='+ department_id,
                type: 'get',
                success: function (res) {
                    $('#provincias').html('<option value="">Seleccione el municipio</option>');
                    $.each(res, function (key, value) {
                      $('#provincias').append('<option value="' + value.id + '">'  + value.name + '</option>');
                    });
                }
            }); 
        });
      });
</script>
@endsection