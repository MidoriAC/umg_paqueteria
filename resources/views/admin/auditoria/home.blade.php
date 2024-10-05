@extends('admin.master')
@section('title', 'Auditoria')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{url('/admin')}}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Auditoria</li>
                </ol>
            </nav>
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
                            <h4 class="card-title">Lista</h4>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Usuario</td>
                                        <td>Fecha</td>
                                        <td>Tabla</td>
                                        <td>Acci&oacute;n</td>
                                        <td >Nombre</td>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @foreach($auditoria as $audi)
                                    <tr>
                                        <td>{{ $audi->user_auditoria->name}} {{ $audi->user_auditoria->lastname}}</td>
                                        <td>{{ $audi->created_at}}</td>
                                        @foreach ($audi->homework as $documen)
                                            <td>{{$documen['table']}}</td>
                                            <td>{{$documen['accion']}}</td>
                                            <td>{{$documen['name']}}</td>
                                        @endforeach
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