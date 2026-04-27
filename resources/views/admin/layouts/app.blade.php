<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Web')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="admin-wrapper">
        @include('admin.partials.sidebar')

        <div class="admin-main">
            @include('admin.partials.header')

            <div class="admin-content">
                <div class="p-2">
                    @yield('content')
                </div>
            </div>

            @include('admin.partials.footer')
        </div>
    </div>

    @yield('scripts')
</body>

</html>