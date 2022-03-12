<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       return [
            'user_id'=>User::inRandomOrder()->first()->id,
            'order_status_id'=>OrderStatus::inRandomOrder(1,10)->value('id'),
            'payment_id'=>OrderStatus::inRandomOrder(1,10)->value('id'),
            'uuid' => $this->faker->uuid,

            'products' => [
                'uuid' =>Product::inRandomOrder()->first()->uuid,
                'quantity' => $this->faker->random(1,5),
            ],


            'address' => $this->faker->name(),
            'delivery_fee' => $this->faker->boolean(false),
            'amount' => $this->faker->unique()->safeEmail(),
        ];
        }
}
