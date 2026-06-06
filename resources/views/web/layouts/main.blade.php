<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'danialtub') - پلتفرم آموزشی</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        [v-cloak] { display: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">
    <div id="app">
        @include('web.layouts.header')

        <main class="min-h-screen container mx-auto px-4 py-8">
            @yield('content')
        </main>

        @include('web.layouts.footer')
    </div>
</body>
</html>
