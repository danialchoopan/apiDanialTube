<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $categories = CourseCategory::all();
        $featuredCourses = Course::with('user')->latest()->take(8)->get();

        return view('web.home', compact('sliders', 'categories', 'featuredCourses'));
    }
}
