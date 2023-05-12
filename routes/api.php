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
    //user auth end

    //user profile courses

    Route::post('/user/profile/course/favorites', function (Request $request) {
        $courseFavorites = $request->user()->courseFavourite()
            ->with("user", "course", "course.videos", "course.user", "course.sub_course_categories")->get();

        return $courseFavorites;
    });

    Route::post('/user/profile/course/transaction', function (Request $request) {
        $courseTransaction = $request->user()->courseTransaction()
            ->with("user", "course", "course.videos", "course.user", "course.sub_course_categories")->get();
        return $courseTransaction;
    });

    //end user profile courses

    //add favorite course

    Route::post('/user/add/course/favorite/{course_id}', function (Request $request, $course_id) {
        $courseFavorite = $request->user()->courseFavourite()->create([
            'course_id' => $course_id,
            'token' => time()+rand(11,99)-7325
        ]);
        return $courseFavorite;
    });

    //remove favorite course

    Route::post('/user/remove/course/favorite/{course_id}', function (Request $request, $course_id) {
        $courseFavorite = \App\Models\CourseFavourite::where('course_id',$course_id)->delete();
        return $courseFavorite;
    });

    //end favorites course

});


//no token requests

Route::post('/auth/register', [ApiAuthUserController::class, 'createUser']);
Route::post('/auth/login', [ApiAuthUserController::class, 'loginUser']);

//home page

//all
Route::get('/homeWithNoAuth', function () {
    $homePage = [];
    $homePageSlider = \App\Models\Slider::all();
    $coursesCategory = \App\Models\CourseCategory::all();

    $allCoursesWithTeacherBestSelling =
        \App\Models\Course::with('videos', 'user', 'sub_course_categories')
            ->take(4)
            ->get();

    $CoursesWithTeacherMostPopular =
        \App\Models\Course::with('videos', 'user', 'sub_course_categories')
            ->first();

    $allCoursesWithVideosPopular =
        \App\Models\Course::with('videos', 'user', 'sub_course_categories')
            ->take(4)
            ->get();

    $homePage['homePageSlider'] = $homePageSlider;
    $homePage['coursesCategory'] = $coursesCategory;
    $homePage['allCoursesWithTeacherBestSelling'] = $allCoursesWithTeacherBestSelling;
    $homePage['CoursesWithTeacherMostPopular'] = $CoursesWithTeacherMostPopular;
    $homePage['allCoursesWithVideosPopular'] = $allCoursesWithVideosPopular;
    return $homePage;
});

//show more best-selling
Route::get('/homeWithNoAuth/showMoreBestselling', function () {
    $allCoursesWithTeacherBestSelling = \App\Models\Course::with('videos', 'user', 'sub_course_categories')->get();
    return $allCoursesWithTeacherBestSelling;
});

//show more most-populars
Route::get('/homeWithNoAuth/showMoreMostPopulars', function () {
    $allCoursesWithVideosPopular = \App\Models\Course::with('videos', 'user', 'sub_course_categories')->get();
    return $allCoursesWithVideosPopular;
});


//end home page


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

Route::get('/course/search/{courseName}', function (Request $request, $courseName) {
    $courses = \App\Models\Course::where('name_title', 'LIKE', "%$courseName%")
        ->with('videos', 'user', 'sub_course_categories')
        ->get();

    if ($courses) {
        return [
            'success' => true,
            'courseWithVideosUserSearch' => $courses
        ];
    } else {
        return [
            'success' => false
        ];
    }
});


//end course


//category
Route::get('/course/categories', function (Request $request) {
    $categoris = \App\Models\CourseCategory::all();
    if ($categoris) {
        return [
            'courseCategories' => $categoris
        ];
    } else {
        return [
            'success' => false
        ];
    }
});


Route::get('/course/sub/categories/{category_id}', function (Request $request, $category_id) {
    $categoris = \App\Models\CourseCategory::find($category_id)->subCategory()->get();

    if ($categoris) {
        return [
            'subCourseCategories' => $categoris
        ];
    } else {
        return [
            'success' => false
        ];
    }
});

Route::get('/course/sub/category/courses/{sub_category_id}', function (Request $request, $sub_category_id) {
    $subCategoryCourses = \App\Models\SubCourseCategory::find($sub_category_id)->courses()
        ->with('videos', 'user', 'sub_course_categories')
        ->get();

    if ($subCategoryCourses) {
        return [
            'subCourseCategoriesCourses' => $subCategoryCourses
        ];
    } else {
        return [
            'success' => false
        ];
    }
});
//end category
