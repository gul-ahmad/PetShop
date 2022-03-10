<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as RulesPassword;

class UserController extends Controller
{
    /*  public function forgot() {
        $credentials = request()->validate(['email' => 'required|email']);

        Password::sendResetLink($credentials);

        return $this->respondWithMessage('Reset password link sent on your email id.');
    }
 */

    /* public function reset(ResetPasswordRequest $request) {
        $reset_password_status = Password::reset($request->validated(), function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return $this->respondBadRequest(ApiCode::INVALID_RESET_PASSWORD_TOKEN);
        }

        return $this->respondWithMessage("Password has been successfully changed");
    } */

    public function userOrders()
    {

        $userId = auth()->user()->id;


        $authUserOrders = Order::where('user_id', $userId)->get();
        if (count($authUserOrders)) {

            return response()->json([OrderResource::collection($authUserOrders), 'Orders fetched.']);
        } else {

            return response()->json('No orders found');
        }
    }
}
