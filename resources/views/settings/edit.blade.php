<x-app-layout>
    <x-slot name="header">
        Konfigurasi Posyandu
    </x-slot>

    <div class="max-w-3xl space-y-6">

        <x-card title="Pengaturan Identitas Posyandu" subtitle="Ubah nama, alamat, dan nomor kontak posyandu">
            <form method="POST" action="{{ route('settings.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Posyandu Name -->
                <div>
                    <x-input-label for="posyandu_name" value="Nama Posyandu" />
                    <x-text-input id="posyandu_name" name="posyandu_name" type="text" class="mt-1 block w-full" :value="old('posyandu_name', $setting->posyandu_name)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('posyandu_name')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Phone -->
                    <div>
                        <x-input-label for="phone" value="No. Telepon / HP Kontak" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $setting->phone)" placeholder="Contoh: 0812-3456-7890" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" value="Alamat Email Kontak" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $setting->email)" placeholder="Contoh: info@posyandurw.or.id" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <x-input-label for="address" value="Alamat Lengkap Posyandu" />
                    <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow" placeholder="Contoh: Kelurahan Asri Jaya, Kecamatan Sukamakmur, Kota Sejahtera">{{ old('address', $setting->address) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <x-primary-button>Simpan Konfigurasi</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
