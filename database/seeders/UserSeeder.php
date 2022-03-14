<?php

namespace Database\Seeders;

use App\Core\HelperFunction;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        User::factory()->count(10)->create();
    /*  $user = User::factory()
            ->has(Order::factory()->count(3))
            ->create(); */

           /*  $user = User::factory()
                ->has(Order::factory()->count(2))
                ->count(3)
                ->create();
 */




        // User Creation
         $user = new User();
        $user->uuid = HelperFunction::_uuid();
        $user->first_name = 'Gul';
        $user->last_name = 'Muhammad';
        $user->is_admin = 1;
        $user->email = 'gul@test.com';
        $user->password = bcrypt('12345678');
        $user->address = 'Islamabad Pakistan';
        $user->phone_number = 123456;
        $user->save(); 
    }
}
