@extends('admin.master')
@section('title', 'Ventas')
@section('ventascss')
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
                  <li class="breadcrumb-item active" aria-current="page">Ventas</li>
                </ol>
            </nav>
        </div>
    </div> 
</div>
<div class="container-fluid">
    <div class="col-12">
        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gráfico de Ventas por Mes</h5>
                        <canvas id="graficoVentas" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gráfico de Ventas por Personal</h5>
                        <canvas id="graficoPersonal" width="800" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gráfico de Ventas por Vehículo</h5>
                        <canvas id="graficoVehiculo" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table" id="ventas">
                <thead>
                    <tr>
                        <th>Código Envio</th>
                        <th>Personal</th>
                        <th>Vehiculo</th>
                        <th>Emisor sucursal</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                    <tr>
                        <td>
                            @if($venta->vehiculo_id != null)
                            {{$venta->env->codigo}}
                            @endif
                        </td>
                        <td>
                            @if($venta->user_id != null)
                            {{$venta->usuario->name}} {{$venta->usuario->lastname}}
                            @endif
                        </td>
                        <td>
                            @if($venta->vehiculo_id != null)
                            {{$venta->vehi->n_placa}}
                            @endif
                        </td>
                        <td>
                            @if($venta->sucursal_emisor_id != null)
                            {{$venta->suc->sucursal}}
                            @endif
                        </td>
                        <td>{{number_format($venta->precio,2)}}</td>
                        <td>{{$venta->fecha}}</td>
                    </tr>
                    
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th style="background: #fff;text-align: center;border: none;" colspan="3"></th>
                        <td style="color: #000000;text-align: center">TOTAL</td>
                        <td><h4 id="monto"></h4></td>
                    </tr>
                </tfoot>
            </table>
        </div>                       
    </div>
</div>
@stop
@section('ventasjs')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.3/api/sum().js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
 $(document).ready(function() {
    $('.selectEnvios').select2({
        width: '100%'
     });
});
</script>
<script> 
    $(document).ready(function(){
        var table = $('#ventas').DataTable({
            processing: true,
            serverSider: true,
            ordering: true,
            "order": [[ 5, "desc" ]],
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: 'Exportar a Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Exportar a PDF',
                    orientation: 'landscape', 
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    }
                },
            ],
            "pageLength": 50,
            "lengthMenu": [[5,10,50,-1], [5,10,50,"All"]],
            "language":{
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            }
        });
    
        let monto = 0.0;
        table.column(4).data().each( value => {
            const amount = parseFloat(value.replace(/[^0-9.-]+/g,""));
            monto += amount;
        });
    
        $("#monto").text(monto.toLocaleString('en-US', {maximumFractionDigits: 2})); // asignar el total al elemento #monto
    });
</script>
<script>
    $(document).ready(function(){
        var preciosPorMes = {};
        $('#ventas tbody tr').each(function(){
            var fechaCompleta = $(this).find('td:eq(5)').text(); 
            var fecha = new Date(fechaCompleta);
            var mes = fecha.toLocaleString('default', { month: 'long' }); 
            var precio = parseFloat($(this).find('td:eq(4)').text().replace(',', '')); 
            if (preciosPorMes[mes] === undefined) {
                preciosPorMes[mes] = 0;
            }
            preciosPorMes[mes] += precio; 
        });
        var meses = Object.keys(preciosPorMes);
        var precios = meses.map(function(mes) {
            return preciosPorMes[mes];
        });
        var ctx = document.getElementById('graficoVentas').getContext('2d');
        var graficoVentas = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Ventas',
                    data: precios,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)', 
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function(){
        var ventasPorPersonal = {};
        $('#ventas tbody tr').each(function(){
            var personal = $(this).find('td:eq(1)').text();
            var precio = parseFloat($(this).find('td:eq(4)').text().replace(',', '')); 
            if (ventasPorPersonal[personal] === undefined) {
                ventasPorPersonal[personal] = 0;
            }
            ventasPorPersonal[personal] += precio; 
        });

        var personal = Object.keys(ventasPorPersonal);
        var ventas = personal.map(function(persona) {
            return ventasPorPersonal[persona];
        });

        var ctx = document.getElementById('graficoPersonal').getContext('2d');
        var graficoPersonal = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: personal,
                datasets: [{
                    label: 'Ventas por Personal',
                    data: ventas,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)', 
                    borderColor: 'rgba(255, 99, 132, 1)', 
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function(){
        // Crear un objeto para almacenar las ventas por vehículo
        var ventasPorVehiculo = {};
        $('#ventas tbody tr').each(function(){
            var vehiculo = $(this).find('td:eq(2)').text(); // Suponiendo que el vehículo está en la tercera columna (0-indexed)
            var precio = parseFloat($(this).find('td:eq(4)').text().replace(',', '')); // Suponiendo que el precio está en la quinta columna (0-indexed)
            if (ventasPorVehiculo[vehiculo] === undefined) {
                ventasPorVehiculo[vehiculo] = 0; // Inicializar el precio para este vehículo en 0 si aún no existe
            }
            ventasPorVehiculo[vehiculo] += precio; // Sumar el precio a las ventas existentes para este vehículo
        });

        // Obtener los nombres de los vehículos y las ventas para el gráfico
        var vehiculos = Object.keys(ventasPorVehiculo);
        var ventasVehiculo = vehiculos.map(function(vehiculo) {
            return ventasPorVehiculo[vehiculo];
        });

        // Crear el gráfico
        var ctx = document.getElementById('graficoVehiculo').getContext('2d');
        var graficoVehiculo = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: vehiculos,
                datasets: [{
                    label: 'Ventas por Vehículo',
                    data: ventasVehiculo,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)', // Color de las barras
                    borderColor: 'rgba(75, 192, 192, 1)', // Color del borde de las barras
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>
@endsection