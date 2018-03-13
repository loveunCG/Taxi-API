<?php

use Illuminate\Database\Seeder;

class DispatcherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dispatchers')->truncate();
        DB::table('dispatchers')->insert([
            'name' => 'Demo',
            'email' => 'demo@appoets.com',
            'password' => bcrypt('123456'),
        ],[
            'name' => 'Demo',
            'email' => 'demo@demo.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
