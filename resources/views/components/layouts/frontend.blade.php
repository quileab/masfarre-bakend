<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Masfarré Sonido e Iluminación</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/bold/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('frontend/js/venobox.min.css') }}">

    @vite(['resources/frontend/css/source.css', 'resources/frontend/js/main.js'])
</head>

<body class="bg-gray-300 dark:bg-gray-900 text-[#1b1b18]">
    {{ $slot }}
    <script src="{{ asset('frontend/js/venobox.min.js') }}"></script>
</body>

</html>