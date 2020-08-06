<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 10; $i++){
            DB::table('customers')->insert([
    			'name' => $faker->name,
    			'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'address' => $faker->address,
    		]);
        }
    }
}
