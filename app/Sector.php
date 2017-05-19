<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    //
    protected $table = 'sectores';
    protected $fillable = [
    	'id', 
    	'nombre'
    ];

    public function eventos() {
		return $this->belongsToMany('Evento');
	}
}
