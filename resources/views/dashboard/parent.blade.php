<x-parent-layout>
    <x-slot name="header">
        Beranda Keluarga
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-2xl p-6 shadow-sm">
            <h2 class="text-xl md:text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="text-blue-100 text-sm mt-1">Pantau perkembangan kesehatan seluruh anggota keluarga Anda dalam satu akun terpadu.</p>
        </div>

        <!-- Family Profiles List -->
        <div class="space-y-4">
            <h3 class="text-lg font-bold text-slate-800">Anggota Keluarga Terdaftar</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Balita Section -->
                <x-card title="Balita / Anak" subtitle="Data pertumbuhan anak Anda">
                    @if($toddlers->isEmpty())
                        <div class="py-6 text-center text-slate-400 text-sm">
                            Belum ada data balita yang didaftarkan.
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach($toddlers as $toddler)
                                <div class="py-3 flex items-center justify-between">
                                    <div>
                                        <h4 class="font-bold text-slate-800">{{ $toddler->name }}</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            {{ $toddler->gender == 'M' ? 'Laki-laki' : 'Perempuan' }} &bull; 
                                            Lahir: {{ \Carbon\Carbon::parse($toddler->birth_date)->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                    <a href="{{ route('toddlers.show', $toddler->id) }}" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-primary text-xs font-semibold rounded-lg transition-colors">
                                        Detail KMS
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-card>

                <!-- Ibu Hamil Section -->
                <x-card title="Ibu Hamil" subtitle="Pemantauan kesehatan kehamilan">
                    @if($pregnantWomen->isEmpty())
                        <div class="py-6 text-center text-slate-400 text-sm">
                            Belum ada profil kehamilan aktif.
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach($pregnantWomen as $woman)
                                <div class="py-3 flex items-center justify-between">
                                    <div>
                                        <h4 class="font-bold text-slate-800">{{ $woman->name }}</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            Usia Kandungan: {{ $woman->pregnancy_age_weeks }} minggu &bull; 
                                            HPL: {{ \Carbon\Carbon::parse($woman->estimated_delivery_date)->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                    <a href="{{ route('pregnant-women.show', $woman->id) }}" class="px-3 py-1.5 bg-pink-50 hover:bg-pink-100 text-pink-600 text-xs font-semibold rounded-lg transition-colors">
                                        Detail Bumil
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-card>

                <!-- Lansia Section -->
                <x-card title="Lansia / Kakek-Nenek" subtitle="Pemeriksaan lansia serumah">
                    @if($elderlies->isEmpty())
                        <div class="py-6 text-center text-slate-400 text-sm">
                            Belum ada data lansia yang didaftarkan.
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach($elderlies as $elderly)
                                <div class="py-3 flex items-center justify-between">
                                    <div>
                                        <h4 class="font-bold text-slate-800">{{ $elderly->name }}</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            Lahir: {{ \Carbon\Carbon::parse($elderly->birth_date)->translatedFormat('d M Y') }} &bull;
                                            Riwayat: {{ $elderly->medical_history ?? 'Tidak ada' }}
                                        </p>
                                    </div>
                                    <a href="{{ route('elderlies.show', $elderly->id) }}" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 text-xs font-semibold rounded-lg transition-colors">
                                        Detail Lansia
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-card>

                <!-- Agenda Terkait Section -->
                <x-card title="Agenda Terdekat Keluarga" subtitle="Agenda posyandu yang relevan untuk Anda">
                    @if($schedules->isEmpty())
                        <div class="py-6 text-center text-slate-400 text-sm">
                            Tidak ada jadwal pemeriksaan terdekat.
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($schedules as $schedule)
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full 
                                            {{ $schedule->target_type == 'toddler' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $schedule->target_type == 'pregnant_woman' ? 'bg-pink-100 text-pink-700' : '' }}
                                            {{ $schedule->target_type == 'elderly' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        ">
                                            @if($schedule->target_type == 'toddler') Balita @endif
                                            @if($schedule->target_type == 'pregnant_woman') Ibu Hamil @endif
                                            @if($schedule->target_type == 'elderly') Lansia @endif
                                        </span>
                                        <span class="text-xs text-slate-500 font-semibold">{{ $schedule->scheduled_at->translatedFormat('d F Y') }}</span>
                                    </div>
                                    <h4 class="font-bold text-slate-800 text-sm mt-1.5">{{ $schedule->title }}</h4>
                                    <div class="flex items-center justify-between mt-3 pt-2 border-t border-slate-100/50">
                                        <p class="text-xs text-slate-500 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $schedule->location }}
                                        </p>
                                        <a href="{{ route('schedules.show', $schedule->id) }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-primary hover:text-blue-700 transition-colors">
                                            Detail &amp; RSVP &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-card>
            </div>
        </div>
    </div>
</x-parent-layout>
