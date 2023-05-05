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


//token protected requests
Route::middleware('auth:sanctum')->get('/test/token', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    //user auth protected requests
    Route::get('/user/phone/send/valid', [ApiAuthUserController::class, 'generateValidationCodePhoneNumberSendSMS']);
    Route::post('/user/phone/code', [ApiAuthUserController::class, 'validationCodePhoneNumberCode']);
    Route::post('/user/phone/check/valid', [ApiAuthUserController::class, 'checkPhoneValidation']);
    Route::post('/auth/logout', [ApiAuthUserController::class, 'logout']);
    //user end


});


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


//course
Route::get('/course/show/{id}', function (Request $request, $id) {
    $courseShow = \App\Models\Course::with('videos', 'user')->find($id);
    if ($courseShow) {
        return [
            'success' => true,
            'courseWithVideosUser' => $courseShow
        ];
    } else {
        return [
            'success' => false
        ];
    }
});
//end course
