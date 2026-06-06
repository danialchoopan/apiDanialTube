<?php

use App\Http\Controllers\api\auth\ApiAuthUserController;
use App\Models\Course;
use App\Models\CourseComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//token protected requests
Route::middleware('auth:sanctum')->get('/test/token', function (Request $request) {
    return $request->user();
});

Route::get("/internet", function () {
    return "ok";
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    //user phone verify requests

    Route::post('/user/phone/send/valid', [ApiAuthUserController::class, 'generateValidationCodePhoneNumberSendSMS']);

    Route::post('/user/phone/code', [ApiAuthUserController::class, 'validationCodePhoneNumberCode']);

    Route::post('/user/phone/check/valid', [ApiAuthUserController::class, 'checkPhoneValidation']);

    Route::post('/auth/logout', [ApiAuthUserController::class, 'logout']);

    //end user phone verify requests

    //user profile courses
    Route::post('/user/profile/course/favorites', [UserController::class, 'favorites']);
    Route::post('/user/profile/course/transaction', [UserController::class, 'transactions']);

    //favorites course
    Route::post('/user/check/course/favorite/{course_id}', [UserController::class, 'checkFavorite']);
    Route::post('/user/add/course/favorite/{course_id}', [UserController::class, 'addFavorite']);
    Route::post('/user/remove/course/favorite/{course_id}', [UserController::class, 'removeFavorite']);

    //take course
    Route::post('/user/take/course/{course_id}', [UserController::class, 'takeCourse']);
    Route::post('/user/check/take/course/{course_id}', [UserController::class, 'checkTakeCourse']);

    //user edit
    Route::post('/user/edit/password/email', [UserController::class, 'editProfile']);

    //user rest password
    Route::post('/user/rest/change/password', [ApiAuthUserController::class, 'userRestPasswordChangePassword']);

    //course comments
    Route::post('/course/add/comments/{course_id}', [CommentController::class, 'store']);
    Route::post('/course/delete/comments/{comment_id}', [CommentController::class, 'destroy']);

    //end course comment


    //course transaction
//    Route::post("take/course",function (Request $request){
//        $order = \App\Models\Order::where('order_product_id', $request->order_id)->get()->first();
//        $order->status = $request->status;
//        $order->save();
//        if($request->status==10){
//            $order = \App\Models\Order::where('order_product_id', $request->order_id)->get()->first();
//            //send user to the payment link
//            $responseIdPay = Http::withHeaders([
//                'X-SANDBOX' => 'true',
//                'Content-Type' => 'application/json',
//                'X-API-KEY' => env('idPayApiKey')
//            ])->post('https://api.idpay.ir/v1.1/payment/verify', [
//                'id' => $order->id_transaction,
//                'order_id' => $order->order_product_id,
//            ]);
//            if ($responseIdPay->successful()) {
//                if($responseIdPay['status']==101){
//                    return
//                        "<h1><center>" .
//                        "پرداخت شما قبلا تایید شده است"
//                        . "</center></h1>";
//                }
//                if ($responseIdPay['status'] == 100) {
//                    $orderNew = \App\Models\Order::where('order_product_id', $request->order_id)->get()->first();
//                    $orderNew->status = 100;
//                    $orderNew->save();
//                    return view('api.status',['status' =>true,'order_number'=>$order->order_product_id]);
//                } else {
//                    return view('api.status',['status' =>false,'order_number'=>'error']);
//                }
//            }else {
//                return view('api.status',['status' =>false,'order_number'=>'error']);
//            }
//        }else {
//            return view('api.status',['status' =>false,'order_number'=>'error']);
//        }
//    });

});

//no token requests
Route::post('/course/comments/4/{course_id}', [CommentController::class, 'showLimited']);
Route::post('/course/comments/{course_id}', [CommentController::class, 'show']);


//transaction_course
Route::get('/transaction_course/{course_id}/{user_id}', function (Request $request, $course_id, $user_id) {
    return [
        'user' => $user_id,
        'course' => $course_id
    ];
});
//user reset request
Route::post('/user/rest/password', [ApiAuthUserController::class, 'userRestPasswordCheckPhone']);

Route::post('/user/rest/password/request/sms', [ApiAuthUserController::class, 'userRestPasswordRequestSms']);

Route::post('/user/rest/password/send/sms', [ApiAuthUserController::class, 'userRestPasswordSendSms']);
//end user reset request


Route::post('/auth/register', [ApiAuthUserController::class, 'createUser']);
Route::post('/auth/login', [ApiAuthUserController::class, 'loginUser']);

use App\Http\Controllers\api\CourseController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\CommentController;

//home page
Route::get('/homeWithNoAuth', [CourseController::class, 'homeWithNoAuth']);
Route::get('/course/more', [CourseController::class, 'more']);
Route::get('/homeWithNoAuth/showMoreBestselling', [CourseController::class, 'showMoreBestselling']);
Route::get('/homeWithNoAuth/showMoreMostPopulars', [CourseController::class, 'showMoreMostPopulars']);
Route::get('/courses/more', [CourseController::class, 'moreRelated']);

//course
Route::get('/course/show/{id}', [CourseController::class, 'show']);
Route::get('/course/search/{courseName}', [CourseController::class, 'search']);

//category
Route::get('/course/categories', [CategoryController::class, 'index']);
Route::get('/course/sub/categories/{category_id}', [CategoryController::class, 'subCategories']);
Route::get('/course/sub/category/courses/{sub_category_id}', [CategoryController::class, 'subCategoryCourses']);



