@extends('admin.master')
@section('title', 'Vehiculos')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{url('/admin')}}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Vehiculos</li>
                </ol>
              </nav>
            @if(kvfj(Auth::user()->permissions,'add_vehiculos'))
            <p class="d-inline-flex gap-1">
                <button class="btn btn-info text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Registrar Vehiculo
                </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body ">
                    {!! Form::open(['url' => '/admin/vehiculos'])!!}
                    <div class="row">
                        <div class="col-md-4 form-group">
                          <label for="fname"><strong>MARCA</strong></label>
                          <input type="text" class="form-control" placeholder="Ejem:Toyota" name="marca">
                        </div>
                        <div class="col-md-4 form-group">
                          <label for="lname"><strong>MODELOS</strong></label>
                          <input type="text" class="form-control" placeholder="Ejem:Yaris" name="modelo">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="lname"><strong>N PLACA</strong></label>
                            <input type="text" class="form-control" placeholder="Ejem:F5U-597" name="n_placa">
                          </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 form-group">
                          <label for="fname"><strong>COLOR</strong></label>
                          <input type="text" class="form-control" placeholder="Ejem:Negro" name="color">
                        </div>
                        <div class="col-md-6 form-group">
                          <label for="lname"><strong>CARGA UTIL/Ejemplo:1000(En Kilos)</strong></label>
                          <input  type="number" step="any"  class="form-control" placeholder="Ejem:1000" name="carga">
                        </div>
                    </div> 
                    <br>
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
                                    <th scope="col">MARCA</th>
                                    <th scope="col">MODELO</th>
                                    <th scope="col">N PLACA</th>
                                    <th scope="col">CARGA UTIL</th>
                                    <th scope="col">EDITAR</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vehiculos as $vehiculo)   
                                <tr>
                                    <th>{{$vehiculo->marca}}</th>
                                    <td>{{$vehiculo->modelo}}</td>
                                    <td>{{$vehiculo->n_placa}}</td>
                                    <td>{{number_format($vehiculo->carga,3)}} kg</td>
                                    <th>
                                        @if(kvfj(Auth::user()->permissions,'edit_vehiculos'))
                                            <a class="btn btn-info" href="{{ url('/admin/vehiculos/'.$vehiculo->id.'/edit') }}">
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
@section('vehiculojs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
      var tipoSelect = $("#tipo");
      var cantidadAsientosInput = $("#cantidad_asientos");
  
      // Ocultar inicialmente el campo de cantidad de asientos
      cantidadAsientosInput.hide();
  
      // Agregar o eliminar el atributo 'required' según la opción seleccionada
      tipoSelect.change(function() {
        if (tipoSelect.val() === "1") {
          cantidadAsientosInput.show();
          cantidadAsientosInput.attr("required", true);
        } else {
          cantidadAsientosInput.hide();
          cantidadAsientosInput.removeAttr("required");
        }
      });
    });
</script>
@endsection