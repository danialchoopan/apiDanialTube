@extends('web.layouts.main')

@section('title', 'خانه')

@section('content')
    <!-- Hero Slider Placeholder -->
    <section class="mb-12 rounded-2xl overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 h-[400px] relative flex items-center px-12 text-white">
        <div class="max-w-xl z-10">
            <h1 class="text-4xl font-black mb-6 leading-tight">پلتفرم جامع آموزش و اشتراک ویدیو دانیال‌توب</h1>
            <p class="text-lg opacity-90 mb-8 leading-relaxed">
                مهارت‌های جدید را از برترین اساتید یاد بگیرید. دسترسی به صدها دوره آموزشی تخصصی در زمینه‌های مختلف.
            </p>
            <div class="flex gap-4">
                <a href="#" class="bg-white text-blue-600 px-8 py-3 rounded-xl font-bold hover:bg-opacity-90 transition">شروع یادگیری</a>
                <a href="#" class="bg-white/20 backdrop-blur-sm px-8 py-3 rounded-xl font-bold hover:bg-white/30 transition">مشاهده دوره‌ها</a>
            </div>
        </div>
        <!-- Decorative images would go here -->
    </section>

    <!-- Categories -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold">دسته‌بندی‌های برتر</h2>
            <a href="#" class="text-blue-600 font-medium">مشاهده همه</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            @foreach($categories as $category)
                <a href="#" class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition text-center group">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <!-- Icon Placeholder -->
                        <span class="text-xl">🎓</span>
                    </div>
                    <span class="font-bold text-gray-700">{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Latest Courses -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold">آخرین دوره‌های منتشر شده</h2>
            <a href="#" class="text-blue-600 font-medium">مشاهده همه</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($featuredCourses as $course)
                <x-web.video-card :course="$course" />
            @endforeach
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white rounded-3xl p-12 shadow-sm border border-gray-100 flex flex-wrap justify-around gap-8 text-center">
        <div>
            <div class="text-3xl font-black text-blue-600 mb-2">+۱۰,۰۰۰</div>
            <div class="text-gray-500">دانشجوی فعال</div>
        </div>
        <div>
            <div class="text-3xl font-black text-blue-600 mb-2">+۵۰۰</div>
            <div class="text-gray-500">دوره آموزشی</div>
        </div>
        <div>
            <div class="text-3xl font-black text-blue-600 mb-2">+۱۵۰</div>
            <div class="text-gray-500">استاد متخصص</div>
        </div>
        <div>
            <div class="text-3xl font-black text-blue-600 mb-2">+۵۰,۰۰۰</div>
            <div class="text-gray-500">ساعت ویدیو</div>
        </div>
    </section>
@endsection
