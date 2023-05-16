<?php

namespace App\Http\Controllers\api\auth;

use App\Models\PhoneVerifiey;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'user' => $user,
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
                    'emailOrPhone' => 'required',
                    'password' => 'required'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //login with phone number or email
            if (!Auth::attempt(['phone_number'=>$request->emailOrPhone,'password'=>$request->password])) {
                if (!Auth::attempt(['email'=>$request->emailOrPhone,'password'=>$request->password])) {
                    return response()->json([
                        'status' => false,
                        'message' => 'نام کاربری یا رمزعبور اشتباه است',
                    ], 401);
                }
            }

            $user = User::where('phone_number', $request->emailOrPhone)->first();
            if (!$user) {
                $user = User::where('email', $request->emailOrPhone)->first();
            }

            return response()->json([
                'status' => true,
                'user' => $user,
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

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            'tokens'=>$request->user()->tokens()->delete(),
            'message '=> 'شما با موفقیت از حساب کاربری خارج شده اید '
        ];
    }

    //phone validation

    public function validationCodePhoneNumberCode(Request $request)
    {
        $user = $request->user();
        $code = $request->code;

        $resultPhone = PhoneVerifiey::where('token', $code)->first();
        if ($resultPhone) {
            if ($resultPhone->expire_time > time()) {
                $user->phone_verified_at =
                    Carbon::createFromTimestamp(time())->format('Y-m-d H:i:s');
                $user->save();
                PhoneVerifiey::destroy(
                    PhoneVerifiey::where('token', $code)->first()->id);
                return response()->json([
                    'status' => true,
                    'message' => "شماره شما با موفقیت تایید شد ",
                ]);


            } else {
                return response()->json([
                    'status' => false,
                    'message' => "کد وارد شده منقضی شده است   ",
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "کد وارد شده اشتباه است  ",
            ]);
        }


    }

    public function checkPhoneValidation(Request $request)
    {
        $user = $request->user();
        $result = PhoneVerifiey::where('user_id', $user->id)->first();
        if ($user->phone_verified_at) {
            return response()->json([
                'status' => true,
            ]);
        }else{
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function generateValidationCodePhoneNumberSendSMS(Request $request)
    {
        $user = $request->user();
        $result = PhoneVerifiey::where('user_id', $user->id)->first();
        if (!$user->phone_verified_at) {
            if ($result) {
                if ($result->expire_time > time()) {
                    return response()->json([
                        'status' => false,
                        'message' => "کد قبلا برای شما فرستاده شده است "
                    ]);
                } else {
                    //delete the previews code from the database
                    PhoneVerifiey::destroy($result->id);
                    //code expired send it again
                    $result_sms = $this->sendingValidationSMSCode($user);

                    return response()->json([
                        'status' => true,
                        'message' => "کد برای شما ارسال شد ",
                        'sms' => $result_sms
                    ]);
                }
            } else {
                //send the code for the first time is not in the database
                $result_sms = $this->sendingValidationSMSCode($user);

                return response()->json([
                    'status' => true,
                    'message' => "کد برای شما ارسال شد ",
                    'sms' => $result_sms
                ]);
            }
        } else {
            return response()->json([
                'status' => true,
                'message' => "این شماره قبلا تایید شده است  ",
                'sms'=>""

            ]);
        }
    }

    private function sendingValidationSMSCode($user)
    {

        $validation_code = rand(111111, 999999);
        //add to the table for validation


        $message = "code:$validation_code" . "\n" . "کد تایید ارسال شده شما تا 5 دقیقه معتبر است \n دانیال تیوب";

        //using sms.ir as sms api
        /*
                $responseApiToken=Http::asForm()->withHeaders([
                    'Content-Type'=>'application/x-www-form-urlencoded'
                ])->post(env('SMS_IR_GET_TOKEN_SMS_URL'),[
                        'UserApiKey'=>env('SMS_IR_USER_API_KEY'),
                    'SecretKey'=>env('SMS_IR_KEY'),
                ]);

                if($responseApiToken->successful()){
                    $response=Http::asForm()->withHeaders([
                        'Content-Type'=>'application/x-www-form-urlencoded',
                        'x-sms-ir-secure-token'=>$responseApiToken['TokenKey'],
                    ])->post(env('SMS_IR_SEND_SMS_URL'),[
                        'Messages'=>$message,
                        'MobileNumbers'=>"09216059177",
                        'LineNumber'=>'30006822885772',
                        'SendDateTime'=>'',
                    ]);
                    return $response;
                }
        */

        $responseApiToken = $user->phone_validation()->create([
            'token' => $validation_code,
            'start_time' => time(),
            'expire_time' => strtotime("+2 minutes")
        ]);


        return $responseApiToken;
    }
}
