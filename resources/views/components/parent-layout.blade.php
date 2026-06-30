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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans antialiased text-app-text bg-app-bg pb-20 md:pb-0">
        <div class="min-h-screen flex flex-col md:flex-row">
            
            <!-- Desktop Sidebar Navigation (hidden on Mobile) -->
            <div class="hidden md:flex flex-col w-64 bg-white border-r border-slate-200 min-h-screen sticky top-0">
                <!-- Header / Logo -->
                <div class="p-6 border-b border-slate-100 flex items-center gap-2">
                    <span class="text-xl font-bold text-primary flex items-center gap-1.5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Posyandu
                    </span>
                </div>

                <!-- Nav links -->
                <nav class="flex-1 p-4 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Beranda Keluarga
                    </a>
                    
                    <a href="{{ route('schedules.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('schedules.*') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Jadwal Posyandu
                    </a>

                    <a href="{{ route('articles.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('articles.*') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        Artikel Edukasi
                    </a>

                    <a href="{{ route('galleries.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('galleries.*') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Galeri Kegiatan
                    </a>
                </nav>

                <!-- Profile Footer -->
                <div class="p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                    <div class="truncate">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate">Keluarga</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-600 p-1" title="Keluar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Top Bar Header -->
            <div class="md:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
                <span class="text-lg font-bold text-primary flex items-center gap-1.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Posyandu
                </span>
                <span class="text-xs text-slate-500 font-medium bg-slate-100 px-2.5 py-1 rounded-full capitalize">
                    Orang Tua
                </span>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Page Heading (Optional) -->
                @isset($header)
                    <header class="bg-white border-b border-slate-200">
                        <div class="max-w-7xl mx-auto py-5 px-6 sm:px-8">
                            <h1 class="text-xl font-bold text-slate-800 leading-tight">
                                {{ $header }}
                            </h1>
                        </div>
                    </header>
                @endisset

                <!-- SweetAlert Notifications & Confirms -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Global Delete Confirmations
                        const confirmForms = document.querySelectorAll('form[onsubmit*="confirm("]');
                        confirmForms.forEach(form => {
                            const onsubmitAttr = form.getAttribute('onsubmit');
                            let message = "Apakah Anda yakin?";
                            const match = onsubmitAttr.match(/confirm\(['"](.*)['"]\)/);
                            if (match && match[1]) {
                                message = match[1];
                            }
                            
                            // Remove the inline handler
                            form.removeAttribute('onsubmit');
                            
                            // Handle submit event
                            form.addEventListener('submit', function (e) {
                                e.preventDefault();
                                Swal.fire({
                                    title: 'Konfirmasi Hapus',
                                    text: message,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#ef4444',
                                    cancelButtonColor: '#64748b',
                                    confirmButtonText: 'Ya, Hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        this.submit();
                                    }
                                });
                            });
                        });

                        // Flash Success
                        @if (session('success'))
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: "{{ session('success') }}",
                                confirmButtonColor: '#2563eb',
                            });
                        @endif

                        // Flash Error
                        @if (session('error'))
                            Swal.fire({
                                icon: 'error',
                                title: 'Kesalahan',
                                text: "{{ session('error') }}",
                                confirmButtonColor: '#2563eb',
                            });
                        @endif
                    });
                </script>

                <!-- Page Content -->
                <main class="flex-1 p-5 sm:p-8 w-full max-w-7xl mx-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Mobile Bottom Navigation Bar (fixed bottom-0) -->
        <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 h-16 flex items-center justify-around z-40 px-2 shadow-lg">
            <!-- Beranda -->
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center flex-1 text-center py-2 transition-colors {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px] font-medium mt-1">Beranda</span>
            </a>

            <!-- Jadwal -->
            <a href="{{ route('schedules.index') }}" class="flex flex-col items-center justify-center flex-1 text-center py-2 transition-colors {{ request()->routeIs('schedules.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="text-[10px] font-medium mt-1">Jadwal</span>
            </a>

            <!-- Artikel -->
            <a href="{{ route('articles.index') }}" class="flex flex-col items-center justify-center flex-1 text-center py-2 transition-colors {{ request()->routeIs('articles.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <span class="text-[10px] font-medium mt-1">Artikel</span>
            </a>

            <!-- Galeri -->
            <a href="{{ route('galleries.index') }}" class="flex flex-col items-center justify-center flex-1 text-center py-2 transition-colors {{ request()->routeIs('galleries.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"/></svg>
                <span class="text-[10px] font-medium mt-1">Galeri</span>
            </a>

            <!-- Keluar -->
            <form method="POST" action="{{ route('logout') }}" id="mobile-logout-form" class="hidden">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();" class="flex flex-col items-center justify-center flex-1 text-center py-2 transition-colors text-slate-400 hover:text-red-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span class="text-[10px] font-medium mt-1">Keluar</span>
            </a>
        </nav>
    </body>
</html>