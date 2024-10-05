@extends('admin.master')
@section('title', 'Recepcion')
@section('recepcioncss')
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
                  <li class="breadcrumb-item active" aria-current="page">Recepción</li>
                </ol>
            </nav>
        </div>
    </div> 
</div>
<div class="container-fluid">
    <div class="col-12">
        <hr>
        <div class="table-responsive">
            <table class="table" id="recepcion">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Emisor</th>
                    <th>Receptor</th>
                    <th>Emisor sucursal</th>
                    <th>Receptor sucursal</th>
                    <th>Peso</th>
                    <th>Contraseña</th>
                    <th>Vehiculo</th>
                    <th>Estado</th>
                    <th>PDF</th>
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
                        <td>{{ $envio->vehi->n_placa }}</td>
                        <td>
                            @if(kvfj(Auth::user()->permissions,'recepcion_estado'))
                                @if($envio->estado == 2)
                                <a href="{{ url('/admin/recepcion/'.$envio->id.'/entregado')}}" class="btn btn-success btn-sm">
                                    Ya Llego 
                                </a> 
                                @elseif($envio->estado == 3)
                                <a href="{{ url('/admin/recepcion/'.$envio->id.'/entregado')}}" class="btn btn-primary btn-sm">
                                    Entregado
                                </a> 
                                @endif
                            @else
                                @if($envio->estado == 2)
                                <a href="" class="btn btn-success btn-sm">
                                    Ya Llego 
                                </a> 
                                @elseif($envio->estado == 3)
                                <a href="" class="btn btn-primary btn-sm">
                                    Entregado
                                </a> 
                                @endif
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('admin/envio/' . $envio->id . '/pdf') }}" target="_blank" class="btn btn-primary btn-sm"> PDF</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>                       
    </div>
</div>
@stop
@section('recepcionjs')
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
      var table = $('#recepcion').DataTable({
        processing: true,
        serverSider: true,
        ordering: true,
        "order": [[ 8, "desc" ]],
        "pageLength": 50,
        "lengthMenu": [[5,10,50,-1], [5,10,50,"All"]],
        "language":{
          "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
      });
    });
  </script>
@endsection