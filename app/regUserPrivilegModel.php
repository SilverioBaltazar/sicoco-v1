<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regUserPrivilegModel extends Model
{
    protected $table      = "COMB_USERS_PRIVILEGS";
    protected $primaryKey = 'ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'ID',
        'USER_ID',
        'PRIVILEG_ID',
        'STATUS',
        'FECREG',
        'USER_PRIVILEG'
    ];


}