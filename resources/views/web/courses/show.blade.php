@extends('web.layouts.main')

@section('title', $course->name_title)

@section('content')
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content (Player & Info) -->
        <div class="flex-1">
            <!-- Custom Video Player -->
            <div class="bg-black rounded-3xl overflow-hidden shadow-2xl mb-8 aspect-video relative group select-none" id="video-container">
                <video id="main-player" class="w-full h-full cursor-pointer" poster="{{ $course->thumbnail }}">
                    <source src="{{ $course->videos->first()->video ?? '' }}" type="video/mp4">
                    مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                </video>

                <!-- Custom Controls Overlay -->
                <div id="video-controls" class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-2 group-hover:translate-y-0">
                    <!-- Progress Bar -->
                    <div class="relative w-full h-1.5 bg-white/20 rounded-full mb-4 cursor-pointer overflow-hidden" id="progress-container">
                        <div id="progress-bar" class="absolute top-0 left-0 h-full bg-blue-500 w-0 transition-all duration-100"></div>
                    </div>

                    <div class="flex items-center justify-between gap-4 text-white">
                        <div class="flex items-center gap-6">
                            <!-- Play/Pause -->
                            <button id="play-pause" class="hover:scale-110 transition active:scale-95 text-2xl">
                                <span id="play-icon">▶️</span>
                            </button>

                            <!-- Volume -->
                            <div class="flex items-center gap-3 group/volume">
                                <button id="mute-toggle" class="text-xl">🔊</button>
                                <input type="range" id="volume-slider" min="0" max="1" step="0.1" value="1" class="w-20 h-1 bg-white/20 rounded-full appearance-none cursor-pointer accent-blue-500">
                            </div>

                            <!-- Time -->
                            <div class="text-sm font-mono tracking-wider">
                                <span id="current-time">00:00</span>
                                <span class="mx-1 opacity-50">/</span>
                                <span id="duration">00:00</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <!-- Settings/Speed -->
                            <select id="playback-speed" class="bg-transparent border-none text-sm focus:ring-0 cursor-pointer">
                                <option value="0.5" class="bg-gray-900">0.5x</option>
                                <option value="1" class="bg-gray-900" selected>1x</option>
                                <option value="1.5" class="bg-gray-900">1.5x</option>
                                <option value="2" class="bg-gray-900">2x</option>
                            </select>

                            <!-- Fullscreen -->
                            <button id="fullscreen-toggle" class="hover:scale-110 transition text-xl">⛶</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Info -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
                <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
                    <div>
                        <h1 class="text-3xl font-black mb-4">{{ $course->name_title }}</h1>
                        <div class="flex items-center gap-6 text-sm text-gray-500">
                            <span class="flex items-center gap-2">
                                <span class="text-blue-600">👤</span>
                                مدرس: {{ $course->user->name }}
                            </span>
                            <span class="flex items-center gap-2">
                                <span class="text-blue-600">📅</span>
                                آخرین بروزرسانی: {{ $course->updated_at->diffForHumans() }}
                            </span>
                            <span class="flex items-center gap-2">
                                <span class="text-blue-600">👁️</span>
                                {{ number_format($course->views) }} بازدید
                            </span>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button class="bg-gray-100 hover:bg-gray-200 p-3 rounded-2xl transition">❤️</button>
                        <button class="bg-gray-100 hover:bg-gray-200 p-3 rounded-2xl transition">🔗</button>
                    </div>
                </div>

                <div class="prose prose-blue max-w-none text-gray-600 leading-loose">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">توضیحات دوره</h3>
                    <p>{{ $course->description }}</p>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold mb-8">نظرات و پرسش‌ها ({{ $course->comments->count() }})</h3>

                @auth
                    <form action="#" class="mb-10">
                        <textarea placeholder="دیدگاه خود را بنویسید..." class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 transition mb-4 h-32"></textarea>
                        <button class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition">ارسال نظر</button>
                    </form>
                @else
                    <div class="bg-blue-50 text-blue-700 p-6 rounded-2xl text-center mb-10 font-medium">
                        برای ثبت نظر ابتدا باید <a href="/login" class="underline font-bold">وارد حساب کاربری</a> خود شوید.
                    </div>
                @endauth

                <div class="space-y-8">
                    @foreach($course->comments as $comment)
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center shrink-0 font-bold">
                                {{ mb_substr($comment->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1 bg-gray-50 p-6 rounded-3xl">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-gray-900">{{ $comment->user->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-600 leading-relaxed">{{ $comment->comment }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar (Playlist & Related) -->
        <div class="w-full lg:w-96 space-y-8">
            <!-- Playlist -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b bg-gray-50">
                    <h3 class="font-bold flex items-center gap-2">
                        <span class="text-blue-600">📋</span>
                        سرفصل‌های دوره
                    </h3>
                </div>
                <div class="max-h-[500px] overflow-y-auto">
                    @foreach($course->videos as $index => $video)
                        <div class="p-4 flex items-center gap-4 hover:bg-blue-50 transition cursor-pointer group {{ $index === 0 ? 'bg-blue-50' : '' }}">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold {{ $index === 0 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-400 group-hover:bg-blue-100 group-hover:text-blue-600' }}">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold line-clamp-1 {{ $index === 0 ? 'text-blue-900' : 'text-gray-700' }}">{{ $video->title }}</h4>
                                <span class="text-xs text-gray-400">{{ $video->length }} دقیقه</span>
                            </div>
                            @if($index === 0)
                                <span class="text-blue-600">▶️</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Related Courses -->
            <div class="space-y-4">
                <h3 class="font-bold text-lg px-2">دوره‌های پیشنهادی</h3>
                @foreach($relatedCourses as $related)
                    <a href="{{ route('web.courses.show', $related->id) }}" class="flex gap-4 bg-white p-3 rounded-2xl border border-transparent hover:border-blue-100 hover:shadow-sm transition group">
                        <div class="w-24 h-16 rounded-xl overflow-hidden shrink-0">
                            <img src="{{ $related->thumbnail }}" alt="{{ $related->name_title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-800 line-clamp-1 mb-1">{{ $related->name_title }}</h4>
                            <span class="text-xs text-gray-400">{{ $related->user->name }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const video = document.getElementById('main-player');
            const playPauseBtn = document.getElementById('play-pause');
            const playIcon = document.getElementById('play-icon');
            const progressBar = document.getElementById('progress-bar');
            const progressContainer = document.getElementById('progress-container');
            const currentTimeEl = document.getElementById('current-time');
            const durationEl = document.getElementById('duration');
            const volumeSlider = document.getElementById('volume-slider');
            const muteToggle = document.getElementById('mute-toggle');
            const fullscreenToggle = document.getElementById('fullscreen-toggle');
            const videoContainer = document.getElementById('video-container');
            const speedSelect = document.getElementById('playback-speed');

            // Play/Pause
            function togglePlay() {
                if (video.paused) {
                    video.play();
                    playIcon.textContent = '⏸️';
                } else {
                    video.pause();
                    playIcon.textContent = '▶️';
                }
            }

            playPauseBtn.addEventListener('click', togglePlay);
            video.addEventListener('click', togglePlay);

            // Progress Bar
            video.addEventListener('timeupdate', () => {
                const percent = (video.currentTime / video.duration) * 100;
                progressBar.style.width = `${percent}%`;

                currentTimeEl.textContent = formatTime(video.currentTime);
            });

            video.addEventListener('loadedmetadata', () => {
                durationEl.textContent = formatTime(video.duration);
            });

            progressContainer.addEventListener('click', (e) => {
                const rect = progressContainer.getBoundingClientRect();
                const pos = (e.clientX - rect.left) / rect.width;
                video.currentTime = pos * video.duration;
            });

            // Volume
            volumeSlider.addEventListener('input', (e) => {
                video.volume = e.target.value;
                muteToggle.textContent = video.volume === 0 ? '🔇' : '🔊';
            });

            muteToggle.addEventListener('click', () => {
                if (video.volume > 0) {
                    video.dataset.lastVolume = video.volume;
                    video.volume = 0;
                    volumeSlider.value = 0;
                    muteToggle.textContent = '🔇';
                } else {
                    video.volume = video.dataset.lastVolume || 1;
                    volumeSlider.value = video.volume;
                    muteToggle.textContent = '🔊';
                }
            });

            // Fullscreen
            fullscreenToggle.addEventListener('click', () => {
                if (!document.fullscreenElement) {
                    videoContainer.requestFullscreen();
                } else {
                    document.exitFullscreen();
                }
            });

            // Speed
            speedSelect.addEventListener('change', (e) => {
                video.playbackRate = parseFloat(e.target.value);
            });

            function formatTime(time) {
                const minutes = Math.floor(time / 60);
                const seconds = Math.floor(time % 60);
                return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        });
    </script>
@endsection
