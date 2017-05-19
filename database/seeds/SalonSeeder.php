<?php

use Illuminate\Database\Seeder;

use App\Salon;

class SalonSeeder extends Seeder
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
				'nombre' 	=> 'Salon 1',
				'direccion' => 'Fexpocruz',
				'created_at'=> new DateTime,
				'updated_at'=> new DateTime
			],
			[
				'nombre' 	=> 'Salon 2',
				'direccion' => 'Fexpocruz',
				'created_at'=> new DateTime,
				'updated_at'=> new DateTime
			],
		);

		Salon::insert($data);
    }
}
