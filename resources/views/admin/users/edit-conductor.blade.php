@extends('admin.master')
@section('title', 'Editar Conductor')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h3 class="pt-3"><i class="fas fa-user ml-3"></i> Información del Conductor</h3>
                        <hr>
                        <div class="mini_profile">
                            <div class="text-center">
                                <img src="{{ Storage::url($conductor->foto_dpi) }}" class="avatar" width="200px" alt="">
                            </div>
                            <div class="info p-4">
                                <h6 class="title"><strong><i class="fas fa-user"></i> Nombres y Apellidos:</strong></h6>
                                <h6 class="text ml-4">{{ $conductor->nombre }}, {{ $conductor->apellido }}</h6>
                                <h6 class="title"><strong><i class="fas fa-at"></i> Teléfono:</strong></h6>
                                <h6 class="text ml-4">{{ $conductor->telefono }}</h6>
                                <h6 class="title"><strong><i class="fas fa-user-tag"></i> Licencia:</strong></h6>
                                <h6 class="text ml-4">{{ $conductor->licencia }}</h6>
                                <h6 class="title"><strong><i class="fas fa-user-clock"></i> Estado del Conductor:</strong></h6>
                                <h6 class="text ml-4">{{ $conductor->estado == 1 ? 'Activo' : 'Suspendido' }}</h6>
                            </div>
                            <div class="text-center p-3">
                                @if($conductor->estado == 1)
                                    <a href="{{ url('/admin/conductor/'.$conductor->id.'/suspend') }}" class="btn btn-danger btn-lg">
                                        <i class="fas fa-user-times"></i> Suspender Conductor
                                    </a>
                                @else
                                    <a href="{{ url('/admin/conductor/'.$conductor->id.'/activate') }}" class="btn btn-success btn-lg">
                                        <i class="fas fa-user-check"></i> Activar Conductor
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h3 class="pt-3"><i class="fas fa-user-edit ml-3"></i> Panel Edición</h3>
                        <hr>
                        <div class="p-4 mini_profile">
                            {!! Form::open(['url' => '/admin/conductor/'.$conductor->id.'/edit', 'enctype' => 'multipart/form-data']) !!}
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                {!! Form::text('nombre', $conductor->nombre, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                {!! Form::text('apellido', $conductor->apellido, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                {!! Form::text('telefono', $conductor->telefono, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group">
                                <label for="licencia">Número de Licencia:</label>
                                {!! Form::text('licencia', $conductor->licencia, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group">
                                <label for="foto_licencia">Foto Licencia:</label>
                                {!! Form::file('foto_licencia', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label for="dpi">Número de DPI:</label>
                                {!! Form::text('dpi', $conductor->dpi, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group">
                                <label for="foto_dpi">Foto DPI:</label>
                                {!! Form::file('foto_dpi', ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-12">
                                {!! Form::submit('Guardar Cambios', ['class' => 'btn btn-success']) !!}
                            </div>
                            {!! Form::close() !!}
 </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop