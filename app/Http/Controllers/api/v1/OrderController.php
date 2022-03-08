<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

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
         $this->validate($request, [
            'type' => 'required',
            'number' => 'required_if:type,credit_card',
            'expire_date' => 'required_if:type,credit_card',
            'ccv' => 'required_if:type,credit_card',
            'holder_name' => 'required_if:type,credit_card',
            'first_name' => 'required_if:type,cash_on_delivery',
            'last_name' => 'required_if:type,cash_on_delivery',
            'address' => 'required_if:type,cash_on_delivery',
            'swift' => 'required_if:type,bank_transfer',
            'iban' => 'required_if:type,bank_transfer',
            'name' => 'required_if:type,bank_transfer',
            'products' => 'required', 
            'products.*.price' => 'required',
            'products.*.quantity' => 'required',
            'products.*.uuid' => 'required',
            'billing' => 'required',
            'shipping' => 'required',
            
        ]); 
      
        if($request->type =='credit_card'){
            $payment_data = [];
            $payment_data["holder_name"] = $request->holder_name;
            $payment_data["ccv"] = $request->holder_name;
            $payment_data["expire_date"] = $request->holder_name;
            $payment_data["number"] = $request->holder_name;

         }
         
         if($request->type =='cash_on_delivery'){
            $payment_data = [];
            $payment_data["first_name"] = $request->first_name;
            $payment_data["last_name"] = $request->last_name;
            $payment_data["address"] = $request->address;

         }
         if($request->type =='bank_transfer'){
            $payment_data = [];
            $payment_data["swift"] = $request->swift;
            $payment_data["iban"] = $request->iban;
            $payment_data["name"] = $request->name;

         }

       $total_qty = '0';
      
        $total_amount = '0';
        $products = $request->get('products');   
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
        //Delivery Fee check
        $delivery_fee = $total_amount > 500 ? 0 : 15;
       
           //Handling Order and Payment creation via Transaction in case of failur to rollback  
            DB::beginTransaction();
            try{
    
             // DB::connection()->enableQueryLog();
             
               $payment = Payment::create([
                'type' => $request->type,
                'details' => $payment_data,
                ]);
               // $queries = DB::getQueryLog();
                //return dd($queries);
                if($payment) {
                    $payment_id =$payment->id;
                    $order = Order::create([
                        'user_id' => Auth::user()->id,
                        'order_status_id' => 3,
                        'payment_id' => $payment_id,
                        'products' => $stock,
                        'address' => $new_address,
                        'amount' =>$total_amount,
                        'delivery_fee'=>$delivery_fee,
                        'shipped_at'=>null
                        ]);
                      
                }
               
                
                DB::commit();
    
                return response()->json(['Order Created Successfully' => true]);
    
            } catch (\Exception $e) {
                dd($e);
    
                DB::rollback();
    
                return response()->json(['Sorry your order was not placed' => true]);
    
            }
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
