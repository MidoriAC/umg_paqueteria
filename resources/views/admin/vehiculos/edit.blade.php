@extends('admin.master')
@section('title', 'Vehiculos')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{url('/admin')}}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{url('/admin/vehiculos')}}" class="link">Vehiculos</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Editar Vehiculos</li>
                </ol>
              </nav>
            @if(kvfj(Auth::user()->permissions,'add_vehiculos'))
                <div class="card card-body ">
                    {!! Form::open(['url' => '/admin/vehiculos/'.$vehiculo->id.'/edit'])!!}
                    <div class="row">
                        <div class="col-md-4 form-group">
                          <label for="fname"><strong>MARCA</strong></label>
                          <input type="text" class="form-control" value="{{$vehiculo->marca}}" placeholder="Ejem:Toyota" name="marca">
                        </div>
                        <div class="col-md-4 form-group">
                          <label for="lname"><strong>MODELOS</strong></label>
                          <input type="text" class="form-control" value="{{$vehiculo->modelo}}" placeholder="Ejem:Yaris" name="modelo">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="lname"><strong>N PLACA</strong></label>
                            <input type="text" class="form-control" value="{{$vehiculo->n_placa}}" placeholder="Ejem:F5U-597" name="n_placa">
                          </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 form-group">
                          <label for="fname"><strong>COLOR</strong></label>
                          <input type="text" class="form-control" value="{{$vehiculo->color}}" placeholder="Ejem:Negro" name="color">
                        </div>
                        <div class="col-md-6 form-group">
                          <label for="lname"><strong>CARGA UTIL/Ejemplo:1000(En Kilos)</strong></label>
                          <input  type="number" step="any"  class="form-control" value="{{$vehiculo->carga}}" placeholder="Ejem:1000" name="carga">
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
