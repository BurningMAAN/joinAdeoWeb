<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //
        $faker = Faker::create('App\Product');

        $MAX_PRODUCTS = 1000;
        for($i = 0; $i < $MAX_PRODUCTS; $i++){

            DB::table('products')->insert([
                'sku' => $faker->regexify('[A-Za-z0-9]{4}'),
                'name' => $faker->randomElement([
                    'Jacket', 'Sweater', 'BlackCap', 'Fullcap', 'Shorts', 'LongsleeveShirt'
                ]),
                'price' => $faker->randomNumber($nbDigits = 3),
                'condition' => $faker->randomElement([
                    'clear', 'isolated-clouds', 'scattered-clouds', 'overcast', 'light-rain', 'moderate-rain', 'heavy-rain',
                    'sleet', 'light-snow', 'moderate-snow', 'heavy-snow', 'fog'
                ])
            ]);

        }
    }
}
