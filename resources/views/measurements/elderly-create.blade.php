<x-app-layout>
    <x-slot name="header">
        Catat Rekam Medis Lansia
    </x-slot>

    <div class="space-y-6">
        <div class="mb-4">
            <a href="{{ route('schedules.show', $schedule->id) }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Jadwal</a>
        </div>

        <x-card title="Input Pemeriksaan Lansia" subtitle="Masukkan data pemeriksaan kesehatan lansia untuk: {{ $elderly->name }} pada kegiatan {{ $schedule->title }}">
            <form method="POST" action="{{ route('elderlies.record.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="elderly_id" value="{{ $elderly->id }}">
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Weight -->
                        <div>
                            <x-input-label for="weight_kg" value="Berat Badan Lansia (kg - Opsional)" />
                            <x-text-input id="weight_kg" name="weight_kg" type="number" step="0.1" min="20" max="200" class="mt-1 block w-full" :value="old('weight_kg')" autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('weight_kg')" />
                        </div>

                        <!-- Blood Pressure -->
                        <div>
                            <x-input-label for="blood_pressure" value="Tekanan Darah (mmHg, e.g. 130/80)" />
                            <x-text-input id="blood_pressure" name="blood_pressure" type="text" placeholder="130/80" class="mt-1 block w-full" :value="old('blood_pressure')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('blood_pressure')" />
                        </div>

                        <!-- Blood Sugar -->
                        <div>
                            <x-input-label for="blood_sugar" value="Gula Darah (mg/dL - Opsional)" />
                            <x-text-input id="blood_sugar" name="blood_sugar" type="number" min="20" max="600" class="mt-1 block w-full" :value="old('blood_sugar')" />
                            <x-input-error class="mt-2" :messages="$errors->get('blood_sugar')" />
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <!-- Cholesterol -->
                        <div>
                            <x-input-label for="cholesterol" value="Kolesterol (mg/dL - Opsional)" />
                            <x-text-input id="cholesterol" name="cholesterol" type="number" min="50" max="500" class="mt-1 block w-full" :value="old('cholesterol')" />
                            <x-input-error class="mt-2" :messages="$errors->get('cholesterol')" />
                        </div>

                        <!-- Uric Acid -->
                        <div>
                            <x-input-label for="uric_acid" value="Asam Urat (mg/dL - Opsional)" />
                            <x-text-input id="uric_acid" name="uric_acid" type="number" step="0.1" min="1" max="25" class="mt-1 block w-full" :value="old('uric_acid')" />
                            <x-input-error class="mt-2" :messages="$errors->get('uric_acid')" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('schedules.show', $schedule->id) }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">Batal</a>
                    <x-primary-button>Simpan Rekam Medis</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
