<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->truncate();
        DB::table('admins')->insert([
            'name' => 'Tranxit',
            'email' => 'admin@tranxit.com',
            'password' => bcrypt('123456'),
        ],[
            'name' => 'Tranxit',
            'email' => 'admin@demo.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
