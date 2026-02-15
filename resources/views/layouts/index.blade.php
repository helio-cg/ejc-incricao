<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @if ($favicon = filament()->getFavicon())
            <link rel="icon" href="{{ $favicon }}" />
    @endif
    @php
        $title = trim(strip_tags($livewire?->getTitle() ?? ''));
        $brandName = trim(strip_tags(filament()->getBrandName()));
    @endphp
    <title>
        {{ filled($title) ? "{$title} - " : null }} {{ $brandName }}
    </title>
    <meta name="author" content="Elicast">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow" />
    <meta name="type" content="website" />

    @filamentStyles
    {{ filament()->getTheme()->getHtml() }}
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-900 via-blue-800 to-indigo-700 text-gray-900 antialiased">

    <!-- Header Principal -->
    <main class="mx-auto my-12 max-w-7xl px-4 sm:px-6 lg:px-8 ">
       {{-- <img src="/images/logo.png" alt="Logo ECC" class="mx-auto  w-48"> --}}
        {{ $slot }}
    </main>

    @filamentScripts

    @stack('scripts')

</body>
</html>
