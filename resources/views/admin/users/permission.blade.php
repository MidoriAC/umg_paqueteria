@extends('admin.master')
@section('title','Persmisos Usuarios')
@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="container-fluid">
                    <form action="{{ url('/admin/user/'.$u->id.'/permission') }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach(user_permissions() as $key => $value)
                            <div class="col-md-4">
                                <div class="card" style="height:35vh">
                                    <div class="card-header" style="background: {!! $value['color'] !!}">
                                      <h6 class="p3">{!! $value['icon'] !!} {!! $value['title'] !!}</h6>
                                    </div>
                                    <div class="card-body overflow-auto">
                                        @foreach($value['keys'] as $k => $v)
                                        <input  name="{{ $k }}" type="checkbox" value="true"  @if(kvfj($u->permissions, $k)) checked @endif>
                                        <label for="flexChekDefault" class="ml-1"><small class="text-dark font-weight-bold">{{$v}}</small></label><br>
                                        @endforeach
                                    </div>
                                  </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="inside">
                                        <input type="submit" value="Guardar" class="btn mb-3 btn-success btn-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>
@endsection