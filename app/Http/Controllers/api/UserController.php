<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function favorites(Request $request)
    {
        $courseFavorites = $request->user()->courseFavourite()
            ->with("user", "course", "course.videos", "course.user", "course.sub_course_categories")
            ->get();

        return response()->json($courseFavorites);
    }

    public function transactions(Request $request)
    {
        $courseTransaction = $request->user()->courseTransaction()
            ->with("user", "course", "course.videos", "course.user", "course.sub_course_categories")
            ->get();
        return response()->json($courseTransaction);
    }

    public function checkFavorite(Request $request, $course_id)
    {
        $courseFavorite = $request->user()->courseFavourite()->where('course_id', $course_id)->exists();
        return response()->json(['status' => $courseFavorite]);
    }

    public function addFavorite(Request $request, $course_id)
    {
        $courseFavorite = $request->user()->courseFavourite()->create([
            'course_id' => $course_id,
            'token' => time() + rand(11, 99) - 7325
        ]);
        return response()->json($courseFavorite);
    }

    public function removeFavorite(Request $request, $course_id)
    {
        $courseFavorite = $request->user()->courseFavourite()->where('course_id', $course_id)->delete();
        return response()->json($courseFavorite);
    }

    public function takeCourse(Request $request, $course_id)
    {
        $course = \App\Models\Course::find($course_id);
        if (!$course) return response()->json(['success' => false], 404);

        $course_price = $course->price;

        if ($course_price == 0) {
            $result = $request->user()->courseTransaction()->create([
                'course_id' => $course_id,
                'token' => time() + rand(11, 99) - 7325
            ]);

            return response()->json([
                'message' => 'شما با موفقیت در این دوره شرکت داده شده اید',
                'result' => $result
            ]);
        } else {
            return response()->json([
                'message' => 'شما به صفحه پرداخت هدایت شده اید ',
                'course' => $course
            ]);
        }
    }

    public function checkTakeCourse(Request $request, $course_id)
    {
        $taken = $request->user()->courseTransaction()->where('course_id', $course_id)->exists();
        return response()->json(['status' => $taken]);
    }

    public function editProfile(Request $request)
    {
        $user = User::find($request->user()->id);
        if (Hash::check($request->oldPassword, $user->password)) {
            if ($request->filled('email')) {
                $user->email = $request->email;
            }
            if ($request->filled('m_name')) {
                $user->name = $request->m_name;
            }
            if ($request->filled('newPassword')) {
                $user->password = Hash::make($request->newPassword);
            }
            $user->save();
            return response()->json($user);
        } else {
            return response()->json([
                'message' => "رمزعبور فعلی اشتباه است!"
            ]);
        }
    }
}
