<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    //
    protected $table = 'descuentos';
    protected $fillable = [
    	'descripcion', 
    	'porcentajeDescuento', 
    	'fechaInicial', 
    	'fechaFinal', 
    	'habilitado', 
    	'idEvento'
    ];

    public function evento() {
        return $this->belongsTo('Evento');
    }
}
