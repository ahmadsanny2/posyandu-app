<x-dynamic-component :component="auth()->user()->isParent() ? 'parent-layout' : 'app-layout'">
    <x-slot name="header">
        Galeri Foto Kegiatan Posyandu
    </x-slot>

    <div class="space-y-6">
        <!-- Control Panel -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('galleries.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Unggah Foto Kegiatan
                    </a>
                @else
                    <span class="text-sm text-slate-500 font-medium">Kumpulan momen, kebersamaan, dan keseruan kegiatan imunisasi dan penyuluhan Posyandu RW kami.</span>
                @endif
            </div>
        </div>

        <!-- Galleries Grid -->
        @if($galleries->isEmpty())
            <div class="py-16 text-center text-slate-400">
                <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="font-semibold">Belum ada foto kegiatan di galeri posyandu.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($galleries as $gallery)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow group relative">
                        <!-- Image -->
                        <div class="h-52 bg-slate-50 overflow-hidden relative">
                            <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            <!-- Delete Button Hover overlay (Admin only) -->
                            @if(auth()->user()->isAdmin())
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini dari galeri?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-600 hover:bg-red-700 text-white rounded-xl shadow-md transition-colors" title="Hapus Foto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <!-- Details -->
                        <div class="p-4 space-y-1">
                            <h4 class="font-bold text-slate-800 text-sm truncate">{{ $gallery->title }}</h4>
                            <p class="text-xs text-slate-400 font-semibold">{{ $gallery->created_at->translatedFormat('d M Y') }}</p>
                            @if($gallery->description)
                                <p class="text-xs text-slate-500 line-clamp-2 mt-1.5 leading-relaxed">{{ $gallery->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
</x-dynamic-component>
