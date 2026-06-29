<x-app-layout>
    <x-slot name="header">
        Catat Rekam Medis Ibu Hamil
    </x-slot>

    <div class="max-w-2xl">
        <div class="mb-4">
            <a href="{{ route('schedules.show', $schedule->id) }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Jadwal</a>
        </div>

        <x-card title="Input Pemeriksaan Ibu Hamil" subtitle="Masukkan data pemeriksaan kehamilan untuk: {{ $pregnantWoman->name }} pada kegiatan {{ $schedule->title }}">
            <form method="POST" action="{{ route('pregnant-women.record.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="pregnant_woman_id" value="{{ $pregnantWoman->id }}">
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Weight -->
                    <div>
                        <x-input-label for="weight_kg" value="Berat Badan Ibu (kg)" />
                        <x-text-input id="weight_kg" name="weight_kg" type="number" step="0.1" min="30" max="200" class="mt-1 block w-full" :value="old('weight_kg')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('weight_kg')" />
                    </div>

                    <!-- Blood Pressure -->
                    <div>
                        <x-input-label for="blood_pressure" value="Tekanan Darah (mmHg, e.g. 120/80)" />
                        <x-text-input id="blood_pressure" name="blood_pressure" type="text" placeholder="120/80" class="mt-1 block w-full" :value="old('blood_pressure')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('blood_pressure')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- LILA -->
                    <div>
                        <x-input-label for="upper_arm_circumference_cm" value="Lingkar Lengan Atas / LILA (cm)" />
                        <x-text-input id="upper_arm_circumference_cm" name="upper_arm_circumference_cm" type="number" step="0.1" min="10" max="60" class="mt-1 block w-full" :value="old('upper_arm_circumference_cm')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('upper_arm_circumference_cm')" />
                    </div>

                    <!-- Gestational Age -->
                    <div>
                        <x-input-label for="gestational_age_weeks" value="Usia Kehamilan (Minggu)" />
                        <x-text-input id="gestational_age_weeks" name="gestational_age_weeks" type="number" min="1" max="44" class="mt-1 block w-full" :value="old('gestational_age_weeks', $pregnantWoman->pregnancy_age_weeks)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('gestational_age_weeks')" />
                    </div>
                </div>

                <!-- Fetal Heart Rate -->
                <div>
                    <x-input-label for="fetal_heart_rate" value="Denyut Jantung Janin / DJJ (dpm - Opsional)" />
                    <x-text-input id="fetal_heart_rate" name="fetal_heart_rate" type="number" min="50" max="220" class="mt-1 block w-full" :value="old('fetal_heart_rate')" />
                    <x-input-error class="mt-2" :messages="$errors->get('fetal_heart_rate')" />
                </div>

                <!-- Action Notes -->
                <div>
                    <x-input-label for="action_notes" value="Tindakan / Pemberian Tablet Tambah Darah / Catatan Konseling" />
                    <textarea id="action_notes" name="action_notes" rows="4" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow" placeholder="Tuliskan saran medis atau suplemen yang diberikan..." required>{{ old('action_notes') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('action_notes')" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('schedules.show', $schedule->id) }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">Batal</a>
                    <x-primary-button>Simpan Rekam Medis</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
