@extends('admin.master')
@section('title', 'Reclamos')
@section('reclamoscss')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
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
                  <li class="breadcrumb-item active" aria-current="page">Reclamos</li>
                </ol>
            </nav>
        </div>
    </div> 
</div>
<div class="container-fluid">
    <div class="col-12">
        <hr>
        <div class="table-responsive">
            <table class="table" id="reclamos">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Emisor</th>
                    <th>Receptor</th>
                    <th>Estado</th>
                    <th>Genero Reclamo</th>
                    <th>Descripcion</th>
                    <th>Archivo</th>
                    <th>Fecha</th>
                    <th>Asignar</th>
                    <th>Atender</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($reclamos as $reclamo)
                    <tr>
                        <td>{{$reclamo->envio->codigo}}</td> 
                        <td>{{$reclamo->envio->name_emisor}}</td>
                        <td>{{$reclamo->envio->name_receptor}}</td>
                        <td>
                            @if($reclamo->estado == 0)
                                <a href="{{ url('/admin/reclamos/'.$reclamo->id.'/estado')}}" class="btn btn-warning btn-sm">
                                    Pendiente
                                </a>
                            @else
                                <a href="{{ url('/admin/reclamos/'.$reclamo->id.'/estado')}}" class="btn btn-success btn-sm">
                                    Cerrado
                                </a>
                            @endif
                        </td>
                        <td>{{$reclamo->name }}</td>
                        <td>{!! htmlspecialchars_decode( $reclamo->texto )!!}</td>
                        <td>
                            <a href="{{ url('uploads/'.$reclamo->file_path.'/'.$reclamo->archivo) }}" target="_blank" class="btn btn-primary btn-sm"> 
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        <td>{{$reclamo->created_at}}</td>
                        <td> 
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#atender-{{$reclamo->id}}">
                                <i class="fas fa-user-plus"></i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="atender-{{$reclamo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Usuarios asignados</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open(['url' => 'admin/reclamos/usuarios/'.$reclamo->id,'files'=>'true']) !!}
                                                <div class="mb-3">
                                                    <label for="exampleInputEmail1" class="form-label">Ususario</label>
                                                    <select class="form-select" name="user_id" id="use">
                                                        <option value="">Todas los ususarios</option>
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->id}}">{{ $user->name}} {{ $user->lastname}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {!! Form::submit('Guardar',['class' => 'btn btn-success'])!!}
                                            {!! Form::close() !!}
                                            <div class="table-responsive">
                                                <table class="table text-center" id="reclamos">
                                                    <thead>
                                                      <tr>
                                                        <th>Usuario</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $user_reclamo_ids = DB::table('user_reclamo')->where('reclamo_id', $reclamo->id)->pluck('user_id'); 
                                                            $usuario_reclamos = DB::table('users')->whereIn('id', $user_reclamo_ids)->get();
                                                        ?>
                                                        @foreach($usuario_reclamos as $usuario_reclamos)
                                                        <tr>
                                                            <td>{{$usuario_reclamos->name}} {{$usuario_reclamos->lastname}}</td> 
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a class="btn btn-success btn-sm" target="_blank" href="https://wa.me/+51{{$reclamo->telefono}}?text=Cordial%20saludo,%20estamos%20atendiendo%20su%20reclamo:{{$reclamo->envio->codigo}}.%20Le%20comunico%20que:">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" target="_blank" href="mailto:{{$reclamo->correo}}">
                                <i class="fas fa-at"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>                       
    </div>
</div>
@stop
@section('reclamosjs')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
 $(document).ready(function() {
    $('.selectEnvios').select2({
        width: '100%'
     });
});
</script>
<script> 
    $(document).ready(function(){
      var table = $('#reclamos').DataTable({
        processing: true,
        serverSider: true,
        ordering: true,
        "order": [[ 5, "desc" ]],
        "pageLength": 50,
        "lengthMenu": [[5,10,50,-1], [5,10,50,"All"]],
        "language":{
          "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
      });
    });
  </script>
@endsection