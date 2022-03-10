<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Brand::all();

        return response()->json([BrandResource::collection($data), 'Brands fetched.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $brand = Brand::create([
            'slug' => SlugService::createSlug(Brand::class, 'slug', $request->title),
            'title' => $request->title,
        ]);

        return new BrandResource($brand);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        return new BrandResource($uuid);
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
        $brand = Brand::where('uuid', $uuid)
            ->update([
                'slug' => SlugService::createSlug(Brand::class, 'slug', $request->title),
                'title' => $request->title,
            ]);
        return response()->json(['Brand Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $brand = Brand::where('uuid', $uuid)->firstOrFail();
        $brand->delete();

        return response()->json('Brand deleted successfully');
    }
}
