<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       /*  $this->validate($request, [
            'order_status_id' => 'required',
            'payment_id' => 'required',
            'quantity' => 'required', 
            
        ]); */
        $total_amount = '0';
        $products = $request->get('products');
        $payment_method =$request->payment_type;
       // $payment = Product::where('id', $request->products[$q])->first();
      //  dd(count($products));

       // $first_value = $request->products[0]['product_ammount'];
      // dd($first_value);
       $total_qty = '0';
        // loop through all products
       // foreach ($products as $product) {
        $new_data = [];
        $new_data["uuid"] = $request->uuid;
        $new_data["quantity"] = $request->quantity;

        $new_address = [];
        $new_address["billing"] = $request->billing;
        $new_address["shipping"] = $request->shipping;
        $stock = []; 
        for ($i = 0; $i < count($products); $i++) {
            $new_product = [];
            $new_product["uuid"] = $request->products[$i]['uuid'];
            $new_product["quantity"] =$request->products[$i]['quantity'];
            $total_amount += $request->products[$i]['price'];
            array_push($stock, $new_product);


        }
       // for ($i = 0; $i < count($products); $i++) {
           // echo $product['product_id'];
           // echo $product['product_amount'];
          // dd($i);
         // $product = Product::where('id', $request->products[$i]['product_id'])->first();
        // $total_amount += $request->products[$i]['price'];
         $order = Order::create([
            'user_id' => 1,
            'order_status_id' => 2,
            'payment_id' => 1,
            'products' => $stock,
            'address' => $new_address,
            'amount' =>$total_amount,
            'shipped_at'=>null
            ]);
            return new OrderResource($order);
           
      //  }
     //   dd($total_amount);
        // calculate total qty sale
      /*   for ($q = 0; $q < count($orders); $q++) {
           // $total_qty += $request->qty[$q];
            $product = Product::where('id', $request->products[$q])->first();
          //  dd($product);
            $total_amount += $product->price[$q];
        } */
      
 
        /*      if($request->type =='credit_card'){
                $new_data = [];
                $new_data["holder_name"] = $request->holder_name;
                $new_data["ccv"] = $request->holder_name;
                $new_data["expire_date"] = $request->holder_name;
                $new_data["number"] = $request->holder_name;

             }
             
             if($request->type =='cash_on_delivery'){
                $new_data = [];
                $new_data["first_name"] = $request->first_name;
                $new_data["last_name"] = $request->last_name;
                $new_data["address"] = $request->address;

             }
             if($request->type =='bank_transfer'){
                $new_data = [];
                $new_data["swift"] = $request->swift;
                $new_data["iban"] = $request->iban;
                $new_data["name"] = $request->name;

             }
     */
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
