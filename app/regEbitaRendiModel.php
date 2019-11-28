<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regEbitaRendiModel extends Model
{
    protected $table      = "COMB_EBITACORA_RENDCOMB";
    protected $primaryKey = 'EBITACO_FOLIO';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'EBITACO_FOLIO',
        'PLACA_ID',
        'PLACA_PLACA',
        'PERIODO_ID',
        'MES_ID',        
        'QUINCENA_ID',                
        'EBITACO_FECHA',
        'SP_ID1',
        'SP_NOMB1',
        'SP_ID2',
        'SP_NOMB2',
        'EBITACO_FOTO1',
        'EBITACO_FOTO2',
        'EBITACO_FOTO3',
        'EBITACO_FOTO4',
        'EBITACO_FOTO5',
        'EBITACO_OBS1',
        'EBITACO_OBS2',
        'EBITACO_STATUS1',
        'EBITACO_STATUS2',
        'FECREG',
        'IP',
        'LOGIN',
        'FECHA_M',
        'IP_M',
        'LOGIN_M'
    ];

    
}