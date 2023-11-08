<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    \DB::table('products')->insert([
        ['code' => 'R01', 'name' => 'Red Widget', 'price' => 32.95],
        ['code' => 'G01', 'name' => 'Green Widget', 'price' => 24.95],
        ['code' => 'B01', 'name' => 'Blue Widget', 'price' => 7.95],
    ]);
    }
}
