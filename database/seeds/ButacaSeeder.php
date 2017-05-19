<?php

use Illuminate\Database\Seeder;

// use App\Butaca;

class ButacaSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//
		// $sectorVip = array('A', 'B');
		// $sectorBusiness = array('E', 'X', 'M', 'A', 'B', 'O');

		// for ($i = 0; $i < 2; $i++) {
		// 	for ($j = 1; $j <= 105; $j++) {

		// 		\DB::table('butacas')->insert(array(
		// 			'fila'			=> $sectorVip[$i],
		// 			'numero'		=> $j,
		// 			'idSectorEvento'=> 1
		// 		));

		// 	}
		// }

		// for ($i = 0; $i < 6; $i++) {
		// 	for ($j = 1; $j <= 120; $j++) {
				
		// 		\DB::table('butacas')->insert(array(
		// 			'fila'			=> $sectorBusiness[$i],
		// 			'numero'		=> $j,
		// 			'idSectorEvento'=> 2
		// 		));

		// 	}
		// }


		$sectorVip = array('A', 'B', 'C', 'D', 'E', 'F', 'G');
		$sectorBusiness = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T');

		for ($i = 0; $i < 7; $i++) {
			for ($j = 1; $j <= 30; $j++) {
				\DB::table('butacas')->insert(array(
					'fila'			=> $sectorVip[$i],
					'numero'		=> $j,
					'idSectorEvento'=> 1
				));
			}
		}

		for ($i = 0; $i < 20; $i++) {
			for ($j = 1; $j <= 36; $j++) {
				\DB::table('butacas')->insert(array(
					'fila'			=> $sectorBusiness[$i],
					'numero'		=> $j,
					'idSectorEvento'=> 2
				));
			}
		}

		// for ($i = 1; $i <= 120; $i++) {
		// 	\DB::table('butacas')->insert(array(
		// 		'fila' => 'E',
		// 		'numero' => $i,
		// 		'updated_at' => new DateTime
		// 	));

		// 	\DB::table('butacas')->insert(array(
		// 		'fila' => 'X',
		// 		'numero' => $i,
		// 		'updated_at' => new DateTime
		// 	));

		// 	\DB::table('butacas')->insert(array(
		// 		'fila' => 'M',
		// 		'numero' => $i,
		// 		'updated_at' => new DateTime
		// 	));

		// 	\DB::table('butacas')->insert(array(
		// 		'fila' => 'A',
		// 		'numero' => $i,
		// 		'updated_at' => new DateTime
		// 	));

		// 	\DB::table('butacas')->insert(array(
		// 		'fila' => 'B',
		// 		'numero' => $i,
		// 		'updated_at' => new DateTime
		// 	));

		// 	\DB::table('butacas')->insert(array(
		// 		'fila' => 'O',
		// 		'numero' => $i,
		// 		'updated_at' => new DateTime
		// 	));
		// }

		// for ($i = 1; $i <= 120; $i++) {
		// 	\DB::table('butacas')->insert(array(
		// 		'fila' => 'E',
		// 		'numero' => $i,
		// 		'updated_at' => new DateTime
		// 	));

		// 	\DB::table('butacas')->insert(array(
		// 		'fila' => 'X',
		// 		'numero' => $i,
		// 		'updated_at' => new DateTime
		// 	));

		// 	\DB::table('butacas')->insert(array(
		// 		'fila' => 'M',
		// 		'numero' => $i,
		// 		'updated_at' => new DateTime
		// 	));

		// 	\DB::table('butacas')->insert(array(
		// 		'fila' => 'A',
		// 		'numero' => $i,
		// 		'updated_at' => new DateTime
		// 	));

		// 	\DB::table('butacas')->insert(array(
		// 		'fila' => 'B',
		// 		'numero' => $i,
		// 		'updated_at' => new DateTime
		// 	));

		// 	\DB::table('butacas')->insert(array(
		// 		'fila' => 'O',
		// 		'numero' => $i,
		// 		'updated_at' => new DateTime
		// 	));
		// }

		//	$data = array(
		// 	[
		// 		'fila'=> "A",
		// 		'numero'=> 1
		// 	]
		// 	[
		// 		'fila'=> "G",
		// 		'numero'=> 7
		// 	],
		// );

		// Butaca::insert($data);
	}
}
