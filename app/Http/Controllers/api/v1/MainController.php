<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PromotionResource;

use App\Models\Post;
use App\Models\Promotion;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $data = Post::latest()->get();
        return response()->json([PostResource::collection($data), 'Posts fetched.']);
    }

    public function single($uuid)
    {

        return new PostResource(Post::findOrFail($uuid));
    }

    public function promotionIndex()
    {
        return PromotionResource::collection(Promotion::all());
    }
}
