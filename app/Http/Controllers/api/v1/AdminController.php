<?php

namespace App\Http\Controllers\api\v1;

use App\Core\HelperFunction;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
//use Validator;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class AdminController extends Controller
{
    public function index()
    {
        $data = User::where('is_admin', '!=', 1)->get();

        return response()->json([UserResource::collection($data), 'Users fetched.']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse 
     */
    public function edit(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string',
        ]);

        if ($validator->fails()) {

            return response()->json($validator->errors());
        }
        $adminCheck = User::select('is_admin')
            ->where('uuid', '=', $request->uuid)
            ->first();

        if ($adminCheck->is_admin == 1) {

            return response()->json('You are not allowed.');
        } else {
            User::where('uuid', $request->uuid)
                ->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address' => $request->address,
                    'phone_number' => $request->phone_number,
                ]);
            return response()->json(['User Updated Successfully', new UserResource($user)]);
        }
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {

            return response()->json($validator->errors());
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'is_admin' => 1,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'is_marketing' => $request->is_marketing,

        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {

            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi Admin ' . $user->first_name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }


    public function destroy($uuid)
    {
        $adminCheck = User::select('is_admin')
            ->where('uuid', '=', $uuid)
            ->first();

        if ($adminCheck->is_admin == 1) {

            return response()->json('You cannot delete a user with admin account.');
        } else {

            $user = User::where('uuid', $uuid)->firstOrFail();
            $user->delete();

            return response()->json('User deleted successfully');
        }
    }
}
