<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SupplierTableSeeder extends Seeder
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
            DB::table('suppliers')->insert([
    			'name' => $faker->name,
    			'company' => $faker->company,
    			'phone' => $faker->phoneNumber,
    			'telp' => $faker->phoneNumber,
                'email' => $faker->email,
                'address' => $faker->address,
    		]);
        }
    }
}
