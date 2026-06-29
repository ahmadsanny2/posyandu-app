<x-app-layout>
    <x-slot name="header">
        Catat Perkembangan Balita
    </x-slot>

    <div class="space-y-6">
        <div class="mb-4">
            <a href="{{ route('schedules.show', $schedule->id) }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Jadwal</a>
        </div>

        <x-card title="Input Pemeriksaan Balita" subtitle="Masukkan data KMS untuk: {{ $toddler->name }} pada kegiatan {{ $schedule->title }}">
            <form method="POST" action="{{ route('toddlers.measure.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="toddler_id" value="{{ $toddler->id }}">
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Weight -->
                        <div>
                            <x-input-label for="weight_kg" value="Berat Badan (kg)" />
                            <x-text-input id="weight_kg" name="weight_kg" type="number" step="0.01" min="0.5" max="100" class="mt-1 block w-full" :value="old('weight_kg')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('weight_kg')" />
                        </div>

                        <!-- Height -->
                        <div>
                            <x-input-label for="height_cm" value="Tinggi / Panjang Badan (cm)" />
                            <x-text-input id="height_cm" name="height_cm" type="number" step="0.1" min="20" max="200" class="mt-1 block w-full" :value="old('height_cm')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('height_cm')" />
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <!-- Head Circumference -->
                        <div>
                            <x-input-label for="head_circumference_cm" value="Lingkar Kepala (cm)" />
                            <x-text-input id="head_circumference_cm" name="head_circumference_cm" type="number" step="0.1" min="10" max="100" class="mt-1 block w-full" :value="old('head_circumference_cm')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('head_circumference_cm')" />
                        </div>

                        <!-- Immunization Type -->
                        <div>
                            <x-input-label for="immunization_type" value="Pemberian Imunisasi / Vaksin (Opsional)" />
                            <x-text-input id="immunization_type" name="immunization_type" type="text" placeholder="Contoh: BCG, Polio 1, DPT-HB-HIB 1, dll." class="mt-1 block w-full" :value="old('immunization_type')" />
                            <x-input-error class="mt-2" :messages="$errors->get('immunization_type')" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('schedules.show', $schedule->id) }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">Batal</a>
                    <x-primary-button>Simpan Pengukuran</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
