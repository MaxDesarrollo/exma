<?php

use Illuminate\Database\Seeder;

use App\SectorEvento;

class SectorEventoSeeder extends Seeder
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
				'idSector' 	=> 1,
				'idEvento' => 1,
				'precio' => 4000,
				'imagen' => '',
				'urlInscripcion' => 'exma.com.bo/registro/vip',
				'created_at'=> new DateTime,
				'updated_at'=> new DateTime
			],
			[
				'idSector' 	=> 2,
				'idEvento' => 1,
				'precio' => 3000,
				'imagen' => '',
				'urlInscripcion' => 'exma.com.bo/registro/business',
				'created_at'=> new DateTime,
				'updated_at'=> new DateTime
			],
		);

		SectorEvento::insert($data);
    }
}
