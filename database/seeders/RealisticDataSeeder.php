<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Slider;
use App\Models\SubCourseCategory;
use App\Models\ToturialVideo;
use App\Models\User;
use App\Models\CourseTransaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RealisticDataSeeder extends Seeder
{
    public function run()
    {
        // Users (Instructors and Students)
        $instructor = User::updateOrCreate(
            ['email' => 'danial@example.com'],
            [
                'name' => 'دانیال چوپان',
                'password' => Hash::make('password'),
                'role_id' => 1,
            ]
        );

        $student = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'کاربر تست',
                'password' => Hash::make('password'),
                'role_id' => 2,
            ]
        );

        // Categories
        $categories = [
            ['name' => 'برنامه نویسی', 'icon' => 'code'],
            ['name' => 'طراحی گرافیک', 'icon' => 'brush'],
            ['name' => 'زبان‌های خارجه', 'icon' => 'language'],
        ];

        foreach ($categories as $catData) {
            $category = CourseCategory::create([
                'name' => $catData['name'],
                'icon' => $catData['icon'],
            ]);

            // Subcategories
            $subCats = [
                'برنامه نویسی' => ['Laravel', 'React', 'Python'],
                'طراحی گرافیک' => ['Photoshop', 'Figma'],
                'زبان‌های خارجه' => ['English', 'German'],
            ];

            foreach ($subCats[$category->name] as $subName) {
                $subCategory = SubCourseCategory::create([
                    'name' => $subName,
                    'icon' => 'default-icon',
                    'category_id' => $category->id,
                ]);

                // Courses
                for ($i = 1; $i <= 2; $i++) {
                    $course = Course::create([
                        'name_title' => "دوره جامع $subName - قسمت $i",
                        'description' => "در این دوره شما با مفاهیم $subName به صورت پروژه محور آشنا می‌شوید.",
                        'thumbnail' => "https://picsum.photos/seed/" . rand(1, 1000) . "/640/480",
                        'price' => rand(0, 1) ? 0 : rand(100000, 500000),
                        'teacher_id' => $instructor->id,
                        'category_id' => $subCategory->id,
                        'views' => rand(100, 5000),
                        'created_at' => Carbon::now()->subMonths(rand(0, 5))->subDays(rand(0, 28)),
                    ]);

                    // Videos
                    for ($j = 1; $j <= 3; $j++) {
                        ToturialVideo::create([
                            'course_id' => $course->id,
                            'title' => "قسمت $j: شروع کار با $subName",
                            'description' => "توضیحات مربوط به قسمت $j دوره $subName",
                            'thumbnail' => "https://picsum.photos/seed/" . rand(1, 1000) . "/640/480",
                            'video' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                            'length' => '10:00',
                            'views' => rand(50, 1000),
                        ]);
                    }

                    // Transactions for analytics
                    if ($course->price > 0) {
                        for ($k = 0; $k < rand(5, 15); $k++) {
                            CourseTransaction::create([
                                'user_id' => $student->id,
                                'course_id' => $course->id,
                                'token' => 'trans_' . uniqid(),
                                'created_at' => $course->created_at->addDays(rand(1, 30)),
                            ]);
                        }
                    }
                }
            }
        }

        // Sliders
        Slider::create([
            'name' => 'Slider 1',
            'photo' => 'https://picsum.photos/seed/slide1/1200/400',
            'description' => 'Description 1',
            'on_click' => '#',
        ]);
        Slider::create([
            'name' => 'Slider 2',
            'photo' => 'https://picsum.photos/seed/slide2/1200/400',
            'description' => 'Description 2',
            'on_click' => '#',
        ]);
    }
}
