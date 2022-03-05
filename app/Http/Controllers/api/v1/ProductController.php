<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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
            'title' => 'required|unique:products',
            'price' => 'required|numeric|min:2',
            'description' => 'required',
            
        ]);
 
         if (Product::where('title', $request->title)->exists()) {
            return response()->json(['Product already exist']);
         }
         $brand=Brand::find($request->brandId)->value('uuid');
         $category1 = Category::find($request->CategoryId)->value('uuid');
        // $file = File::select(['uuid'])->where('id', '=', $request->FildId)->first();
        $file ='asdfjadf43243lkjdf';
        // $data =array('brand'=>$brand,'file' =>$file);
         $new_data = [];
         $new_data["brand"] = $brand;
         $new_data["file"] = $file;
       
        $category = Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'category_uuid' => $category1,
            'meta' => $new_data,
          ]);
    
          return new ProductResource($category);
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
