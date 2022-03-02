<?php

namespace Database\Seeders;

use App\Core\HelperFunction;
use App\Models\brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'Brand 1',
                'slug' => 'brand-1'
            ],
            [
                
                'uuid' => HelperFunction::_uuid(),
                'title' => 'Brand 2',
                'slug' => 'brand-2'
            ],
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'Brand 3',
                'slug' => 'brand-3'
            ]  
            
        ];
        // Store All Campuses in Database
        foreach ($brands as $item)
        {
            brand::create($item);
        }
    }
}
