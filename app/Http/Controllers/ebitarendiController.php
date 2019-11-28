<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ebitacorarendiboRequest;
use App\regDiasModel;
use App\regMesesModel;
use App\regPfiscalesModel;
use App\regQuincenaModel;
use App\regPlacaModel;
use App\regBitacoraModel;
use App\regMarcaModel;
use App\regEbitaRendiModel;
//use App\regTipoGastoModel;
//use App\regTipooperacionModel;
//use App\regReciboModel;

// Exportar a excel 
//use App\Exports\ExcelExportPLacas;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class ebitarendiController extends Controller
{


    public function actionVerEbitaRendi(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        //$estructura   = session()->get('estructura');
        //$id_estruc    = session()->get('id_estructura');
        //$id_estructura= rtrim($id_estruc," ");
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $regperiodo   = regPfiscalesModel::select('PERIODO_ID','PERIODO_DESC')->orderBy('PERIODO_ID','asc')
                        ->get();   
        $regmes       = regMesesModel::select('MES_ID','MES_DESC')->orderBy('MES_ID','asc')
                        ->get();   
        $regdia       = regDiasModel::select('DIA_ID','DIA_DESC')->orderBy('DIA_ID','asc')
                        ->get();   
        $regquincena  = regQuincenaModel::select('QUINCENA_ID','QUINCENA_DESC')->orderBy('QUINCENA_ID','asc')
                        ->get(); 
        $regmarca     = regMarcaModel::select('MARCA_ID','MARCA_DESC')->orderBy('MARCA_ID','asc')
                        ->get();   
        //$regtipogasto = regTipogastoModel::select('TIPOG_ID','TIPOG_DESC')->orderBy('TIPOG_ID','asc')
        //                ->get();                                                 
        //$regtipooper  = regTipooperacionModel::select('TIPOO_ID','TIPOO_DESC')->orderBy('TIPOO_ID','asc')
        //                ->get(); 
        $regplaca     = regPlacaModel::select('PLACA_ID','PLACA_PLACA','PLACA_DESC','PLACA_SERIE','PLACA_ANTERIOR',
                               'PLACA_CILINDROS','MARCA_ID','TIPOO_ID','TIPOG_ID','SP_ID',
                               'PLACA_OBS1','PLACA_OBS2','PLACA_FOTO1','PLACA_FOTO2',
                               'PLACA_STATUS1','PLACA_STATUS2')
                        ->orderBy('PLACA_ID','ASC')
                        ->get();
        $regebitarendi= regEbitaRendiModel::select('EBITACO_FOLIO','PLACA_ID','PLACA_PLACA','PERIODO_ID','MES_ID',
                                'QUINCENA_ID','EBITACO_FECHA','SP_ID1','SP_NOMB1','SP_ID2','SP_NOMB2','EBITACO_FOTO1',
                                'EBITACO_FOTO2','EBITACO_FOTO3','EBITACO_FOTO4','EBITACO_FOTO5','EBITACO_OBS1',
                                'EBITACO_OBS2','EBITACO_STATUS1','EBITACO_STATUS2',
                                'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->orderBy('EBOTACO_FOLIO','ASC')                        
                        ->paginate(30);
        if($regebitarendi->count() <= 0){
            toastr()->error('No existen registros de encabezado de bitacora.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }
        return view('sicinar.bitacorarendimiento.verEbitaRendi',compact('nombre','usuario','regperiodo','regmes','regdia','regquincena','regplaca','regmarca','regebitarendi'));
    }

  


}
