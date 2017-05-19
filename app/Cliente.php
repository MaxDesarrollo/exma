<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    protected $table = 'clientes';
    protected $fillable = [
        'id',
    	'nombres', 
    	'apellidos', 
    	'nombreEmpresa', 
    	'cargoEmpresa', 
    	'nit', 
    	'razonSocial', 
    	'emailPersonal', 
    	'emailCorporativo', 
    	'cedulaIdentidad', 
    	'telefono',
    	'ciudad'
    ];

    public function registros() {
        return $this->hasMany('Registro');
    }
}
