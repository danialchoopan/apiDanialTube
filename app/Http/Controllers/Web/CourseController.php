<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show($id)
    {
        $course = Course::with(['videos', 'user', 'comments.user'])->findOrFail($id);
        $relatedCourses = Course::where('category_id', $course->category_id)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();

        return view('web.courses.show', compact('course', 'relatedCourses'));
    }
}
