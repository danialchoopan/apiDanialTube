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

    //check if the course is favorite
    Route::post('/user/check/course/favorite/{course_id}', function (Request $request, $course_id) {
        $courseFavorite = $request->user()->courseFavourite()->where('course_id', $course_id)->get();
        if (count($courseFavorite) != 0) {
            return [
                'status' => true,
            ];
        } else {
            return [
                'status' => false
            ];
        }
    });

    //add favorite course

    Route::post('/user/add/course/favorite/{course_id}', function (Request $request, $course_id) {
        $courseFavorite = $request->user()->courseFavourite()->create([
            'course_id' => $course_id,
            'token' => time() + rand(11, 99) - 7325
        ]);
        return $courseFavorite;
    });

    //remove favorite course

    Route::post('/user/remove/course/favorite/{course_id}', function (Request $request, $course_id) {
        $courseFavorite = $request->user()->courseFavourite()->where('course_id', $course_id)->delete();
        return $courseFavorite;
    });


    //end favorites course

    //add user course
    Route::post('/user/take/course/{course_id}', function (Request $request, $course_id) {
        $course = \App\Models\Course::find($course_id);
        $course_price = $course->price;

        if ($course_price == 0) {

            $result=$request->user()->courseTransaction()->create([
                'course_id' => $course_id,
                'token' => time() + rand(11, 99) - 7325
            ]);

            return [
                'message' => 'شما با موفقیت در این دوره شرکت داده شده اید',
                'result'=>$result
            ];
        }else{

            return [
                'message' => 'شما به صفحه پرداخت هدایت شده اید ',
                'course' => $course
            ];
        }

    });

    //check if the user taken the course
    Route::post('/user/check/take/course/{course_id}', function (Request $request, $course_id) {
        $courseFavorite = $request->user()->courseTransaction()->where('course_id', $course_id)->get();
        if (count($courseFavorite) != 0) {
            return [
                'status' => true,
            ];
        } else {
            return [
                'status' => false
            ];
        }
    });

    //user edit
    Route::post('/user/edit/password/email', function (Request $request) {

        $user = User::find($request->user()->id);
        if ($user->password == Hash::check($request->oldPassword, $user->password)) {
            if ($request->email != "") {
                $user->email = $request->email;
            }
            if ($request->name != "") {
                $user->name = $request->m_name;
            }
            $user->password = Hash::make($request->newPassword);
            $user->save();
            return $user;
        } else {
            return [
                'message' => "رمزعبور فعلی اشتباه است!"
            ];
        }

    });
    //end user edit

    //user rest password
    Route::post('/user/rest/change/password', [ApiAuthUserController::class, 'userRestPasswordChangePassword']);

    //course comments

    //show 3-4
    Route::post('/course/comments/4/{course_id}',function (Request $request,$course_id){
        return Course::find($course_id)->comments()->with('user')->take(4)->get();
    });

    //show all
    Route::post('/course/comments/{course_id}',function (Request $request,$course_id){
        return Course::find($course_id)->comments()->with('user')->get();
    });

    //add
    Route::post('/course/add/comments/{course_id}',function (Request $request,$course_id){
        $request->user()->comments()->create([
            'comment'=>$request->comment,
            'course_id'=>$course_id
        ]);
    });

    //delete
    Route::post('/course/delete/comments/{comment_id}',function (Request $request,$comment_id){
       CourseComment::destroy($comment_id);
    });

    //end course comment

});

//no token requests

//user reset request
Route::post('/user/rest/password', [ApiAuthUserController::class, 'userRestPasswordCheckPhone']);

Route::post('/user/rest/password/request/sms', [ApiAuthUserController::class, 'userRestPasswordRequestSms']);

Route::post('/user/rest/password/send/sms', [ApiAuthUserController::class, 'userRestPasswordSendSms']);
//end user reset request


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

//more courses random
Route::get('/course/more',function (Request $request){
    $moreCoursesRandom=Course::inRandomOrder()->with( 'user', 'sub_course_categories')
        ->take(4)
        ->get();
    return $moreCoursesRandom;
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

//show related
Route::get('/courses/more', function () {
    $coursesMore =
        \App\Models\Course::with('videos', 'user', 'sub_course_categories')
            ->take(4)
            ->get();
    return $coursesMore;
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



