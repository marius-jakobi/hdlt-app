<?php

use App\Models\Brand;
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
            'pneumatech',
            'Renner'
        ];

        foreach ($brands as $brand) {
            $brand = new Brand(['name' => $brand]);
            $brand->save();
        }
    }
}
