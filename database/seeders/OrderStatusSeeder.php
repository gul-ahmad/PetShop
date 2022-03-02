<?php

namespace Database\Seeders;

use App\Core\HelperFunction;
use App\Models\order_status;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderStatuses = [
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'open',
                
            ],
            [
                
                'uuid' => HelperFunction::_uuid(),
                'title' => 'pending payment',
               
            ],
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'paid',
               
            ],
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'shipped',
               
            ],
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'cancelled',
               
            ]   
            
        ];
        // Store All Campuses in Database
        foreach ($orderStatuses as $item)
        {
            order_status::create($item);
        }
    }
}
