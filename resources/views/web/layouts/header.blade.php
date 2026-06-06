<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-8">
            <a href="{{ route('web.home') }}" class="text-2xl font-bold text-blue-600">danialtub</a>
            <nav class="hidden md:flex items-center gap-6 text-gray-600">
                <a href="{{ route('web.home') }}" class="hover:text-blue-600 transition">صفحه اصلی</a>
                <a href="#" class="hover:text-blue-600 transition">دوره ها</a>
                <a href="#" class="hover:text-blue-600 transition">دسته‌بندی‌ها</a>
            </nav>
        </div>

        <div class="flex items-center gap-4">
            <div class="relative hidden sm:block">
                <input type="text" placeholder="جستجو در دوره‌ها..." class="bg-gray-100 border-none rounded-lg px-4 py-2 w-64 focus:ring-2 focus:ring-blue-500 transition">
            </div>

            @auth
                <a href="{{ route('web.profile') }}" class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg transition">
                    <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                    <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                </a>
            @else
                <a href="/login" class="text-blue-600 font-medium">ورود / ثبت‌نام</a>
            @endauth
        </div>
    </div>
</header>
