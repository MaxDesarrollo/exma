<?php

use Illuminate\Database\Seeder;

use App\Evento;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = array(
			[
				'nombre' 		=> 'EXMA',
				'capacidad' 	=> 942,
				'fechaInicial'	=> '2017-06-08',
				'fechaFinal'	=> '2017-06-09',
				'ciudad'		=> 'Santa Cruz',
				'idSalon'		=> 1,
				'created_at'	=> new DateTime,
				'updated_at'	=> new DateTime
			],
		);

		Evento::insert($data);
    }
}
