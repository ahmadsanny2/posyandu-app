<x-dynamic-component :component="auth()->user()->isParent() ? 'parent-layout' : 'app-layout'">
    <x-slot name="header">
        Detail Artikel Edukasi
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="mb-4">
            <a href="{{ route('articles.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Daftar</a>
        </div>

        <div class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden">
            <!-- Cover Image -->
            @if($article->image_path)
                <div class="h-80 md:h-96 w-full relative">
                    <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                </div>
            @endif

            <!-- Article Body -->
            <div class="p-6 md:p-10 space-y-6">
                <!-- Metadata -->
                <div class="space-y-3">
                    <span class="inline-flex px-3 py-1 bg-blue-50 text-primary border border-blue-100 text-xs font-bold rounded-full uppercase tracking-wide">
                        Edukasi Kesehatan
                    </span>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 leading-tight">
                        {{ $article->title }}
                    </h1>
                    <div class="flex items-center gap-4 text-xs font-semibold text-slate-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Diposting {{ $article->created_at->translatedFormat('d F Y') }}
                        </span>
                        <span>&bull;</span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Oleh: Administrator Posyandu
                        </span>
                    </div>
                </div>

                <!-- Text Content -->
                <div class="prose max-w-none text-slate-600 text-base leading-relaxed space-y-4 font-sans whitespace-pre-line border-t border-slate-100 pt-6">
                    {{ $article->content }}
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
