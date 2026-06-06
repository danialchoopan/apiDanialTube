@props(['course'])

<div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
    <a href="{{ route('web.courses.show', $course->id) }}" class="block relative aspect-video overflow-hidden">
        <img src="{{ $course->thumbnail }}" alt="{{ $course->name_title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        <div class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
            {{ $course->videos->count() }} قسمت
        </div>
    </a>

    <div class="p-4">
        <h3 class="font-bold text-gray-800 mb-2 line-clamp-1">
            <a href="{{ route('web.courses.show', $course->id) }}" class="hover:text-blue-600 transition">
                {{ $course->name_title }}
            </a>
        </h3>

        <div class="flex items-center gap-2 mb-4">
            <div class="w-6 h-6 bg-gray-200 rounded-full overflow-hidden">
                <!-- Instructor Avatar -->
            </div>
            <span class="text-xs text-gray-500">{{ $course->user->name ?? 'مدرس ناشناس' }}</span>
        </div>

        <div class="flex items-center justify-between border-t pt-4">
            <div class="flex items-center gap-1 text-yellow-500">
                <span class="text-sm font-bold">۴.۸</span>
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
            </div>
            <div class="text-blue-600 font-bold">
                @if($course->price == 0)
                    رایگان
                @else
                    {{ number_format($course->price) }} تومان
                @endif
            </div>
        </div>
    </div>
</div>
