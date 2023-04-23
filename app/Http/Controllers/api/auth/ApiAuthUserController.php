<?php

namespace App\Http\Controllers\api\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthUserController extends Controller
{

    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'phone_number' => 'required|unique:users,phone_number',
                    'password' => 'required'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'مشکلی پیش آمده است لطفا فیلد های وارد شده راه برسی کنید و دوباره سعی کنید ',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //saving user to the database
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'کاربر با موفقیت نام نویسی شد',
                'token' => $user->createToken("userApiToken")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function loginUser(Request $request)
    {
        try {

            //validate
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'email',
                    'password' => 'required'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //login with phone number or email
            if (!Auth::attempt($request->only(['phone_number', 'password']))) {
                if (!Auth::attempt($request->only(['email', 'password']))) {
                    return response()->json([
                        'status' => false,
                        'message' => 'نام کاربری یا رمزعبور اشتباه است',
                    ], 401);
                }
            }

            $user = User::where('phone_number', $request->phone_number)->first();
            if (!$user) {
                $user = User::where('email', $request->email)->first();
            }

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("userApiToken")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
