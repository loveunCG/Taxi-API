<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class ServiceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('service_types')->truncate();
        DB::table('service_types')->insert([
            [
                'name' => 'Sedan',
                'provider_name' => 'Driver',
                'fixed' => 20,
                'price' => 10,
                'status' => 1,
                'minute' => 0,
                'distance' => '1',
                'calculator' => 'DISTANCE',
                'image' => asset('asset/img/cars/sedan.png'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Hatchback',
                'provider_name' => 'Driver',
                'fixed' => 20,
                'price' => 10,
                'status' => 1,
                'minute' => 0,
                'distance' => '1',
                'calculator' => 'DISTANCE',
                'image' => asset('asset/img/cars/hatchback.png'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'SUV',
                'provider_name' => 'Driver',
                'fixed' => 20,
                'price' => 10,
                'status' => 1,
                'minute' => 0,
                'distance' => '1',
                'calculator' => 'DISTANCE',
                'image' => asset('asset/img/cars/suv.png'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Limousine',
                'provider_name' => 'Driver',
                'fixed' => 20,
                'price' => 10,
                'status' => 1,
                'minute' => 0,
                'distance' => '1',
                'calculator' => 'DISTANCE',
                'image' => asset('asset/img/cars/limo.png'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
