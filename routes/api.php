<?php

use App\Http\Controllers\api\auth\ApiAuthUserController;
use Illuminate\Http\Request;
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


//user auth protected requests

Route::middleware('auth:sanctum')->get('/user', [ApiAuthUserController::class, 'generateValidationCodePhoneNumberSendSMS']);
Route::middleware('auth:sanctum')->get('/user1',function (Request $request){
    return $request->user();
});
Route::middleware('auth:sanctum')->post('/user/phone/code', [ApiAuthUserController::class, 'validationCodePhoneNumberCode']);


//no token requests

Route::post('/auth/register', [ApiAuthUserController::class, 'createUser']);
Route::post('/auth/login', [ApiAuthUserController::class, 'loginUser']);

Route::get('/homeWithNoAuth', function () {
    $homePage = [];
    $homePageSlider = \App\Models\Slider::all();
    $coursesCategory = \App\Models\CourseCategory::all();
    $allCoursesWithTeacherBestSelling = \App\Models\Course::with('videos', 'user')->get();
    $allCoursesWithTeacherMostPopular = \App\Models\Course::with('videos', 'user')->first();
    $allCoursesWithVideosPopular = \App\Models\Course::with('videos', 'user')->get();
    $homePage['homePageSlider'] = $homePageSlider;
    $homePage['coursesCategory'] = $coursesCategory;
    $homePage['allCoursesWithTeacherBestSelling'] = $allCoursesWithTeacherBestSelling;
    $homePage['allCoursesWithTeacherMostPopular'] = $allCoursesWithTeacherMostPopular;
    $homePage['allCoursesWithVideosPopular'] = $allCoursesWithVideosPopular;
    return $homePage;
});
