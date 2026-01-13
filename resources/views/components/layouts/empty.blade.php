<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200"
    style="background-image: url('images/background.webp'); background-size: cover; background-position: center; background-attachment: fixed;">

    {{-- STARTS --}}
    <div id="particles-js" class="fixed inset-0 z-0 pointer-events-none"></div>

    <div class="relative grid min-h-screen place-content-center">
        <div class="mb-8 text-center">
            <img src="images/logo-transp.png" class="w-1/3 mx-auto">
        </div>

        {{ $slot }}
    </div>

</html>