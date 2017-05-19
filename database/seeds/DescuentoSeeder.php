<?php

use Illuminate\Database\Seeder;

use App\Descuento;

class DescuentoSeeder extends Seeder
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
				'descripcion' 			=> '20%',
				'porcentajeDescuento' 	=> 20,
				'fechaInicial'			=> '2017-04-01',
				'fechaFinal'			=> '2017-04-30',
				'habilitado'			=> 0,
				'idEvento'				=> 1
			],
			[
				'descripcion' 			=> '10%',
				'porcentajeDescuento' 	=> 10,
				'fechaInicial'			=> '2017-05-01',
				'fechaFinal'			=> '2017-05-19',
				'habilitado'			=> 1,
				'idEvento'				=> 1
			],
			[
				'descripcion' 			=> '30%',
				'porcentajeDescuento' 	=> 30,
				'fechaInicial'			=> null,
				'fechaFinal'			=> null,
				'habilitado'			=> 0,
				'idEvento'				=> 1
			],
			[
				'descripcion' 			=> '50%',
				'porcentajeDescuento' 	=> 50,
				'fechaInicial'			=> null,
				'fechaFinal'			=> null,
				'habilitado'			=> 0,
				'idEvento'				=> 1
			],
			[
				'descripcion' 			=> 'Free Pass',
				'porcentajeDescuento' 	=> 100,
				'fechaInicial'			=> null,
				'fechaFinal'			=> null,
				'habilitado'			=> 0,
				'idEvento'				=> 1
			],
			[
				'descripcion' 			=> 'Full Price',
				'porcentajeDescuento' 	=> 0,
				'fechaInicial'			=> '2017-05-20',
				'fechaFinal'			=> '2017-06-9',
				'habilitado'			=> 0,
				'idEvento'				=> 1
			],
		);

		Descuento::insert($data);
    }
}
