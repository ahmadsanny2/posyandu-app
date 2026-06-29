<x-dynamic-component :component="auth()->user()->isParent() ? 'parent-layout' : 'app-layout'">
    <x-slot name="header">
        Daftarkan Ibu Hamil Baru
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('pregnant-women.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Daftar</a>
        </div>

        <x-card title="Formulir Pendaftaran Ibu Hamil" subtitle="Masukkan rincian informasi kehamilan">
            <form method="POST" action="{{ route('pregnant-women.store') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" value="Nama Ibu Hamil" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Pregnancy Age Weeks -->
                <div>
                    <x-input-label for="pregnancy_age_weeks" value="Usia Kandungan saat ini (Minggu)" />
                    <x-text-input id="pregnancy_age_weeks" name="pregnancy_age_weeks" type="number" min="1" max="44" class="mt-1 block w-full" :value="old('pregnancy_age_weeks')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('pregnancy_age_weeks')" />
                </div>

                <!-- Estimated Delivery Date (HPL) -->
                <div>
                    <x-input-label for="estimated_delivery_date" value="Hari Perkiraan Lahir (HPL)" />
                    <x-text-input id="estimated_delivery_date" name="estimated_delivery_date" type="date" class="mt-1 block w-full" :value="old('estimated_delivery_date')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('estimated_delivery_date')" />
                </div>

                <!-- Parent dropdown for Admin/Kader, hidden for Parent -->
                @if(!auth()->user()->isParent())
                    <div>
                        <x-input-label for="user_id" value="Hubungkan ke Akun Orang Tua/Suami" />
                        <select id="user_id" name="user_id" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow" required>
                            <option value="">Pilih Orang Tua</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('user_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }} ({{ $parent->email }})</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                    </div>
                @endif

                <!-- Address -->
                <div>
                    <x-input-label for="address" value="Alamat Rumah" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                <!-- Medical History -->
                <div>
                    <x-input-label for="medical_history" value="Riwayat Kesehatan Dasar / Catatan Khusus" />
                    <textarea id="medical_history" name="medical_history" rows="3" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow">{{ old('medical_history') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('medical_history')" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('pregnant-women.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">Batal</a>
                    <x-primary-button>Simpan Data</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-dynamic-component>
