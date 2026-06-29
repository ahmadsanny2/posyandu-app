<x-app-layout>
    <x-slot name="header">
        Tambah Orang Tua Baru
    </x-slot>

    <div class="max-w-2xl">
        <div class="mb-4">
            <a href="{{ route('parents.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Daftar</a>
        </div>

        <x-card title="Formulir Tambah Orang Tua" subtitle="Masukkan data akun orang tua / keluarga baru">
            <form method="POST" action="{{ route('parents.store') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" value="Nama Kepala Keluarga / Orang Tua" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" value="Alamat Email" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Kata Sandi (Password)" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('parents.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">Batal</a>
                    <x-primary-button>Simpan Akun</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
