@extends('connect.master')
@section('title', 'Login')
@section('content')
<section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="{{ asset('../assets/css/images/login.png') }}" class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          {!! Form::open(['url' => '/login','class' => 'col-12 col-md-8 offset-md-2']) !!}
            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                <h1 class="me-3">Iniciar Sesión</h1>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                <h4 class="me-3">Panel Administrativo</h4>
            </div>
            <div class="form-group">
                {!! Form::email('email',null,['class' => 'input_login form-control form-control-lg' , 'placeholder' => 'Correo electrónico'])!!}
            </div>
            <div class="form-group">
                {!! Form::password('password',['class' => 'input_login form-control form-control-lg','placeholder' => 'Contraseña']); !!}
            </div>
            <div class="form-group text-center pt-4">
              {!! Form::submit('Ingresar',['class' => 'btn btn-primary btn-floating mx-1'])!!}<br>
            </div>
           
            <!-- <div class="text-center">
              <span><a href="{{url('/register')}}" style="color:rgb(73, 70, 255)"> registrarme</a></p></span>
            </div> -->
          {!! Form::close() !!}
        </div>
        <div class="red">
            <div>
                @if (Session::has('message'))
                <div class="container">
                    <div class="alert alert-{{ Session::get('typealert') }}" style="display:none;text-align: left;">
                    {{ Session::get('message') }}
                    @if ($errors->any())
                      <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    @endif
                    <script>
                      $('.alert').slideDown();
                      setTimeout(function(){ $('.alert').slideUp(); }, 30000)
                    </script>
                  </div>
               </div>
              @endif
            </div>
        </div>
      </div>
    </div>
    <div
      class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5">
      <!-- Copyright -->
      <div class="text-black mb-3 mb-md-0">
        Copyright © 2024. All rights reserved.
      </div>
      <!-- Copyright -->
  
    </div>
  </section>
@stop