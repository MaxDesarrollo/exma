<?php

use Illuminate\Database\Seeder;

use App\User;

class UserSeeder extends Seeder
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
			// [
			// 	'name'			=> 'Raiden',
			// 	'password'		=> \Hash::make('raidenadmin'),
			// 	'tipoUsuario'	=> 'Administrador'
			// ],
			// [
			// 	'name'			=> 'Makio',
			// 	'password'		=> \Hash::make('raidenadmin'),
			// 	'tipoUsuario'	=> 'Vendedor'
			// ],
			[
				'name'			=> 'Paola',
				'password'		=> \Hash::make('paola139'),
				'tipoUsuario'	=> 'Vendedor'
			],
			[
				'name'			=> 'Rebeca',
				'password'		=> \Hash::make('rebeca139'),
				'tipoUsuario'	=> 'Vendedor'
			],
			[
				'name'			=> 'Estela',
				'password'		=> \Hash::make('estela139'),
				'tipoUsuario'	=> 'Vendedor'
			],
			[
				'name'			=> 'Leslie',
				'password'		=> \Hash::make('leslie139'),
				'tipoUsuario'	=> 'Vendedor'
			],
			[
				'name'			=> 'Gabriela',
				'password'		=> \Hash::make('gabriela139'),
				'tipoUsuario'	=> 'Vendedor'
			],
			[
				'name'			=> 'Gustavo',
				'password'		=> \Hash::make('gustavo139'),
				'tipoUsuario'	=> 'Vendedor'
			],
			[
				'name'			=> 'ExmaAdministrador',
				'password'		=> \Hash::make('exmaadmin'),
				'tipoUsuario'	=> 'Administrador'
			]
		);

		User::insert($data);
	}
}
