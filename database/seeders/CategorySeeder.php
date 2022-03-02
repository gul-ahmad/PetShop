<?php

namespace Database\Seeders;

use App\Core\HelperFunction;
use App\Models\category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'Category 1',
                'slug' => 'category-1'
            ],
            [
                
                'uuid' => HelperFunction::_uuid(),
                'title' => 'Category 2',
                'slug' => 'category-2'
            ],
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'Category 3',
                'slug' => 'category-3'
            ]  
            
        ];
        // Store All Campuses in Database
        foreach ($categories as $item)
        {
            category::create($item);
        }
        
    }
}
