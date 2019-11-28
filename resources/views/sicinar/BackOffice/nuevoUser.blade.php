@extends('sicinar.principal')

@section('title','Usuarios')

@section('nombre')
    {{$nombre}}
@endsection

@section('usuario')
    {{$usuario}}
@endsection

@section('content')
    <div class="content-wrapper" id="principal">
        <section class="content-header">
            <h1><i class="fa fa-users"></i>Usuarios del sistema </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Menú</a></li>
                <li><a href="{{route('verUser')}}">Usuarios</a></li>
                <li class="active">Nuevo</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Nuevo usuario</b></h3>
                                <a href="{{route('verUser')}}" class="btn btn-primary pull-right" title="Ver usuarios"><i class="fa fa-users">Ver usuarios</i></a>
                        </div>
                        {!! Form::open(['route' => 'altaUser', 'method' => 'POST', 'id' => 'altaUser']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                     <label >Login </label>
                                    <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Login del usuario (ejemplo ejemplo@hotmail.com)" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                     <label >Password </label>
                                    <input type="text" class="form-control" name="user_password" id="user_password" placeholder="Contraseña" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                     <label >Rol </label>
                                    <select class="form-control m-bot15" name="rol_id" id="rol_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar Rol </option>
                                        @foreach($roles as $rol)
                                            <option value="{{$rol->rol_id}}">{{$rol->rol_name.' '.$rol->rol_desc}}</option>
                                        @endforeach
                                    </select>
                                </div>                           
                            </div>

                            @if(count($errors) > 0)
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li><i class="fa fa-warning"></i> {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <br>
                            <div class="col-md-12 offset-md-5">
                                {!! Form::submit('Registrar',['class' => 'btn btn-success btn-block']) !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </section>
    </div>
@endsection

@section('request')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\userRequest','#altaUser') !!}
@endsection

@section('javascrpt')
    <script type="text/javascript">
        var unidad = document.getElementById('unidad');
        function dis(elemento) {
            t = elemento.value;
            if(t == "1"){
                unidad.disabled = false;
            }else{
                unidad.disabled = true;
            }
        }
    </script>
@endsection
