@extends('admin.master')
@section('title', 'Panel Administrativo')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{url('/admin')}}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </nav>
            <h1 class="mb-0 fw-bold">Dashboard</h1> 
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <!-- column -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        @if(kvfj(Auth::user()->permissions,'reclamos'))
                        <h1>Reclamos que esten pendientes {{Auth::user()->name}}</h1>
                        @else
                        <h1>Hola {{Auth::user()->name}}</h1>
                        @endif
                    </div>  
                </div>
            </div>
            @if(kvfj(Auth::user()->permissions,'reclamos'))
                @foreach ($reclamos as $reclamo)
                <div class="card text-center">
                    <div class="card-header">
                        Codigo: {{$reclamo->envio->codigo}} - Emisor: {{$reclamo->envio->name_emisor}} - Receptor: {{$reclamo->envio->name_receptor}}
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">{{$reclamo->name}}</h5>
                    <button type="button" class="btn btn-warning btn-sm" >
                        Pendiente
                    </button>
                    <p class="card-text">{!! htmlspecialchars_decode( $reclamo->texto )!!}</p>
                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#imagen-{{$reclamo->id}}">
                            Ver Imagen
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="imagen-{{$reclamo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Imagen</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img alt="" width="450" class="img-fluid" src="{{ asset('uploads/'.$reclamo->file_path.'/'.$reclamo->archivo) }}"/>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        {{ $reclamo->created_at->diffForHumans() }}
                    </div>
                </div> 
                @endforeach
            @endif
        </div>
    </div>
</div>
@stop