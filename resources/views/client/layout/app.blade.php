<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Shop')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('client.partials.header')
    
    @include('client.partials.navbar')

    <div class="container mt-3">
        @yield('content')
    </div>

    @include('client.partials.footer')
</body>
</html>