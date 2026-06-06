@extends('web.layouts.main')

@section('title', 'خانه')

@section('content')
    <!-- Hero Slider -->
    <section class="mb-12 relative overflow-hidden rounded-3xl group">
        <div class="flex transition-transform duration-500 ease-in-out" id="slider-container">
            @forelse($sliders as $slider)
                <div class="min-w-full relative h-[450px]">
                    <img src="{{ $slider->photo }}" alt="{{ $slider->name }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent flex items-center px-12 text-white">
                        <div class="max-w-xl">
                            <h1 class="text-5xl font-black mb-6 leading-tight">{{ $slider->name }}</h1>
                            <p class="text-xl opacity-90 mb-8 leading-relaxed">
                                {{ $slider->description }}
                            </p>
                            <div class="flex gap-4">
                                <a href="{{ $slider->on_click }}" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-600/20">مشاهده جزئیات</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="min-w-full rounded-2xl overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 h-[400px] relative flex items-center px-12 text-white">
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
                </div>
            @endforelse
        </div>

        @if($sliders->count() > 1)
            <button onclick="moveSlider(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 backdrop-blur-md p-3 rounded-full text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <button onclick="moveSlider(1)" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 backdrop-blur-md p-3 rounded-full text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </button>
        @endif
    </section>

    @push('scripts')
    <script>
        let currentSlide = 0;
        const totalSlides = {{ $sliders->count() }};
        const container = document.getElementById('slider-container');

        function moveSlider(direction) {
            currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
            container.style.transform = `translateX(${currentSlide * 100}%)`;
        }

        if (totalSlides > 1) {
            setInterval(() => moveSlider(1), 5000);
        }
    </script>
    @endpush

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
