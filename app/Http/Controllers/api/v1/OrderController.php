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
use Illuminate\Contracts\View\View;
use Barryvdh\DomPDF\Facade as PDF;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  $orders = Order::with('payment')->paginate(5);
    }

    public function download(Request $request)
    {

        $orderDetails = Order::with(['payment'])->where('uuid', $request->uuid)->first();
        $headers = array(
            'Content-Type' => 'application/pdf',
        );
        $pdf = PDF::loadView('pdf', ['orderDetails' => $orderDetails, 'headers' => $headers])->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('order_' . $request->uuid . '.pdf');
    }

    public function dashboard(Request $request)
    {

        $ordersList = Order::with('payment')->paginate(5);

        $totalEarnings = Order::sum('amount');

        $lastThirtyDaysEarning =  Order::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('amount');


        $yearlySales = Order::select(
            DB::raw("year(created_at) as year"),
            DB::raw("count(created_at) as yearlySales")
        )
            ->orderBy(DB::raw("YEAR(created_at)"))
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->get();

        $monthlySales = Order::select(
            DB::raw("month(created_at) as month"),
            DB::raw("count(created_at) as monthlySales")
        )
            ->orderBy(DB::raw("MONTH(created_at)"))
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get();

        $weeklySales = Order::select(
            DB::raw("week(created_at) as week"),
            DB::raw("count(created_at) as weeklySales")
        )
            ->orderBy(DB::raw("WEEK(created_at)"))
            ->groupBy(DB::raw("WEEK(created_at)"))
            ->get();

        $today = date('Y-m-d');
        $todaysales = Order::whereDate('created_at', '=', $today)->count();

        $betweenDateRange = Order::whereBetween('created_at', [$request->from, $request->to])->count();

        return [
            'ordersList' => $ordersList, 'totalEarnings' => $totalEarnings, 'lastThirtyDaysEarning' => $lastThirtyDaysEarning,
            'yearlySales' => $yearlySales, 'monthlySales' => $monthlySales, 'weeklySales' => $weeklySales, 'todaysales' => $todaysales,
            'betweenDateRange' => $betweenDateRange

        ];
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

        if ($request->type == 'credit_card') {
            $payment_data = [];
            $payment_data["holder_name"] = $request->holder_name;
            $payment_data["ccv"] = $request->holder_name;
            $payment_data["expire_date"] = $request->holder_name;
            $payment_data["number"] = $request->holder_name;
        }

        if ($request->type == 'cash_on_delivery') {
            $payment_data = [];
            $payment_data["first_name"] = $request->first_name;
            $payment_data["last_name"] = $request->last_name;
            $payment_data["address"] = $request->address;
        }
        if ($request->type == 'bank_transfer') {
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
            $new_product["quantity"] = $request->products[$i]['quantity'];
            $total_amount += ($request->products[$i]['price'] * $request->products[$i]['quantity']);
            array_push($stock, $new_product);
        }
      
        //Delivery Fee check
        $delivery_fee = $total_amount > 500 ? 0 : 15;
       
        if($delivery_fee > 1) {
          
          $total_amount +=15;

        }
       
        //Handling Order and Payment creation via Transaction in case of failur to rollback
        DB::beginTransaction();
        try {

            // DB::connection()->enableQueryLog();

            $payment = Payment::create([
                'type' => $request->type,
                'details' => $payment_data,
            ]);
            // $queries = DB::getQueryLog();
            //return dd($queries);
            if ($payment) {
                $payment_id = $payment->id;
                $order = Order::create([
                    'user_id' => Auth::user()->id,
                    'order_status_id' => 3,
                    'payment_id' => $payment_id,
                    'products' => $stock,
                    'address' => $new_address,
                    'amount' => $total_amount,
                    'delivery_fee' => $delivery_fee,
                    'shipped_at' => null
                ]);
            }


            DB::commit();

            return response()->json(['Order Created Successfully' => true]);
        } catch (\Exception $e) {
            // dd($e);

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
    public function show($uuid)
    {
        return  $order = Order::with('payment')->where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        //Pending Gul
        /* $this->validate($request, [
            'order_status_uuid' => 'required',
           // 'payment_uuid' => 'required',
            'products' => 'required',
           // 'products.*.price' => 'required',
            'products.*.quantity' => 'required',
            'products.*.uuid' => 'required',
            'billing' => 'required',
            'shipping' => 'required',

        ]);

      //  $total_qty = '0';

        $total_amount = '0';
        $products = $request->get('products');
        dd($products);
        $new_data = [];
        $new_data["uuid"] = $request->uuid;
        $new_data["quantity"] = $request->quantity;

        $new_address = [];
        $new_address["billing"] = $request->billing;
        $new_address["shipping"] = $request->shipping;
        $stock = [];
        for ($i = 0; $i < count($products); $i++) {

            $price = Product::select('price')
            ->where('uuid','=', $request->products[$i]['uuid'])
            ->first();
            $new_product = [];
            $new_product["uuid"] = $request->products[$i]['uuid'];
            $new_product["quantity"] =$request->products[$i]['quantity'];
            $total_amount += $price->price[$i]['price'];
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
                        'shipped_at'=>Carbon::now()
                        ]);

                        Order::where('uuid', $request->uuid)->update([
                            'user_id' => Auth::user()->id,
                            'order_status_id' => 3,
                            'payment_id' => $payment_id,
                            'products' => $stock,
                            'address' => $new_address,
                            'amount' =>$total_amount,
                            'delivery_fee'=>$delivery_fee,
                            'shipped_at'=>Carbon::now()
                        ]);

                }


                DB::commit();

                return response()->json(['Order Created Successfully' => true]);

            } catch (\Exception $e) {
                dd($e);

                DB::rollback();

                return response()->json(['Sorry your order was not placed' => true]);

            } */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();
        $order->payment()->delete();
        $order->delete();

        return response()->json('Order deleted successfully');
    }
}
