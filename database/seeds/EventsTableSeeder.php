<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('events')->insert([
			'name' => 'Test Event 1',
			'description' => 'This is a test event.',
			'date' => '2018-03-28',
		]);
		DB::table('events')->insert([
			'name' => 'Test Event 2',
			'description' => 'This is a test event.',
			'date' => '2018-03-29',
		]);
	}
}