<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>

<body class="min-h-screen bg-zinc-100 dark:bg-zinc-900 antialiased">
    <div
        x-data="{ sidebarOpen: window.innerWidth >= 1024 }"
        x-cloak
        class="flex flex-col h-screen bg-white/50 text-zinc-900 dark:bg-zinc-900/50 dark:text-white">
        <x-navbar />
        <div class="flex flex-1 overflow-hidden relative">
            <div
                x-show="sidebarOpen && window.innerWidth < 1024"
                @click="sidebarOpen = false"
                class="fixed inset-0 bg-black/50 z-40 lg:hidden"
                x-transition.opacity>
            </div>
            <x-sidebar />
            <flux:main
                class="flex-1 !p-0 bg-zinc-100 dark:bg-zinc-900 overflow-y-auto scroll-smooth scroll-hide">
                {{ $slot }}
            </flux:main>
        </div>
    </div>
    @fluxScripts
</body>
</html>