<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    //
    protected $table = 'eventos';
	protected $fillable = [
        'id',
		'nombre', 
		'capacidad',
		'fechaInicial',
		'fechaFinal',
		'ciudad',
		'idSalon'
	];

	public function salon() {
		return $this->belongsTo('Salon');
	}

	public function sectores() {
		return $this->belongsToMany('Sector');
	}

	public function descuentos() {
		return $this->hasMany('Descuento');
	}
}
