<x-app-layout>
    <x-slot name="header">
        Buat Jadwal Posyandu Baru
    </x-slot>

    <div class="space-y-6">
        <div class="mb-4">
            <a href="{{ route('schedules.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Daftar</a>
        </div>

        <x-card title="Formulir Jadwal Kegiatan" subtitle="Masukkan rincian kegiatan posyandu mendatang">
            <form method="POST" action="{{ route('schedules.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Title -->
                        <div>
                            <x-input-label for="title" value="Nama Kegiatan" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <!-- Target Type -->
                        <div>
                            <x-input-label for="target_type" value="Sasaran Pemeriksaan" />
                            <select id="target_type" name="target_type" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow" required>
                                <option value="">Pilih Sasaran</option>
                                <option value="toddler" {{ old('target_type') == 'toddler' ? 'selected' : '' }}>Balita</option>
                                <option value="pregnant_woman" {{ old('target_type') == 'pregnant_woman' ? 'selected' : '' }}>Ibu Hamil</option>
                                <option value="elderly" {{ old('target_type') == 'elderly' ? 'selected' : '' }}>Lansia</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('target_type')" />
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <!-- Scheduled At -->
                        <div>
                            <x-input-label for="scheduled_at" value="Tanggal & Waktu Pelaksanaan" />
                            <x-text-input id="scheduled_at" name="scheduled_at" type="datetime-local" class="mt-1 block w-full" :value="old('scheduled_at')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('scheduled_at')" />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-input-label for="location" value="Lokasi Kegiatan" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('schedules.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">Batal</a>
                    <x-primary-button>Simpan Jadwal</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
