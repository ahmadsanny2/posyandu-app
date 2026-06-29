<x-dynamic-component :component="auth()->user()->isParent() ? 'parent-layout' : 'app-layout'">
    <x-slot name="header">
        Daftarkan Lansia Baru
    </x-slot>

    <div class="space-y-6">
        <div class="mb-4">
            <a href="{{ route('elderlies.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Daftar</a>
        </div>

        <x-card title="Formulir Pendaftaran Lansia" subtitle="Masukkan rincian informasi lansia">
            <form method="POST" action="{{ route('elderlies.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" value="Nama Lengkap Lansia" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <x-input-label for="birth_date" value="Tanggal Lahir" />
                            <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                        </div>

                        <!-- Parent dropdown for Admin/Kader, hidden for Parent -->
                        @if(!auth()->user()->isParent())
                            <div>
                                <x-input-label for="user_id" value="Hubungkan ke Akun Keluarga Penanggung Jawab" />
                                <select id="user_id" name="user_id" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow" required>
                                    <option value="">Pilih Keluarga</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}" {{ old('user_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }} ({{ $parent->email }})</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                            </div>
                        @endif
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <!-- Address -->
                        <div>
                            <x-input-label for="address" value="Alamat Rumah" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" />
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <!-- Medical History -->
                        <div>
                            <x-input-label for="medical_history" value="Riwayat Penyakit (Bisa dikosongkan)" />
                            <textarea id="medical_history" name="medical_history" rows="6" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow">{{ old('medical_history') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('medical_history')" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('elderlies.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">Batal</a>
                    <x-primary-button>Simpan Data</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-dynamic-component>
