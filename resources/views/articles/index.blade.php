<x-dynamic-component :component="auth()->user()->isParent() ? 'parent-layout' : 'app-layout'">
    <x-slot name="header">
        Artikel Edukasi Kesehatan
    </x-slot>

    <div class="space-y-6">
        <!-- Control Panel & Search -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Add Button (Admin only) -->
            <div>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('articles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Tulis Artikel Baru
                    </a>
                @else
                    <span class="text-sm text-slate-500 font-medium">Pelajari tips kesehatan, informasi gizi, dan info tumbuh kembang terpercaya.</span>
                @endif
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('articles.index') }}" class="flex gap-2 w-full md:w-80">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..." class="pl-10 w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow">
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition-colors">
                    Cari
                </button>
            </form>
        </div>

        <!-- Articles Grid -->
        @if($articles->isEmpty())
            <div class="py-16 text-center text-slate-400">
                <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <p class="font-semibold">Belum ada artikel edukasi kesehatan yang dipublikasikan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $article)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow group">
                        <div>
                            <!-- Image Cover -->
                            <div class="h-48 bg-slate-100 overflow-hidden relative">
                                @if($article->image_path)
                                    <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <span class="absolute bottom-3 left-3 bg-white/90 backdrop-blur text-[10px] font-bold text-slate-800 px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                    {{ $article->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <!-- Content Summary -->
                            <div class="p-5 space-y-2">
                                <h3 class="font-bold text-slate-800 text-lg line-clamp-2 group-hover:text-primary transition-colors">
                                    <a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
                                </h3>
                                <p class="text-sm text-slate-500 line-clamp-3">
                                    {{ strip_tags($article->content) }}
                                </p>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="p-5 pt-0 flex items-center justify-between border-t border-slate-50 mt-4">
                            <a href="{{ route('articles.show', $article->id) }}" class="text-sm font-semibold text-primary hover:underline">
                                Baca Selengkapnya &rarr;
                            </a>
                            
                            @if(auth()->user()->isAdmin())
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('articles.edit', $article->id) }}" class="p-1 hover:bg-slate-100 rounded text-slate-500 hover:text-slate-800 transition-colors" title="Ubah">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 hover:bg-red-50 rounded text-slate-400 hover:text-red-600 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</x-dynamic-component>
