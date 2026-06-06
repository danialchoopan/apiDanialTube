<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseTransaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalViews = Course::sum('views');
        $totalSales = CourseTransaction::join('courses', 'course_transactions.course_id', '=', 'courses.id')
            ->sum('courses.price');

        $newStudents = User::where('role_id', '!=', 1) // Assuming 1 is admin
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Mocking watch time as we don't have it in DB, but let's base it on views
        $totalWatchTime = $totalViews * 10 / 60; // Assume 10 mins avg per view

        $driver = DB::getDriverName();
        $monthFormat = $driver == 'sqlite' ? "strftime('%m', course_transactions.created_at)" : "DATE_FORMAT(course_transactions.created_at, '%m')";

        $monthlySales = CourseTransaction::select(
            DB::raw('sum(courses.price) as total'),
            DB::raw("$monthFormat as month")
        )
        ->join('courses', 'course_transactions.course_id', '=', 'courses.id')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        return view('vendor.voyager.index', compact(
            'totalViews',
            'totalSales',
            'newStudents',
            'totalWatchTime',
            'monthlySales'
        ));
    }
}
