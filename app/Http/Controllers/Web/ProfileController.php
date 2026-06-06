<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        // Mocking some data for the dashboard
        $stats = [
            'total_watch_time' => '۱۲:۳۰:۰۰',
            'courses_taken' => 5,
            'certificates' => 2
        ];
        return view('web.profile', compact('user', 'stats'));
    }
}
