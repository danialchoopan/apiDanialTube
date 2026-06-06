@extends('web.layouts.main')

@section('title', 'پنل کاربری')

@section('content')
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar Navigation -->
        <aside class="w-full md:w-72 space-y-4">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 text-center">
                <div class="w-24 h-24 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold">
                    {{ mb_substr($user->name, 0, 1) }}
                </div>
                <h2 class="text-xl font-bold mb-1">{{ $user->name }}</h2>
                <p class="text-gray-400 text-sm mb-6">{{ $user->email }}</p>
                <button class="w-full bg-blue-50 text-blue-600 py-3 rounded-xl font-bold hover:bg-blue-600 hover:text-white transition">ویرایش پروفایل</button>
            </div>

            <nav class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 space-y-1">
                <a href="#" class="flex items-center gap-3 p-4 bg-blue-50 text-blue-600 rounded-2xl font-bold">
                    <span>🏠</span> داشبورد
                </a>
                <a href="#" class="flex items-center gap-3 p-4 text-gray-500 hover:bg-gray-50 rounded-2xl transition">
                    <span>📚</span> دوره‌های من
                </a>
                <a href="#" class="flex items-center gap-3 p-4 text-gray-500 hover:bg-gray-50 rounded-2xl transition">
                    <span>❤️</span> علاقه‌مندی‌ها
                </a>
                <a href="#" class="flex items-center gap-3 p-4 text-gray-500 hover:bg-gray-50 rounded-2xl transition border-t mt-2">
                    <span>🚪</span> خروج
                </a>
            </nav>
        </aside>

        <!-- Dashboard Content -->
        <div class="flex-1 space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="text-gray-400 text-sm mb-2">زمان کل تماشا</div>
                    <div class="text-2xl font-black text-blue-600">{{ $stats['total_watch_time'] }}</div>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="text-gray-400 text-sm mb-2">دوره‌های شرکت شده</div>
                    <div class="text-2xl font-black text-blue-600">{{ $stats['courses_taken'] }} دوره</div>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="text-gray-400 text-sm mb-2">گواهینامه‌ها</div>
                    <div class="text-2xl font-black text-blue-600">{{ $stats['certificates'] }} عدد</div>
                </div>
            </div>

            <!-- Recent Activity / Courses -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b flex items-center justify-between">
                    <h3 class="text-xl font-bold">آخرین فعالیت‌ها</h3>
                    <a href="#" class="text-blue-600 text-sm font-medium">مشاهده همه</a>
                </div>
                <div class="p-8">
                    <div class="space-y-6">
                        @for($i = 0; $i < 3; $i++)
                            <div class="flex items-center gap-6 group">
                                <div class="w-32 h-20 rounded-2xl bg-gray-100 overflow-hidden shrink-0">
                                    <img src="https://picsum.photos/seed/{{ $i+100 }}/320/200" alt="Course" class="w-full h-full object-cover group-hover:scale-105 transition">
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold mb-1">دوره جامع لاراول - بخش مقدماتی</h4>
                                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden mb-2">
                                        <div class="bg-blue-600 h-full w-[65%]"></div>
                                    </div>
                                    <span class="text-xs text-gray-400">۶۵٪ تکمیل شده</span>
                                </div>
                                <button class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold text-sm hover:bg-blue-700 transition">ادامه تماشا</button>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
