<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @php
        $title = trim(strip_tags($title ?? ''));
        $brandName = trim(strip_tags(filament()->getBrandName()));
    @endphp
    <title>
        {{ filled($title) ? "{$title} - " : null }} {{ $brandName }}
    </title>
    <meta name="description" content="Crie sua rádio online com aplicativo exclusivo para iPhone e Android">
    <meta name="keywords" content="criar radio online, webradio, criação de aplicativo para rádio, streaming">
    <meta name="author" content="Elicast">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">


    <meta name="robots" content="index, follow" />


    @filamentStyles
    @stack('styles')
    {{ filament()->getTheme()->getHtml() }}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gradient-to-br from-sky-50 via-slate-50 to-pink-50 text-gray-900 antialiased min-h-screen">

    <!-- Header Principal -->
Header
    <main>
        <section class="max-w-7xl mx-auto px-6 py-12 items-center">
            <div class="space-y-8 text-center">
                {{ $slot }}
            </div>
        </section>
    </main>


    @filamentScripts

    @stack('scripts')
    <script>
        const btnMobile = document.getElementById('btn-mobile');
        const menuMobile = document.getElementById('mobile-menu');

        btnMobile.addEventListener('click', () => {
            menuMobile.classList.toggle('hidden');
        });
    </script>

</body>
</html>