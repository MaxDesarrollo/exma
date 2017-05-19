<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    //
    protected $table = 'asistencias';
    protected $fillable = [
    	'fecha', 
    	'hora', 
    	'tipoAsistencia',
    	'idRegistro',
    	'estadoActivo'
    ];

    public function registro() {
    	return $this->belongsTo('Registro');
    }
}
