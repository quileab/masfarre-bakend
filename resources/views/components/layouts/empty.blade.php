<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased
    flex flex-col align-center justify-center h-screen"
    style="background-image: url('assets/images/background.webp'); background-size: cover; background-position: center; background-attachment: fixed;">
    <x-main>
        <x-slot:content>
            <div class="mx-auto w-72 bg-slate-800/60 backdrop-blur-md rounded-lg shadow-md p-4">
                <div class="my-4 text-center">
                    {{-- logo --}}
                    <img src="assets/images/logo-transp.png" class="w-1/3 mx-auto">
                </div>
                {{ $slot }}
            </div>
        </x-slot:content>
    </x-main>
</body>

</html>