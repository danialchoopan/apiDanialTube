<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function videos()
    {
        return $this->hasMany(ToturialVideo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }

    public function sub_course_categories()
    {
        return $this->belongsTo(SubCourseCategory::class,'category_id');
    }

    public function comments()
    {
        return $this->hasMany(CourseComment::class,'course_id');
    }

}
