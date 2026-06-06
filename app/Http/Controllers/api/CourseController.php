<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Slider;
use App\Models\CourseCategory;
use App\Models\SubCourseCategory;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function homeWithNoAuth()
    {
        $homePage = [];
        $homePageSlider = Slider::all();
        $coursesCategory = CourseCategory::all();

        $allCoursesWithTeacherBestSelling = Course::with('videos', 'user', 'sub_course_categories')
            ->take(4)
            ->get();

        $CoursesWithTeacherMostPopular = Course::with('videos', 'user', 'sub_course_categories')
            ->first();

        $allCoursesWithVideosPopular = Course::with('videos', 'user', 'sub_course_categories')
            ->take(4)
            ->get();

        $homePage['homePageSlider'] = $homePageSlider;
        $homePage['coursesCategory'] = $coursesCategory;
        $homePage['allCoursesWithTeacherBestSelling'] = $allCoursesWithTeacherBestSelling;
        $homePage['CoursesWithTeacherMostPopular'] = $CoursesWithTeacherMostPopular;
        $homePage['allCoursesWithVideosPopular'] = $allCoursesWithVideosPopular;

        return response()->json($homePage);
    }

    public function more()
    {
        $moreCoursesRandom = Course::inRandomOrder()->with('user', 'sub_course_categories')
            ->take(4)
            ->get();
        return response()->json($moreCoursesRandom);
    }

    public function showMoreBestselling()
    {
        $allCoursesWithTeacherBestSelling = Course::with('videos', 'user', 'sub_course_categories')->get();
        return response()->json($allCoursesWithTeacherBestSelling);
    }

    public function showMoreMostPopulars()
    {
        $allCoursesWithVideosPopular = Course::with('videos', 'user', 'sub_course_categories')->get();
        return response()->json($allCoursesWithVideosPopular);
    }

    public function moreRelated()
    {
        $coursesMore = Course::with('videos', 'user', 'sub_course_categories')
            ->take(4)
            ->get();
        return response()->json($coursesMore);
    }

    public function show($id)
    {
        $courseShow = Course::with('videos', 'user')->find($id);
        if ($courseShow) {
            return response()->json([
                'success' => true,
                'courseWithVideosUser' => $courseShow
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function search($courseName)
    {
        $courses = Course::where('name_title', 'LIKE', "%$courseName%")
            ->with('videos', 'user', 'sub_course_categories')
            ->get();

        if ($courses) {
            return response()->json([
                'success' => true,
                'courseWithVideosUserSearch' => $courses
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
