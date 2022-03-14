<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderStatusResource;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = OrderStatus::all();

        return response()->json([OrderStatusResource::collection($data), 'Order statuses fetched.']);
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
            'title' => 'required|unique:order_statuses',
        ]);

        if (OrderStatus::where('title', $request->title)->exists()) {
            return response()->json(['Status already exist']);
        }
        $status = OrderStatus::create([
            'title' => $request->title,
        ]);

        return new OrderStatusResource($status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($uuid)
    {
        return new OrderStatusResource($uuid);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $uuid)
    {
        $this->validate($request, [
            'title' => 'required|unique:order_statuses',
        ]);
        if (OrderStatus::where('title', $request->title)->exists()) {
            return response()->json(['status already exist']);
        }
        $brand = OrderStatus::where('uuid', $uuid)
            ->update([
                'title' => $request->title,

            ]);
        return response()->json(['OrderStatus Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($uuid)
    {
        $brand = OrderStatus::where('uuid', $uuid)->firstOrFail();
        $brand->delete();

        return response()->json('OrderStatus deleted successfully');
    }
}
