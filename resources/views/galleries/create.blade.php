<x-app-layout>
    <x-slot name="header">
        Unggah Foto Galeri Baru
    </x-slot>

    <div class="max-w-2xl">
        <div class="mb-4">
            <a href="{{ route('galleries.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Galeri</a>
        </div>

        <x-card title="Unggah Momen Kegiatan Posyandu" subtitle="Unggah dokumentasi foto kegiatan terkini">
            <form method="POST" action="{{ route('galleries.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Title -->
                <div>
                    <x-input-label for="title" value="Judul / Nama Momen" />
                    <x-text-input id="title" name="title" type="text" placeholder="Contoh: Imunisasi Campak Balita Posyandu Melati 3" class="mt-1 block w-full" :value="old('title')" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <!-- Description -->
                <div>
                    <x-input-label for="description" value="Keterangan Singkat (Opsional)" />
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow" placeholder="Tulis rincian singkat kegiatan atau pesan edukasi pendukung..."></textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <!-- Image -->
                <div>
                    <x-input-label for="image" value="Pilih Berkas Foto (Maksimal 2 MB)" />
                    <input id="image" name="image" type="file" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100 transition-colors" required />
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('galleries.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">Batal</a>
                    <x-primary-button>Unggah Foto</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
