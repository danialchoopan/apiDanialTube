<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use App\Models\SubCourseCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::all();
        if ($categories) {
            return response()->json([
                'courseCategories' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function subCategories($category_id)
    {
        $category = CourseCategory::find($category_id);
        if ($category) {
            $categories = $category->subCategory()->get();
            return response()->json([
                'subCourseCategories' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function subCategoryCourses($sub_category_id)
    {
        $subCategory = SubCourseCategory::find($sub_category_id);
        if ($subCategory) {
            $subCategoryCourses = $subCategory->courses()
                ->with('videos', 'user', 'sub_course_categories')
                ->get();
            return response()->json([
                'subCourseCategoriesCourses' => $subCategoryCourses
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
