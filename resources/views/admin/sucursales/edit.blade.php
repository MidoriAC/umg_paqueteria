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
                  <li class="breadcrumb-item"><a href="{{url('/admin/sucursales')}}" class="link">Sucursales</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Editar Sucursales</li>
                </ol>
            </nav>
            @if(kvfj(Auth::user()->permissions,'edit_sucursales'))
            <div class="card card-body ">
                    {!! Form::open(['url' => 'admin/sucursales/'.$sucursal->id.'/edit','files'=>'true']) !!}
                        <div class="row">
                            <div class="col-md-4 form-group">
                              <label for="fname"><strong>DEPARTAMENTO</strong></label>
                              <select class="selectSucursales" name="departamento_id" id="departamentos" required>
                                <option value="{{$sucursal->departamento_id }}">{{$sucursal->depart->name}}</option>
                                @foreach($departamentos as $departamento)
                                  <option value="{{ $departamento->id}}">{{ $departamento->name}}</option>
                                @endforeach
                              </select> 
                            </div>
                            <div class="col-md-4 form-group">
                              <label for="lname"><strong>MUNICIPIOS</strong></label>
                                <select class="selectSucursales" name="municipio_id" id="provincias" required>
                                    @if($sucursal->municipio_id == null) 
                                        <option value="">Todos los municipios</option>
                                    @else
                                        <option value="{{$sucursal->municipio_id }}">{{$sucursal->provin->name}}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="lname"><strong>SUCURSAL</strong></label>
                                <input type="text" class="form-control" value="{{$sucursal->sucursal}}" placeholder="Ejem:Chorrillos-Av.El Inti 102" name="sucursal" required>
                            </div>
                        </div>
                        <br> 
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="lname"><strong>TELEFONO</strong></label>
                                <input type="number" class="form-control" placeholder="999085085" name="telefono" value="{{$sucursal->telefono}}" required>
                            </div>
                            <div class="col-md-4 form-group">
                              <label for="fname"><strong>HORA DE APERTURA</strong></label>
                              <input type="time" class="form-control" id="hora" name="hora_apertura" value="{{$sucursal->hora_apertura}}" required>
                            </div>
                            <div class="col-md-4 form-group">
                              <label for="lname"><strong>HORA DE CIERRE</strong></label>
                              <input type="time" class="form-control" id="hora" name="hora_cierre"  value="{{$sucursal->hora_cierre}}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                @if($sucursal->imagen_tienda != 'sin_pdf.pdf') 
                                    <label for="fname">IMAGEN DE SUCURSAL <strong class="text-danger">(LA SUCURSAL YA POSEE UNA IMAGEN )</strong></label>
                                @else
                                    <label for="fname"><strong>IMAGEN DE SUCURSAL</strong></label>
                                @endif
                                <input class="form-control form-control-lg" id="formFileLg" type="file" name="imagen_tienda">
                            </div>
                        </div> 
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
