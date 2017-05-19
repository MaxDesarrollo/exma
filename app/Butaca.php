<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Butaca extends Model
{
    //
    protected $table = 'butacas';
    protected $fillable = [
    	'fila', 
    	'numero', 
    	'idSectorEvento'
    ];

    public function registros() {
    	return $this->hasMany('Registro');
    }

    public function sector_evento() {
    	return $this->belongsTo('SectorEvento');
    }
}
