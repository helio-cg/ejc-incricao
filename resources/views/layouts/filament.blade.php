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
<style>
    body {
  min-height: 100vh;
  color: #111827;
  -webkit-font-smoothing: antialiased;
  background-color: #f8fafc;
  background-image:
    radial-gradient(at 20% 30%, rgba(56, 189, 248, 0.20) 0px, transparent 50%),
    radial-gradient(at 80% 70%, rgba(244, 114, 182, 0.20) 0px, transparent 50%),
    radial-gradient(at 50% 100%, rgba(148, 163, 184, 0.15) 0px, transparent 50%),
    linear-gradient(135deg, #f0f9ff 0%, #f8fafc 40%, #fdf2f8 100%);
}
</style>
</head>
<body >

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