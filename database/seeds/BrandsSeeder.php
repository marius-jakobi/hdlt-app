<?php

use App\Brand;
use Illuminate\Database\Seeder;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            'Alup',
            'CompAir',
            'FST',
            'pneumatech'
        ];

        foreach ($brands as $brand) {
            $brand = new Brand(['name' => $brand]);
            $brand->save();
        }
    }
}
