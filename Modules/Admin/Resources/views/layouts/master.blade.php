<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="x-header-spa" content="{{ session('personal-token') }}">
        <title>@yield('title', 'Admin')</title>

       {{-- Laravel Mix - CSS File --}}
        <link rel="stylesheet" href="{{ mix('/vendor/bootstrap/css/bootstrap.css') }}">
    </head>
    <body>
        @yield('content')

        {{-- Laravel Mix - JS File --}}
        <script src="{{ mix('/vendor/bootstrap/js/bootstrap.js') }}"></script>
        <script src="{{ mix('/modules/Admin/js/app.js') }}"></script>
    </body>
</html>
