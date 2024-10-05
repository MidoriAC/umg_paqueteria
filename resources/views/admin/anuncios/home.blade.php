@extends('admin.master')
@section('title', 'Anuncios')
@section('anuncioscss')
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
                  <li class="breadcrumb-item active" aria-current="page">Anuncios</li>
                </ol>
            </nav>
            @if(kvfj(Auth::user()->permissions,'add_anuncios'))
            <p class="d-inline-flex gap-1">
                <button class="btn btn-info text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Registrar Anuncio
                </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body ">
                    {!! Form::open(['url' => 'admin/anuncios','files'=>'true']) !!}
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
                                    <option value="">Todas las sucursales</option>
                                </select>
                            </div>
                        </div>
                        <br> 
                        <div class="row">
                            <div class="col-md-6 form-group">
                              <label for="fname"><strong>TITULO</strong></label>
                              <input type="text" class="form-control" id="titulo" name="titulo" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="fname"><strong>IMAGEN DE SUCURSAL</strong></label>
                                <input class="form-control form-control-lg" id="formFileLg" type="file" name="imagen_anuncio">
                            </div>
                        </div>
                        <textarea name="texto" id="anuncio_text" required></textarea>
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
                                    <th scope="col">SUCURSAL</th>
                                    <th scope="col">TITULO</th>
                                    <th scope="col">IMAGEN</th>
                                    <th scope="col">VISIBLE</th>
                                    <th scope="col">EDITAR</th>
                                </tr>
                                </thead>
                                <tbody> 
                                    @foreach($anuncios as $anuncio)   
                                    <tr>
                                        <td>{{$anuncio->suc->depart->name}} / {{$anuncio->suc->provin->name}} / {{$anuncio->suc->sucursal}}</td>
                                        <td>{{$anuncio->titulo}}</td>
                                        <td>
                                            @if($anuncio->imagen_anuncio == 'sin_pdf.pdf')
                                            <a  disabled class="text-danger"><i class="fas mr-2 fa-file-pdf"></i>Sin Imagen</a>
                                            @else
                                            <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verimagen-{{$anuncio->id}}">
                                                        <i class="fas fa-image"></i> 
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="verimagen-{{$anuncio->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Imagen</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img alt="" width="450" class="img-fluid" src="{{ asset('uploads/'.$anuncio->file_path.'/'.$anuncio->imagen_anuncio) }}"/>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                               
                                            @endif 
                                        </td>
                                        <td>
                                            @if($anuncio->estado == 0)
                                                <a href="{{ url('/admin/anuncios/'.$anuncio->id.'/estado')}}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @else
                                                <a href="{{ url('/admin/anuncios/'.$anuncio->id.'/estado')}}" class="btn btn-success btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <th> 
                                            @if(kvfj(Auth::user()->permissions,'edit_anuncios'))
                                                <a class="btn btn-info" href="{{ url('/admin/anuncios/'.$anuncio->id.'/edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if(kvfj(Auth::user()->permissions,'delete_anuncios'))
                                            <a href="{{ url('/admin/anuncios/'.$anuncio->id.'/delete') }}" class="btn btn-danger delete-detail" title="Eliminar Anuncio">
                                                <i class="fas fa-trash-alt fa-sx"></i>
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
@section('anunciosjs')
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
<script>
    // Agregar un event listener al elemento con la clase delete-detail
    document.querySelectorAll('.delete-detail').forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace

            // Mostrar el cuadro de diálogo SweetAlert
            Swal.fire({
                title: '¿Estás seguro de eliminar este detalle?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma la eliminación, redirigir a la URL del enlace
                    window.location.href = item.getAttribute('href');
                }
            });
        });
    });
</script>
@endsection