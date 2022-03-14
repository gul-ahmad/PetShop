<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = Category::all();

        return response()->json([CategoryResource::collection($data), 'Category fetched.']);
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
            'title' => 'required|unique:categories',
        ]);

        if (Category::where('title', $request->title)->exists()) {
            return response()->json(['Category already exist']);
        }
        $category = Category::create([
            'slug' => SlugService::createSlug(Category::class, 'slug', $request->title),
            'title' => $request->title,
        ]);

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($uuid)
    {
        return new CategoryResource($uuid);
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
        $brand = Category::where('uuid', $uuid)
            ->update([
                'slug' => SlugService::createSlug(Category::class, 'slug', $request->title),
                'title' => $request->title,

            ]);

        return response()->json(['Category Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($uuid)
    {
        $brand = Category::where('uuid', $uuid)->firstOrFail();
        $brand->delete();

        return response()->json('Category deleted successfully');
    }
}
