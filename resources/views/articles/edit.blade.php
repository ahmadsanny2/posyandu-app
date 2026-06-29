<x-app-layout>
    <x-slot name="header">
        Ubah Artikel Edukasi
    </x-slot>

    <div class="space-y-6">
        <div class="mb-4">
            <a href="{{ route('articles.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Daftar</a>
        </div>

        <x-card title="Ubah Artikel Edukasi Kesehatan" subtitle="Sesuaikan materi atau gambar sampul artikel">
            <form method="POST" action="{{ route('articles.update', $article->id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Title -->
                        <div>
                            <x-input-label for="title" value="Judul Artikel" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $article->title)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <!-- Cover Image -->
                        <div>
                            <x-input-label for="image" value="Gambar Sampul Artikel (Kosongkan jika tidak diubah)" />
                            <input id="image" name="image" type="file" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100 transition-colors" />
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <!-- Content -->
                        <div>
                            <x-input-label for="content" value="Konten / Isi Artikel" />
                            <textarea id="content" name="content" rows="12" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow" placeholder="Tuliskan materi edukasi kesehatan Anda di sini..." required>{{ old('content', $article->content) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('articles.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">Batal</a>
                    <x-primary-button>Perbarui Artikel</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
