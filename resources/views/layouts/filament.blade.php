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
  background-color: #C5C5C5;
  background-image:
    radial-gradient(at 20% 30%, rgba(253, 213, 253, 0.2) 0px, transparent 50%),
    radial-gradient(at 80% 70%, rgba(244, 168, 114, 0.2) 0px, transparent 50%),
    radial-gradient(at 50% 100%, rgba(148, 156, 184, 0.15) 0px, transparent 50%),
    linear-gradient(135deg, #FFFFFF 0%, #F7F9FA 40%, #FFFFFF 100%);
}
</style>
</head>
<body >

    <!-- Header Principal -->
    <header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">

        <!-- ESQUERDA - LOGO -->
        <div class="flex items-center">
            {{--<img src="logo.png" alt="Logo" class="h-10 w-auto">--}}
            <span class="text-xl font-bold text-gray-600">EJC - 2026</span>
        </div>

        <!-- CENTRO - LINKS -->
        <nav class="hidden md:flex space-x-6 font-medium">
            <a href="{{ route('filament.admin.pages.dashboard') }}" class="text-gray-700 hover:text-blue-600">Home</a>
            <a href="{{ route('filament.admin.resources.users.index') }}" class="text-gray-700 hover:text-blue-600">Inscrições</a>
            <a href="{{ route('filament.admin.resources.users.create') }}" class="text-gray-700 hover:text-blue-600">Cadastrar Novo</a>
        </nav>

        <!-- DIREITA - USUÁRIO -->
        <div class="flex items-center space-x-3">
            @auth
            <span class="text-gray-700 font-semibold">Olá, {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('filament.admin.auth.logout') }}">
                @csrf
                <button type="submit" class="text-gray-700 hover:text-blue-600">Sair</button>
            </form>
            @else
            <a href="{{ route('filament.admin.auth.login') }}" class="text-gray-700 hover:text-blue-600">Entrar</a>
            @endauth
            {{--<img src="https://i.pravatar.cc/40" class="h-8 w-8 rounded-full" />--}}
        </div>

        </div>
    </div>
    </header>

    <main>
        <section class="max-w-7xl mx-auto px-6 py-12 ">
            <div class="space-y-8 ">
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