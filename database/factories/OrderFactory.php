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
       //Todo:Remaining I tried it but was not clear in few things and could not find a clear help

       /*  $orderStatus=OrderStatus::inRandomOrder(1,10)->value('id');
        $prdocutEntries = Product::inRandomOrder(1,3)->get();
        $total_amount = '0';
        $product = [
            'user_id'=>User::inRandomOrder()->first()->id,
            'order_status_id'=>$orderStatus,
            'payment_id'=>OrderStatus::inRandomOrder(1,10)->value('id'),
            'uuid' => $this->faker->uuid,

            'products' => [
                'uuid' =>$prdocutEntries->first()->uuid,
                'quantity' => $this->faker->random(1,5),
            ],
             

            'address' => $this->faker->name(),
            'delivery_fee' => $this->faker->boolean(false),
            'amount' =>null,
        ]; */

       /*  for ($i = 0; $i < count($product->products); $i++) {

            $new_product = [];
            $new_product["uuid"] = $request->products[$i]['uuid'];
            $new_product["quantity"] = $request->products[$i]['quantity'];
            $total_amount += ($request->products[$i]['price'] * $request->products[$i]['quantity']);
            array_push($stock, $new_product);
        }
        //Delivery Fee check
        $delivery_fee = $total_amount > 500 ? 0 : 15;
        if ($delivery_fee > 1) {

            $total_amount += 15;
        } */

           /*  if($orderStatus === 3) {
                $factory->define(Post::class, function ($faker) use ($factory) {
                    return [
                        'title' => $faker->sentence(3),
                        'content' => $faker->paragraph(5),
                        'user_id' => User::pluck('id')[$faker->numberBetween(1,User::count()-1)]
                    ];
                    });
            } */

           /*  if ($orderStatus = 'paid') {
                return $category->id;
            } */

           /*  if($orderStatus === 4) {
               // $product['playlength'] = $this->faker->randomFloat(2,40,140);
               return [
                'uuid'=>$this->faker->uuid,
                'type'=> $this->faker->word('cash_on_delivery'),
                'details' => [
                    'first_name' =>$this->faker->unique()->words(14),
                    'last_name' => $this->faker->unique()->words(14),
                    'address' => $this->faker->address
                ],
            ];
            } */



          //  return $product;

        }
}
