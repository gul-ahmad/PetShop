<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'category_uuid'=> Category::inRandomOrder()->first()->uuid,
            'uuid'=>$this->faker->uuid,
            'title'=> $this->faker->word,
            'price' => $this->faker->randomDigit,
            'description' => $this->faker->sentence,
            'meta'=> [
                'brand' => Brand::inRandomOrder(1,3)->value('uuid'),
            ],
        ];
    }
}
