<?php

namespace Database\Seeders;

use App\Core\HelperFunction;
use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promotions = [
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'Promotion 1 ',
                'content' => 'This is the description',
                'metadata' => [
                    'valid_from'=> '2022-01-01',
                    'valid_to'=> '2022-02-01',
                    'image'=> '12345678'
                    ],
            ],
            [

                'uuid' => HelperFunction::_uuid(),
                'title' => 'Promotion 2',
                'content' => 'This is the description',
                'metadata' => [
                    'valid_from'=> '2022-01-01',
                    'valid_to'=> '2022-02-01',
                    'image'=> '12345678'
                    ],
            ],
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'Promotion 3',
                'content' => 'This is the description',
                'metadata' => [
                    'valid_from'=> '2022-01-01',
                    'valid_to'=> '2022-02-01',
                    'image'=> '12345678'
                    ],

            ],
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'Promotion 4',
                'content' => 'This is the description',
                'metadata' => [
                    'valid_from'=> '2022-01-01',
                    'valid_to'=> '2022-02-01',
                    'image'=> '12345678'
                    ],

            ],
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'Promotion 5',
                'content' => 'This is the description',
                'metadata' => [
                    'valid_from'=> '2022-01-01',
                    'valid_to'=> '2022-02-01',
                    'image'=> '12345678'
                    ],

            ]

        ];
        // Store All Campuses in Database
        foreach ($promotions as $item)
        {
            Promotion::create($item);
        }
    }
}
