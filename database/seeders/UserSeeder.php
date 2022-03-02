<?php

namespace Database\Seeders;

use App\Core\HelperFunction;
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
