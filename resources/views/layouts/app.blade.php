<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Posyandu') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-app-text bg-app-bg">
        <div class="min-h-screen flex flex-col md:flex-row" x-data="{ mobileSidebarOpen: false }">
            <!-- Sidebar for Desktop & Mobile sliding drawer -->
            <div class="hidden md:flex flex-col w-64 bg-white border-r border-slate-200 min-h-screen sticky top-0">
                <!-- Logo / Header -->
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <span class="text-xl font-bold text-primary flex items-center gap-1.5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            Posyandu
                        </span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 p-4 space-y-1">
                    @include('layouts.app-sidebar-nav')
                </nav>

                <!-- User Profile / Footer -->
                <div class="p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                    <div class="truncate">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500 capitalize truncate">{{ auth()->user()->role }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-600 p-1 rounded-lg transition-colors" title="Keluar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Top Bar -->
            <div class="md:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
                <span class="text-lg font-bold text-primary flex items-center gap-1.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Posyandu
                </span>
                <button @click="mobileSidebarOpen = true" class="text-slate-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>

            <!-- Mobile Sidebar Drawer Backing -->
            <div class="fixed inset-0 bg-slate-900/40 z-50 transition-opacity md:hidden" x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;"></div>

            <!-- Mobile Sidebar Drawer Content -->
            <div class="fixed inset-y-0 left-0 w-64 bg-white z-50 flex flex-col md:hidden transition-transform transform" x-show="mobileSidebarOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" style="display: none;">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <span class="text-lg font-bold text-primary">Menu Posyandu</span>
                    <button @click="mobileSidebarOpen = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                    @include('layouts.app-sidebar-nav')
                </nav>
                <div class="p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                    <div class="truncate">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500 capitalize truncate">{{ auth()->user()->role }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-600 p-1" title="Keluar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Page Heading (Optional) -->
                @isset($header)
                    <header class="bg-white border-b border-slate-200">
                        <div class="max-w-7xl mx-auto py-5 px-6 sm:px-8">
                            <h1 class="text-xl font-semibold text-slate-800 leading-tight">
                                {{ $header }}
                            </h1>
                        </div>
                    </header>
                @endisset

                <!-- Flash Notifications / Alert Box -->
                @if (session('success') || session('error'))
                    <div class="max-w-7xl mx-auto px-6 sm:px-8 mt-4 w-full">
                        @if (session('success'))
                            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3">
                                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-sm font-medium">{{ session('success') }}</span>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl flex items-center gap-3">
                                <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-sm font-medium">{{ session('error') }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Page Content -->
                <main class="flex-1 p-6 sm:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
