@php
    $layoutTag = auth()->user()->isParent() ? 'x-parent-layout' : 'x-app-layout';
@endphp

<{{ $layoutTag }}>
    <x-slot name="header">
        Ubah Data Balita
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('toddlers.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Daftar</a>
        </div>

        <x-card title="Ubah Data Balita" subtitle="Sesuaikan rincian informasi balita: {{ $toddler->name }}">
            <form method="POST" action="{{ route('toddlers.update', $toddler->id) }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <!-- Name -->
                <div>
                    <x-input-label for="name" value="Nama Lengkap Balita" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $toddler->name)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Gender -->
                <div>
                    <x-input-label for="gender" value="Jenis Kelamin" />
                    <select id="gender" name="gender" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow" required>
                        <option value="M" {{ old('gender', $toddler->gender) == 'M' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="F" {{ old('gender', $toddler->gender) == 'F' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                </div>

                <!-- Birth Date -->
                <div>
                    <x-input-label for="birth_date" value="Tanggal Lahir" />
                    <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $toddler->birth_date)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                </div>

                <!-- Parent dropdown for Admin/Kader, hidden for Parent -->
                @if(!auth()->user()->isParent())
                    <div>
                        <x-input-label for="user_id" value="Hubungkan ke Akun Orang Tua" />
                        <select id="user_id" name="user_id" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow" required>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('user_id', $toddler->user_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }} ({{ $parent->email }})</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                    </div>
                @endif

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('toddlers.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">Batal</a>
                    <x-primary-button>Perbarui Data</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</{{ $layoutTag }}>
