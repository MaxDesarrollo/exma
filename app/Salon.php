<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
	//
	protected $table = 'salones';
	protected $fillable = [
        'id',
		'nombre', 
		'direccion'
	];

	public function eventos() {
		return $this->hasMany('Evento');
	}
}
