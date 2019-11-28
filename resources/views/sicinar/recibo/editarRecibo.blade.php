@extends('sicinar.principal')

@section('title','Editar Recibo')

@section('links')
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('nombre')
    {{$nombre}}
@endsection

@section('usuario')
    {{$usuario}}
@endsection

@section('content')
    <meta charset="utf-8">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Menú
                <small>Comprobantes - Recibos - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Editar recibos </h3>
                        </div>
                        {!! Form::open(['route' => ['actualizarRecibo',$regrecibos->recibo_folio], 'method' => 'PUT', 'id' => 'actualizarRecibo', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 offset-md-12">
                                    <label>Folio de transacción: {{$regrecibos->recibo_folio}}</label>
                                </div>  
                            </div>
                            <div class="row">             
                                <div class="col-md-12 offset-md-12">
                                    <label >Codigo:    {{$regrecibos->placa_id}} </label>
                                </div>
                            </div>
                            <div class="row">               
                                <div class="col-md-12 offset-md-12">
                                    <label >Placas: <small>
                                        @foreach($regplaca as $placa)
                                                @if($placa->placa_id == $regrecibos->placa_id)
                                                    {{$placa->placa_placa}}
                                                    @break
                                                @endif
                                        @endforeach </small>
                                    </label>
                                </div>             
                            </div>
                            <div class="row">                                  
                                <div class="col-md-12 offset-md-12">
                                    <label >Resguardatario : <small>
                                        @foreach($regplaca as $placa)
                                                @if($placa->placa_id == $regrecibos->placa_id)
                                                    {{$placa->placa_obs2}}
                                                    @break
                                                @endif
                                        @endforeach </small>
                                    </label>
                                </div>             
                            </div>

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Número de tarjeta </label>
                                    <input type="text" class="form-control" name="tarjeta_no" id="tarjeta_no" placeholder="Número de tarjeta" value="{{$regrecibos->tarjeta_no}}" required>
                                </div>     
                                <div class="col-xs-4 form-group">
                                    <label >Periodo fiscal </label>
                                    <select class="form-control m-bot15" name="periodo_id" id="periodo_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo fiscal</option>
                                        @foreach($regperiodo as $per)
                                            @if($per->periodo_id == $regrecibos->periodo_id)
                                                <option value="{{$per->periodo_id}}" selected>{{$per->periodo_desc}}</option>
                                            @else                                        
                                                <option value="{{$per->periodo_id}}">{{$per->periodo_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                
                                <div class="col-xs-4 form-group">
                                    <label >Mes </label>
                                    <select class="form-control m-bot15" name="mes_id" id="mes_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes </option>
                                        @foreach($regmes as $mes)
                                            @if($mes->mes_id == $regrecibos->mes_id)
                                                <option value="{{$mes->mes_id}}" selected>{{$mes->mes_desc}}</option>
                                            @else                                        
                                               <option value="{{$mes->mes_id}}">{{$mes->mes_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>    
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >KM. inicial </label>
                                    <input type="text" class="form-control" name="recibo_ki" id="recibo_ki"  placeholder="Kilometraje inicial" value="{{$regrecibos->recibo_ki}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Nivel de combustible </label><br>
                                    R  <input type="checkbox" name="recibo_ir" id="recibo_ir" value="1" placeholder="Nivel de combustible R" 
                                    @if(old('recibo_ir',$regrecibos->recibo_ir)=="1") checked @endif required>
                                    1/8<input type="checkbox" name="recibo_i18" id="recibo_i18" value="1" placeholder="Nivel de combustible 1/8" 
                                    @if(old('recibo_i18',$regrecibos->recibo_i18)=="1") checked @endif required>
                                    1/4<input type="checkbox" name="recibo_i14" id="recibo_i14" value="1" placeholder="Nivel de combustible 1/4" 
                                    @if(old('recibo_i14',$regrecibos->recibo_i14)=="1") checked @endif required>
                                    1/2<input type="checkbox" name="recibo_i12" id="recibo_i12" value="1" placeholder="Nivel de combustible 1/2" 
                                    @if(old('recibo_i12',$regrecibos->recibo_i12)=="1") checked @endif required>
                                    3/4<input type="checkbox" name="recibo_i34" id="recibo_i34" value="1" placeholder="Nivel de combustible 3/4" 
                                    @if(old('recibo_i34',$regrecibos->recibo_i34)=="1") checked @endif required>
                                    F  <input type="checkbox" name="recibo_if" id="recibo_if" value="1" placeholder="Nivel de combustible F" 
                                    @if(old('recibo_if',$regrecibos->recibo_if)=="1") checked @endif required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >KM. final </label>
                                    <input type="text" class="form-control" name="recibo_kf" id="recibo_kf"  placeholder="Kilometraje final" value="{{$regrecibos->recibo_kf}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >    </label><br>
                                    R  <input type="checkbox" name="recibo_fr" id="recibo_fr" value="1" placeholder="Nivel de combustible R" 
                                    @if(old('recibo_fr',$regrecibos->recibo_fr)=="1") checked @endif required>
                                    1/8<input type="checkbox" name="recibo_f18" id="recibo_f18" value="1" placeholder="Nivel de combustible 1/8"
                                    @if(old('recibo_f18',$regrecibos->recibo_f18)=="1") checked @endif required>
                                    1/4<input type="checkbox" name="recibo_f14" id="recibo_f14" value="1" placeholder="Nivel de combustible 1/4"
                                    @if(old('recibo_f14',$regrecibos->recibo_f14)=="1") checked @endif required>
                                    1/2<input type="checkbox" name="recibo_f12" id="recibo_f12" value="1" placeholder="Nivel de combustible 1/2"
                                    @if(old('recibo_f12',$regrecibos->recibo_f12)=="1") checked @endif required>
                                    3/4<input type="checkbox" name="recibo_f34" id="recibo_f34" value="1" placeholder="Nivel de combustible 3/4"
                                    @if(old('recibo_f34',$regrecibos->recibo_f34)=="1") checked @endif required>
                                    F  <input type="checkbox" name="recibo_ff" id="recibo_ff" value="1" placeholder="Nivel de combustible F"
                                    @if(old('recibo_ff',$regrecibos->recibo_ff)=="1") checked @endif required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Fecha inicial </label>
                                    <select class="form-control m-bot15" name="periodo_id1" id="periodo_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar año </option>
                                        @foreach($regperiodo as $peri)
                                            @if($peri->periodo_id == $regrecibos->periodo_id1)
                                                <option value="{{$peri->periodo_id}}" selected>{{$peri->periodo_desc}}</option>
                                            @else                                        
                                                <option value="{{$peri->periodo_id}}">{{$peri->periodo_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >    </label>
                                    <select class="form-control m-bot15" name="mes_id1" id="mes_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes </option>
                                        @foreach($regmes as $mesi)
                                            @if($mesi->mes_id == $regrecibos->mes_id1)
                                                <option value="{{$mesi->mes_id}}" selected>{{$mesi->mes_desc}}</option>
                                            @else                                        
                                               <option value="{{$mesi->mes_id}}">{{$mesi->mes_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >    </label>
                                    <select class="form-control m-bot15" name="dia_id1" id="dia_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar día </option>
                                        @foreach($regdia as $diai)
                                            @if($diai->dia_id == $regrecibos->dia_id1)
                                                <option value="{{$diai->dia_id}}" selected>{{$diai->dia_desc}}</option>
                                            @else                                        
                                               <option value="{{$diai->dia_id}}">{{$diai->dia_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Fecha final </label>
                                    <select class="form-control m-bot15" name="periodo_id2" id="periodo_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar año </option>
                                        @foreach($regperiodo as $perf)
                                            @if($perf->periodo_id == $regrecibos->periodo_id2)
                                                <option value="{{$perf->periodo_id}}" selected>{{$perf->periodo_desc}}</option>
                                            @else                                        
                                                <option value="{{$perf->periodo_id}}">{{$perf->periodo_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >    </label>
                                    <select class="form-control m-bot15" name="mes_id2" id="mes_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes </option>
                                        @foreach($regmes as $mesf)
                                            @if($mesf->mes_id == $regrecibos->mes_id2)
                                                <option value="{{$mesf->mes_id}}" selected>{{$mesf->mes_desc}}</option>
                                            @else                                        
                                               <option value="{{$mesf->mes_id}}">{{$mesf->mes_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >    </label>
                                    <select class="form-control m-bot15" name="dia_id2" id="dia_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar día </option>
                                        @foreach($regdia as $diaf)
                                            @if($diaf->dia_id == $regrecibos->dia_id2)
                                                <option value="{{$diaf->dia_id}}" selected>{{$diaf->dia_desc}}</option>
                                            @else                                        
                                               <option value="{{$diaf->dia_id}}">{{$diaf->dia_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Quincena a comprobar </label>
                                    <select class="form-control m-bot15" name="quincena_id" id="quincena_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar quincena </option>
                                        @foreach($regquincena as $quincena)
                                            @if($quincena->quincena_id == $regrecibos->quincena_id)
                                                <option value="{{$quincena->quincena_id}}" selected>{{$quincena->quincena_desc}}</option>
                                            @else                                        
                                               <option value="{{$quincena->quincena_id}}">{{$quincena->quincena_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                
                                <div class="col-xs-4 form-group">                        
                                    <label>Transacción activa o inactiva </label>
                                    <select class="form-control m-bot15" name="recibo_status1" id="recibo_status1" required>
                                        @if($regrecibos->recibo_status1 == 'S')
                                            <option value="S" selected>Activa  </option>
                                            <option value="N">         Inactiva</option>
                                        @else
                                            <option value="S">         Activa  </option>
                                            <option value="N" selected>Inactiva</option>
                                        @endif
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">
                                @if(count($errors) > 0)
                                    <div class="alert alert-danger" role="alert">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Guardar',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verRecibos')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('request')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\reciboRequest','#actualizarRecibo') !!}
@endsection

@section('javascrpt')
<script>
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        startDate: '-29y',
        endDate: '-18y',
        startView: 2,
        maxViewMode: 2,
        clearBtn: true,        
        language: "es",
        autoclose: true
    });
</script>

@endsection