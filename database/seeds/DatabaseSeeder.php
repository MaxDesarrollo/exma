<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// $this->call(UsersTableSeeder::class);
		// $this->call(SectorSeeder::class);
		$this->call(UserSeeder::class);
		// $this->call(ButacaSeeder::class);
		$this->call(SalonSeeder::class);
		$this->call(SectorSeeder::class);
		$this->call(EventoSeeder::class);
		$this->call(SectorEventoSeeder::class);
		$this->call(ButacaSeeder::class);
		$this->call(DescuentoSeeder::class);
	}
}
