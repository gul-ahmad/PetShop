<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
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
     * @return \Illuminate\Http\JsonResponse
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

        ]);

        if ($request->type == 'credit_card') {
            $new_data = [];
            $new_data["holder_name"] = $request->holder_name;
            $new_data["ccv"] = $request->holder_name;
            $new_data["expire_date"] = $request->holder_name;
            $new_data["number"] = $request->holder_name;
        }

        if ($request->type == 'cash_on_delivery') {
            $new_data = [];
            $new_data["first_name"] = $request->first_name;
            $new_data["last_name"] = $request->last_name;
            $new_data["address"] = $request->address;
        }
        if ($request->type == 'bank_transfer') {
            $new_data = [];
            $new_data["swift"] = $request->swift;
            $new_data["iban"] = $request->iban;
            $new_data["name"] = $request->name;
        }

        $payment = Payment::create([
            'type' => $request->type,
            'details' => $new_data,
        ]);

        return new PaymentResource($payment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($uuid)
    {

        $payment = Payment::where('uuid', $uuid)->firstOrFail();
        $payment->delete();

        return response()->json('Payment deleted successfully');
    }
}
