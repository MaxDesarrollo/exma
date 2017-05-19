<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// use App\Asistencia;

class Registro extends Model
{
    //
    protected $table = 'registros';
    protected $fillable = [
        'id',
        'fechaRegistro',
        'horaRegistro',
        'tipoPago',
        'precio',
        'porcentajeDescuento',
        'pagado',
        'fechaPago',
        'habilitado',
		'idCliente', 
    	'idSectorEvento',
    	'idButaca',
        'idUser'
    ];

    public function cliente() {
        return $this->belongsTo('Cliente');
    }

    public function sector_evento() {
        return $this->belongsTo('SectorEvento');
    }

    public function butaca() {
        return $this->belongsTo('Butaca');
    }

    public function asistencias() {
        return $this->hasMany('App\Asistencia', 'id', 'idRegistro');
    }
}
