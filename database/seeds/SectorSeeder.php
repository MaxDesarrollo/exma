<?php

use Illuminate\Database\Seeder;

use App\Sector;

class SectorSeeder extends Seeder
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
				'nombre' 	=> 'VIP',
				'created_at'=> new DateTime,
				'updated_at'=> new DateTime
			],
			[
				'nombre' 	=> 'Business', 
				'created_at'=> new DateTime,
				'updated_at'=> new DateTime
			],
			[
				'nombre' 	=> 'Auspiciador', 
				'created_at'=> new DateTime,
				'updated_at'=> new DateTime
			],
		);

		Sector::insert($data);
    }
}
