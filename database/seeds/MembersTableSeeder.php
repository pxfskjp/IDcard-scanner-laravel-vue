<?php

use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('members')->insert([
			'first_name' => 'John',
			'last_name' => 'Smith',
			'barcode_id' => '00000001',
			'optional_1' => 'Optional 1',
			'optional_2' => 'Optional 2',
			'optional_3' => 'Optional 3',
			'optional_4' => 'Optional 4',
			'printed' => '0',
		]);
		DB::table('members')->insert([
			'first_name' => 'Jane',
			'last_name' => 'Doe',
			'barcode_id' => '00000002',
			'optional_1' => 'Optional 1',
			'optional_2' => 'Optional 2',
			'optional_3' => 'Optional 3',
			'optional_4' => 'Optional 4',
			'printed' => '0',
		]);
	}
}
