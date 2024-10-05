@extends('admin.master')
@section('title', 'Anuncios')
@section('anunciosEditcss')
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
                  <li class="breadcrumb-item"><a href="{{url('/admin/anuncios')}}" class="link">Anuncios</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Editar Anuncios</li>
                </ol>
            </nav>
            @if(kvfj(Auth::user()->permissions,'add_anuncios'))
                <div class="card card-body ">
                    {!! Form::open(['url' => 'admin/anuncios/'.$anuncio->id.'/edit','files'=>'true']) !!}
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="fname"><strong>DEPARTAMENTO</strong></label>
                                <select class="selectAnuncios" name="departamento_id" id="departamentos">
                                <option value="">Todas los departamentos</option>
                                @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id}}">{{ $departamento->name}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="lname"><strong>MUNICIPIOS</strong></label>
                                <select class="selectAnuncios" name="municipio_id" id="provincias">
                                <option value="">Todos los municipios</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="lname"><strong>SUCURSAL</strong></label>
                                <select class="selectAnuncios" name="sucursal_id" id="sucursal">
                                    @if($anuncio->sucursal_id == null) 
                                    <option value="">Todas las sucursales</option>
                                    @else
                                    <option value="{{$anuncio->sucursal_id }}">{{$anuncio->suc->sucursal}}</option>
                                    @endif
                                    <option value="">Todas las sucursales</option>
                                </select>
                            </div>
                        </div>
                        <br>  
                        <div class="row">
                            <div class="col-md-6 form-group">
                              <label for="fname"><strong>TITULO</strong></label>
                              <input type="text" class="form-control" id="titulo" value="{{$anuncio->titulo}}" name="titulo" required>
                            </div>
                            <div class="col-md-6 form-group">
                                @if($anuncio->imagen_anuncio != 'sin_pdf.pdf') 
                                    <label for="fname">IMAGEN DE ANUNCIO <strong class="text-danger">(EL ANUNCIO YA POSEE UNA IMAGEN )</strong></label>
                                @else
                                    <label for="fname"><strong>IMAGEN DE ANUNCIO</strong></label>
                                @endif
                                <input class="form-control form-control-lg" id="formFileLg" type="file" name="imagen_anuncio">
                            </div>
                        </div>  
                        {!!Form::textarea('texto',$anuncio->texto, ['class' => 'form-control','id' => 'texto'])!!}
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
@section('anunciosEditjs')
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    CKEDITOR.replace('texto');
</script>
<script>
 $(document).ready(function() {
    $('.selectAnuncios').select2({
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