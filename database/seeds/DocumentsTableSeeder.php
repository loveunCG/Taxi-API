<?php

use Illuminate\Database\Seeder;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documents')->truncate();
        DB::table('documents')->insert([
            [
                'name' => 'Driving Licence',
                'type' => 'DRIVER',
            ],
            [
                'name' => 'Bank Passbook',
                'type' => 'DRIVER',
            ],
            [
                'name' => 'Joining Form',
                'type' => 'DRIVER',
            ],
            [
                'name' => 'Work Permit',
                'type' => 'DRIVER',
            ],
            [
                'name' => 'Registration Certificate',
                'type' => 'VEHICLE',
            ],
            [
                'name' => 'Insurance Certificate',
                'type' => 'VEHICLE',
            ],
            [
                'name' => 'Fitness Certificate',
                'type' => 'VEHICLE',
            ],
        ]);
    }
}
