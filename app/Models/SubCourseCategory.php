<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCourseCategory extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(CourseCategory::class);
    }

    public function courses(){
        return $this->hasMany(Course::class,"category_id");
    }
}
