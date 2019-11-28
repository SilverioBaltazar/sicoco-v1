@extends('sicinar.principal')

@section('title','Ver recibos de bitacora para descarga de combustible')

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
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Comprobaciones
                <small> Seleccionar alguno para editar o registrar nuevo recibo</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">Comprobación         </a></li>
                <li><a href="#">Recibos de bitacora  </a></li>         
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">

                        <div class="page-header" style="text-align:right;">
                                <a href="{{route('nuevoRecibo')}}"   class="btn btn-primary btn_xs" title="Alta de Recibos de bitacora para descarga de combustible"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo recibo
                                </a>
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Per.<br>Fiscal   </th>
                                        <th style="text-align:left;   vertical-align: middle;">Folio            </th>
                                        <th style="text-align:left;   vertical-align: middle;">Código           </th>
                                        <th style="text-align:left;   vertical-align: middle;">Placa            </th>
                                        <th style="text-align:left;   vertical-align: middle;">Resguardatario   </th> 
                                        <th style="text-align:left;   vertical-align: middle;">Mes              </th> 
                                        <th style="text-align:left;   vertical-align: middle;">Quincena         </th>
                                        <th style="text-align:center; vertical-align: middle;">PDF <br>Recibo   </th>
                                        <th style="text-align:center; vertical-align: middle;">PDF <br>Bitacora </th>
                                        <th style="text-align:center; vertical-align: middle;">Activo <br>Inact.</th>
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regrecibos as $recibo)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;"><small>{{$recibo->periodo_id}} </small>
                                        </td>                                        
                                        <td style="text-align:left; vertical-align: middle;"><small>{{$recibo->recibo_folio}} </small>
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;"><small>{{$recibo->placa_id}} </small>
                                        </td>                                        
                                        <td style="text-align:left; vertical-align: middle;"><small>{{$recibo->placa_placa}} </small>
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;"><small>
                                            @foreach($regplaca as $placa)
                                                @if($placa->placa_id == $recibo->placa_id)
                                                    {{$placa->placa_obs2}}
                                                    @break
                                                @endif
                                            @endforeach </small>
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;"><small>
                                            @foreach($regmes as $mes)
                                                @if($mes->mes_id == $recibo->mes_id)
                                                    {{$mes->mes_desc}}
                                                    @break
                                                @endif
                                            @endforeach </small>
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;"><small>
                                            @foreach($regquincena as $quin)
                                                @if($quin->quincena_id == $recibo->quincena_id)
                                                    {{$quin->quincena_desc}}
                                                    @break
                                                @endif
                                            @endforeach </small>
                                        </td>                             
                                        @if(isset($recibo->recibo_rfoto1))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="PDF del recibo de bitacora para descarga de combustible">
                                                <a href="/images/{{$recibo->recibo_rfoto1}}" class="btn btn-danger" title="PDF del recibo de bitacora para descarga de combustible"><i class="fa fa-file-pdf-o"><small></i>PDF</small></a>
                                                <a href="{{route('editarRecibo11',$recibo->recibo_folio)}}" class="btn badge-warning" title="Editar PDF del recibo de bitacora para descarga de combustible"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Sin PDF del recibo de bitacora para descarga de combustible"><i class="fa fa-times">{{$recibo->recibo_rfoto1}} </i>
                                               <a href="{{route('editarRecibo11',$recibo->recibo_folio)}}" class="btn badge-warning" title="Editar PDF del recibo de bitacora para descarga de combustible"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @endif
                                        @if(isset($recibo->recibo_bfoto1))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="PDF de bitacora de rendimiento de combustible">
                                                <a href="/images/{{$recibo->recibo_bfoto1}}" class="btn btn-danger" title="PDF de bitacora de rendimiento de combustible"><i class="fa fa-file-pdf-o"></i><small>PDF</small></a>
                                                <a href="{{route('editarRecibo21',$recibo->recibo_folio)}}" class="btn badge-warning" title="Editar PDF de bitacora de rendimiento de combustible"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Sin PDF de bitacora de rendimiento de combustible"><i class="fa fa-times">{{$recibo->recibo_bfoto1}} </i>
                                                <a href="{{route('editarRecibo21',$recibo->recibo_folio)}}" class="btn badge-warning" title="Editar PDF de bitacora de rendimiento de combustible"><i class="fa fa-edit"></i>
                                                </a>                                                
                                            </td>
                                        @endif                                           

                                        @if($recibo->recibo_status1 == 'S')
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="folio activo"><i class="fa fa-check"></i>
                                            </td>                                            
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Folio inactivo"><i class="fa fa-times"></i>
                                            </td>                                            
                                        @endif
                                        
                                        <td style="text-align:center;">
                                            <a href="{{route('editarRecibo',$recibo->recibo_folio)}}" class="btn badge-warning" title="Editar recibo"><i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{route('borrarRecibo',$recibo->recibo_folio)}}" class="btn badge-danger" title="Borrar Recibo" onclick="return confirm('¿Seguro que desea borrar el recibo?')"><i class="fa fa-times"></i>
                                            </a>
                                        </td>                                                                                
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regrecibos->appends(request()->input())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('request')
@endsection

@section('javascrpt')
@endsection