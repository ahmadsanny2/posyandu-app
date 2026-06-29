<!-- Dashboard -->
<a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    Dashboard
</a>

<!-- Jadwal Kegiatan -->
<a href="{{ route('schedules.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('schedules.*') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    Jadwal Posyandu
</a>

<!-- CRUD Data Peserta (Kader & Admin) -->
@if(auth()->user()->isAdmin() || auth()->user()->isKader())
    <div class="pt-4 pb-2 px-4">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Data Master</p>
    </div>

    <!-- Balita -->
    <a href="{{ route('toddlers.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('toddlers.*') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Data Balita
    </a>

    <!-- Ibu Hamil -->
    <a href="{{ route('pregnant-women.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('pregnant-women.*') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        Ibu Hamil
    </a>

    <!-- Lansia -->
    <a href="{{ route('elderlies.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('elderlies.*') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        Data Lansia
    </a>

    <!-- Laporan Bulanan -->
    <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('reports.*') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 5a2 2 0 114 0h4a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h2z"/></svg>
        Laporan Bulanan
    </a>
@endif

<!-- CRUD Petugas / Kader (Admin Only) -->
@if(auth()->user()->isAdmin())
    <div class="pt-4 pb-2 px-4">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Manajemen</p>
    </div>

    <!-- Kelola Kader / User -->
    <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('users.*') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        Kelola Kader & Orang Tua
    </a>
@endif

<!-- Edukasi & Informasi -->
<div class="pt-4 pb-2 px-4">
    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Konten</p>
</div>

<!-- Artikel -->
<a href="{{ route('articles.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('articles.*') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
    Artikel Edukasi
</a>

<!-- Galeri -->
<a href="{{ route('galleries.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('galleries.*') ? 'bg-blue-50 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}">
    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    Galeri Kegiatan
</a>
