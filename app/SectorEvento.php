<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectorEvento extends Model
{
	//
	protected $table = 'sectores_eventos';
	protected $fillable = [
        'id',
		'idSector', 
		'idEvento',
		'precio', 
		'imagen',
		'urlInscripcion'
	];

	public function registros() {
		return $this->hasMany('Registro');
	}

	public function butacas() {
		return $this->hasMany('Butaca');
	}
}
