<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $course_id)
    {
        $comment = $request->user()->comments()->create([
            'comment' => $request->comment,
            'course_id' => $course_id
        ]);
        return response()->json($comment);
    }

    public function destroy(Request $request, $comment_id)
    {
        CourseComment::destroy($comment_id);
        return response()->json(['success' => true]);
    }

    public function show($course_id)
    {
        $comments = Course::find($course_id)->comments()->with('user')->get();
        return response()->json($comments);
    }

    public function showLimited($course_id)
    {
        $comments = Course::find($course_id)->comments()->with('user')->take(4)->get();
        return response()->json($comments);
    }
}
