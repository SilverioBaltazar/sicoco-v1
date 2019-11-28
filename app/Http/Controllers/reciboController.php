<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\reciboRequest;
use App\regDiasModel;
use App\regMesesModel;
use App\regPfiscalesModel;
use App\regQuincenaModel;
use App\regPlacaModel;
use App\regBitacoraModel;
use App\regMarcaModel;
use App\regTipoGastoModel;
use App\regTipooperacionModel;
use App\regReciboModel;

// Exportar a excel 
//use App\Exports\ExcelExportPLacas;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class reciboController extends Controller
{

    public function actionVerRecibos(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        //$estructura   = session()->get('estructura');
        //$id_estruc    = session()->get('id_estructura');
        //$id_estructura= rtrim($id_estruc," ");
        $role         = session()->get('role');
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
        $regtipogasto = regTipogastoModel::select('TIPOG_ID','TIPOG_DESC')->orderBy('TIPOG_ID','asc')
                        ->get();                                                 
        $regtipooper  = regTipooperacionModel::select('TIPOO_ID','TIPOO_DESC')->orderBy('TIPOO_ID','asc')
                        ->get(); 
        $regplaca     = regPlacaModel::select('PLACA_ID','PLACA_PLACA','PLACA_DESC','PLACA_SERIE','PLACA_ANTERIOR',
                               'PLACA_CILINDROS','MARCA_ID','TIPOO_ID','TIPOG_ID','SP_ID',
                               'PLACA_OBS1','PLACA_OBS2','PLACA_FOTO1','PLACA_FOTO2',
                               'PLACA_STATUS1','PLACA_STATUS2')
                        ->orderBy('PLACA_ID','ASC')
                        ->get();
        //dd($unidades);
        if($role->rol_name == 'user'){                        
            //dd($role->rol_name,$nombre,'ya entre al rol de user');
            $regrecibos   = regReciboModel::select('RECIBO_FOLIO','PLACA_ID','PLACA_PLACA','RECIBO_KI','RECIBO_KF',
                           'QUINCENA_ID','RECIBO_IR','RECIBO_I18','RECIBO_I14','RECIBO_I12','RECIBO_I34','RECIBO_IF',
                           'RECIBO_FR','RECIBO_F18','RECIBO_F14','RECIBO_F12','RECIBO_F34','RECIBO_FF','RECIBO_FECINI',
                           'PERIODO_ID1','MES_ID1','DIA_ID1','RECIBO_FECFIN','PERIODO_ID2','MES_ID2','DIA_ID2',
                           'TIPOO_ID','TARJETA_NO','PERIODO_ID','MES_ID','SP_ID','SP_NOMB', 
                           'RECIBO_RFOTO1','RECIBO_RFOTO2','RECIBO_RFOTO3','RECIBO_RFOTO4','RECIBO_RFOTO5',
                           'RECIBO_BFOTO1','RECIBO_BFOTO2','RECIBO_BFOTO3','RECIBO_BFOTO4','RECIBO_BFOTO5',
                           'RECIBO_OBS1','RECIBO_OBS2','RECIBO_STATUS1','RECIBO_STATUS2',
                           'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                           ->where('LOGIN',$nombre)
                           ->orderBy('RECIBO_FOLIO','ASC')                        
                           ->paginate(30);
        }else{
            // dd($role->rol_name,'Rol distinto de user');
            $regrecibos   = regReciboModel::select('RECIBO_FOLIO','PLACA_ID','PLACA_PLACA','RECIBO_KI','RECIBO_KF',
                           'QUINCENA_ID','RECIBO_IR','RECIBO_I18','RECIBO_I14','RECIBO_I12','RECIBO_I34','RECIBO_IF',
                           'RECIBO_FR','RECIBO_F18','RECIBO_F14','RECIBO_F12','RECIBO_F34','RECIBO_FF','RECIBO_FECINI',
                           'PERIODO_ID1','MES_ID1','DIA_ID1','RECIBO_FECFIN','PERIODO_ID2','MES_ID2','DIA_ID2',
                           'TIPOO_ID','TARJETA_NO','PERIODO_ID','MES_ID','SP_ID','SP_NOMB', 
                           'RECIBO_RFOTO1','RECIBO_RFOTO2','RECIBO_RFOTO3','RECIBO_RFOTO4','RECIBO_RFOTO5',
                           'RECIBO_BFOTO1','RECIBO_BFOTO2','RECIBO_BFOTO3','RECIBO_BFOTO4','RECIBO_BFOTO5',
                           'RECIBO_OBS1','RECIBO_OBS2','RECIBO_STATUS1','RECIBO_STATUS2',
                           'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                           ->orderBy('RECIBO_FOLIO','ASC')                        
                           ->paginate(30);            
        }
        if($regrecibos->count() <= 0){
            toastr()->error('No existen registros de recibos.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }
        return view('sicinar.recibo.verRecibos',compact('nombre','usuario','regperiodo','regmes','regdia','regquincena','regplaca','regmarca','regtipogasto','regtipooper','regrecibos'));
    }

    public function actionNuevoRecibo(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
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
        $regtipogasto = regTipogastoModel::select('TIPOG_ID','TIPOG_DESC')->orderBy('TIPOG_ID','asc')
                        ->get();                                                 
        $regtipooper  = regTipooperacionModel::select('TIPOO_ID','TIPOO_DESC')->orderBy('TIPOO_ID','asc')
                        ->get(); 
        $regplaca     = regPlacaModel::select('PLACA_ID','PLACA_PLACA','PLACA_DESC','PLACA_SERIE','PLACA_ANTERIOR',
                               'PLACA_CILINDROS','MARCA_ID','TIPOO_ID','TIPOG_ID','SP_ID',
                               'PLACA_OBS1','PLACA_OBS2','PLACA_FOTO1','PLACA_FOTO2',
                               'PLACA_STATUS1','PLACA_STATUS2')
                        ->orderBy('PLACA_ID','asc')
                        ->get();
        $regrecibos   = regReciboModel::select('RECIBO_FOLIO','PLACA_ID','PLACA_PLACA','RECIBO_KI','RECIBO_KF',
                        'QUINCENA_ID','RECIBO_IR','RECIBO_I18','RECIBO_I14','RECIBO_I12','RECIBO_I34','RECIBO_IF',
                        'RECIBO_FR','RECIBO_F18','RECIBO_F14','RECIBO_F12','RECIBO_F34','RECIBO_FF','RECIBO_FECINI',
                        'PERIODO_ID1','MES_ID1','DIA_ID1','RECIBO_FECFIN','PERIODO_ID2','MES_ID2','DIA_ID2',
                        'TIPOO_ID','TARJETA_NO','PERIODO_ID','MES_ID','SP_ID','SP_NOMB', 
                        'RECIBO_RFOTO1','RECIBO_RFOTO2','RECIBO_RFOTO3','RECIBO_RFOTO4','RECIBO_RFOTO5',
                        'RECIBO_BFOTO1','RECIBO_BFOTO2','RECIBO_BFOTO3','RECIBO_BFOTO4','RECIBO_BFOTO5',
                        'RECIBO_OBS1','RECIBO_OBS2','RECIBO_STATUS1','RECIBO_STATUS2',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->orderBy('RECIBO_FOLIO','asc')
                        ->get();                        
        //dd($unidades);
        return view('sicinar.recibo.nuevoRecibo',compact('regperiodo','regmes','regdia','regquincena','regplaca','regmarca','regtipogasto','regtipooper','regrecibos','nombre','usuario'));
    }

    public function actionAltaNuevoRecibo(Request $request){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        /************ Obtenemos la IP ***************************/                
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }        

        /************ ALTA  *****************************/ 
        //https://ajgallego.gitbooks.io/laravel-5/content/capitulo_4_datos_de_entrada.html
        // video https://www.youtube.com/watch?v=1Z7oson-G8M
        // Mover el fichero a la ruta conservando el nombre original:         
        //$request->file('photo')->move($destinationPath);
        // Mover el fichero a la ruta con un nuevo nombre:
        //$request->file('photo')->move($destinationPath, $fileName);

        //*********** Se obtiene la placa y el resguardatario   *****/
        $placa_placa = regPlacaModel::ObtPlaca($request->placa_id);
        $recibo_obs2 = regPlacaModel::ObtResguardatario($request->placa_id);
        $tipoo_id    = regPlacaModel::ObtTipoOperacion($request->placa_id);

        $mes1 = regMesesModel::ObtMes($request->mes_id1);
        $dia1 = regDiasModel::ObtDia($request->dia_id1);
        $mes2 = regMesesModel::ObtMes($request->mes_id2);
        $dia2 = regDiasModel::ObtDia($request->dia_id2);

        $recibo_folio = regReciboModel::max('RECIBO_FOLIO');
        $recibo_folio = $recibo_folio+1;

        $nuevorecibo  = new regReciboModel();
        $name11 =null;
        //Comprobar  si el campo foto1 tiene un archivo asignado:
        if($request->hasFile('recibo_rfoto1')){
           $name11 = $recibo_folio.'_'.$request->file('recibo_rfoto1')->getClientOriginalName(); 
           //$file->move(public_path().'/images/', $name1);
           //sube el archivo a la carpeta del servidor public/images/
           $request->file('recibo_rfoto1')->move(public_path().'/images/', $name11);
        }
        $name21 =null;
        //Comprobar  si el campo foto2 tiene un archivo asignado:        
        if($request->hasFile('recibo_bfoto1')){
           $name21 = $recibo_folio.'_'.$request->file('recibo_bfoto1')->getClientOriginalName(); 
           //sube el archivo a la carpeta del servidor public/images/
           $request->file('recibo_bfoto1')->move(public_path().'/images/', $name21);
        }

        $nuevorecibo->RECIBO_FOLIO   = $recibo_folio;
        $nuevorecibo->PLACA_ID       = $request->placa_id;
        $nuevorecibo->PLACA_PLACA    = strtoupper($placa_placa[0]->placa_placa);

        $nuevorecibo->RECIBO_KI       = $request->recibo_ki;
        $nuevorecibo->RECIBO_KF       = $request->recibo_kf;
        $nuevorecibo->QUINCENA_ID     = $request->quincena_id;
        $nuevorecibo->RECIBO_IR       = $request->recibo_ir;
        $nuevorecibo->RECIBO_I18      = $request->recibo_i18;
        $nuevorecibo->RECIBO_I14      = $request->recibo_i14;
        $nuevorecibo->RECIBO_I12      = $request->recibo_i13;
        $nuevorecibo->RECIBO_I34      = $request->recibo_i34;
        $nuevorecibo->RECIBO_IF       = $request->recibo_if;        

        $nuevorecibo->RECIBO_FR       = $request->recibo_fr;
        $nuevorecibo->RECIBO_F18      = $request->recibo_f18;
        $nuevorecibo->RECIBO_F14      = $request->recibo_f14;
        $nuevorecibo->RECIBO_F12      = $request->recibo_f13;
        $nuevorecibo->RECIBO_F34      = $request->recibo_f34;
        $nuevorecibo->RECIBO_FF       = $request->recibo_ff;        

        $nuevorecibo->RECIBO_FECINI   = trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1);
        $nuevorecibo->PERIODO_ID1     = $request->periodo_id1;
        $nuevorecibo->MES_ID1         = $request->mes_id1;
        $nuevorecibo->DIA_ID1         = $request->dia_id1;

        $nuevorecibo->RECIBO_FECFIN   = trim($dia2[0]->dia_desc.'/'.$mes2[0]->mes_mes.'/'.$request->periodo_id2);
        $nuevorecibo->PERIODO_ID2     = $request->periodo_id3;
        $nuevorecibo->MES_ID2         = $request->mes_id3;
        $nuevorecibo->DIA_ID2         = $request->dia_id3;

        $nuevorecibo->TIPOO_ID        = $tipoo_id[0]->tipoo_id;

        $nuevorecibo->TARJETA_NO      = $request->tarjeta_no;
        $nuevorecibo->PERIODO_ID      = $request->periodo_id;        
        $nuevorecibo->MES_ID          = $request->mes_id;
        $nuevorecibo->SP_NOMB         = strtoupper($recibo_obs2[0]->placa_obs2);
        
        $nuevorecibo->RECIBO_OBS1     = strtoupper($request->recibo_obs1);
        $nuevorecibo->RECIBO_OBS2     = strtoupper($recibo_obs2[0]->placa_obs2);
        $nuevorecibo->RECIBO_RFOTO1   = $name11;
        $nuevorecibo->RECIBO_BFOTO1   = $name21;
        $nuevorecibo->IP            = $ip;
        $nuevorecibo->LOGIN         = $nombre;         // Usuario ;
        $nuevorecibo->save();

        if($nuevorecibo->save() == true){
            toastr()->success('Recibo registrado.  ','OK!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       150;    //Alta 

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $recibo_folio])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $recibo_folio;   // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $recibo_folio])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         

                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO' => $recibo_folio])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP           = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }
            /************ Bitacora termina *************************************/ 

        }else{
            toastr()->error('Error inesperado al dar de alta el recibo. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            //return back();
            //return redirect()->route('nuevoProceso');
        }

        return redirect()->route('verRecibos');
    }


    public function actionEditarRecibo($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');

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
        $regtipogasto = regTipogastoModel::select('TIPOG_ID','TIPOG_DESC')->orderBy('TIPOG_ID','asc')
                        ->get();                                                 
        $regtipooper  = regTipooperacionModel::select('TIPOO_ID','TIPOO_DESC')->orderBy('TIPOO_ID','asc')
                        ->get(); 
        $regplaca     = regPlacaModel::select('PLACA_ID','PLACA_PLACA','PLACA_DESC','PLACA_SERIE','PLACA_ANTERIOR',
                               'PLACA_CILINDROS','MARCA_ID','TIPOO_ID','TIPOG_ID','SP_ID',
                               'PLACA_OBS1','PLACA_OBS2','PLACA_FOTO1','PLACA_FOTO2',
                               'PLACA_STATUS1','PLACA_STATUS2')
                        ->orderBy('PLACA_ID','asc')
                        ->get();
        $regrecibos   = regReciboModel::select('RECIBO_FOLIO','PLACA_ID','PLACA_PLACA','RECIBO_KI','RECIBO_KF',
                        'QUINCENA_ID','RECIBO_IR','RECIBO_I18','RECIBO_I14','RECIBO_I12','RECIBO_I34','RECIBO_IF',
                        'RECIBO_FR','RECIBO_F18','RECIBO_F14','RECIBO_F12','RECIBO_F34','RECIBO_FF','RECIBO_FECINI',
                        'PERIODO_ID1','MES_ID1','DIA_ID1','RECIBO_FECFIN','PERIODO_ID2','MES_ID2','DIA_ID2',
                        'TIPOO_ID','TARJETA_NO','PERIODO_ID','MES_ID','SP_ID','SP_NOMB', 
                        'RECIBO_RFOTO1','RECIBO_RFOTO2','RECIBO_RFOTO3','RECIBO_RFOTO4','RECIBO_RFOTO5',
                        'RECIBO_BFOTO1','RECIBO_BFOTO2','RECIBO_BFOTO3','RECIBO_BFOTO4','RECIBO_BFOTO5',
                        'RECIBO_OBS1','RECIBO_OBS2','RECIBO_STATUS1','RECIBO_STATUS2',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where('RECIBO_FOLIO',$id)
                        ->orderBy('RECIBO_FOLIO','ASC')
                        ->first();
        if($regrecibos->count() <= 0){
            toastr()->error('No existe registro de recibo.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }
        return view('sicinar.recibo.editarRecibo',compact('regperiodo','regmes','regdia','regquincena','regplaca','regmarca','regtipogasto','regtipooper','regrecibos','nombre','usuario'));
    }

    public function actionActualizarRecibo(reciboRequest $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');

        // **************** actualizar ******************************
        $regrecibos = regReciboModel::where('RECIBO_FOLIO',$id);
        if($regrecibos->count() <= 0)
            toastr()->error('No existe recibo.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $name1 =null;
            //   if(!empty($_PUT['recibo_rfoto1'])){
            if(isset($request->recibo_rfoto1)){
                if(!empty($request->recibo_rfoto1)){
                    //Comprobar  si el campo foto1 tiene un archivo asignado:
                    if($request->hasFile('recibo_rfoto1')){
                      $name1 = $id.'_'.$request->file('recibo_rfoto1')->getClientOriginalName(); 
                      //sube el archivo a la carpeta del servidor public/images/
                      $request->file('recibo_rfoto1')->move(public_path().'/images/', $name1);
                    }
                }
            }

            //*********** Se obtiene la placa y el resguardatario   *****/
            $placa_placa = regPlacaModel::ObtPlaca($request->placa_id);
            $recibo_obs2 = regPlacaModel::ObtResguardatario($request->placa_id);
            $tipoo_id    = regPlacaModel::ObtTipoOperacion($request->placa_id);

            $mes1 = regMesesModel::ObtMes($request->mes_id1);
            $dia1 = regDiasModel::ObtDia($request->dia_id1);
            $mes2 = regMesesModel::ObtMes($request->mes_id2);
            $dia2 = regDiasModel::ObtDia($request->dia_id2);

            $regrecibos = regReciboModel::where('RECIBO_FOLIO',$id)        
            ->update([                
                //'PLACA_ID'       => $request->placa_id,
                //'PLACA_PLACA'    => $request->placa_placa,
                'RECIBO_KI'      => $request->recibo_ki,
                'RECIBO_KF'      => $request->recibo_kf,                
                'RECIBO_IR'      => $request->recibo_ir,
                'RECIBO_I18'     => $request->recibo_i18,                
                'RECIBO_I14'     => $request->recibo_i14,
                'RECIBO_I12'     => $request->recibo_i12,                
                'RECIBO_I34'     => $request->recibo_i34,
                'RECIBO_IF'      => $request->recibo_if, 

                'RECIBO_FR'      => $request->recibo_fr,
                'RECIBO_F18'     => $request->recibo_f18,                
                'RECIBO_F14'     => $request->recibo_f14,
                'RECIBO_F12'     => $request->recibo_f12,                
                'RECIBO_F34'     => $request->recibo_f34,
                'RECIBO_FF'      => $request->recibo_ff,                                

                'RECIBO_FECINI'  => trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1),
                'PERIODO_ID1'    => $request->periodo_id2,                
                'MES_ID1'        => $request->mes_id2,
                'DIA_ID1'        => $request->dia_id2,

                'RECIBO_FECFIN'  => trim($dia2[0]->dia_desc.'/'.$mes2[0]->mes_mes.'/'.$request->periodo_id2),  
                'PERIODO_ID2'    => $request->periodo_id2,                
                'MES_ID2'        => $request->mes_id2,
                'DIA_ID2'        => $request->dia_id2,

                //'TIPOO_ID'       => $tipoo_id[0]->tipoo_id,
                'TARJETA_NO'     => strtoupper($request->tarjeta_no),  
                'PERIODO_ID'     => $request->periodo_id,  
                'MES_ID'         => $request->mes_id,           
                //'SP_NOMB'        => strtoupper($recibo_obs2[0]->placa_obs2),

                'RECIBO_OBS1'    => strtoupper($request->recibo_obs1),
                //'RECIBO_OBS2'    => strtoupper($recibo_obs2[0]->placa_obs2),
                'QUINCENA_ID'    => $request->quincena_id,                
                'RECIBO_STATUS1'  => $request->recibo_status1, 
                //'PLACA_FOTO1'    => $name1, 
                'IP_M'           => $ip,
                'LOGIN_M'        => $nombre,
                'FECHA_M'        => date('Y/m/d')    //date('d/m/Y')                                
            ]);
            toastr()->success('Recibo actualizado correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       151;    //Actualizar        

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $id;             // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                                  'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                  'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id,'FOLIO' => $id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP           = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                       ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }
            /************ Bitacora termina *************************************/         
        }

        return redirect()->route('verRecibos');
    }


    public function actionBorrarRecibo($id){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        //echo 'Ya entre aboorar registro..........';

        /************ Elimina la IAP **************************************/
        $regrecibo = regReciboModel::where('RECIBO_FOLIO',$id);
        //                    ->find('RUBRO_ID',$id);
        if($regrecibo->count() <= 0)
            toastr()->error('No existe recibo.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regrecibo->delete();
            toastr()->success('Recibo eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);


            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       153;     // Baja 

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $id;             // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                   toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                   toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                            ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         

                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M' => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                       ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }
            /************ Bitacora termina *************************************/     
        }
        /************* Termina de eliminar  **********************************/
        return redirect()->route('verRecibos');
    }    


}
