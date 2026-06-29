<x-dynamic-component :component="auth()->user()->isParent() ? 'parent-layout' : 'app-layout'">
    <x-slot name="header">
        Detail Jadwal Kegiatan Posyandu
    </x-slot>

    <div class="space-y-6 max-w-5xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('schedules.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Daftar</a>
        </div>

        <!-- Schedule Info Card -->
        <div class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                        {{ $schedule->target_type == 'toddler' ? 'bg-blue-50 text-blue-700' : '' }}
                        {{ $schedule->target_type == 'pregnant_woman' ? 'bg-pink-50 text-pink-700' : '' }}
                        {{ $schedule->target_type == 'elderly' ? 'bg-emerald-50 text-emerald-700' : '' }}
                    ">
                        Target: 
                        @if($schedule->target_type == 'toddler') Balita @endif
                        @if($schedule->target_type == 'pregnant_woman') Ibu Hamil @endif
                        @if($schedule->target_type == 'elderly') Lansia @endif
                    </span>
                </div>
                <h2 class="text-2xl font-bold text-slate-800">{{ $schedule->title }}</h2>
                <div class="flex flex-col sm:flex-row sm:items-center gap-x-6 gap-y-1.5 text-slate-500 text-sm">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $schedule->scheduled_at->translatedFormat('d F Y, H:i') }} WIB
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $schedule->location }}
                    </span>
                </div>
            </div>

            <!-- RSVP Action (For Parent) -->
            @if(auth()->user()->isParent())
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 w-full md:w-auto">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kehadiran Anda</p>
                    <div class="flex items-center gap-2 mt-2">
                        @php
                            $myRsvp = $attendances->where('user_id', auth()->id())->first();
                        @endphp
                        @if($myRsvp)
                            <span class="text-sm font-semibold text-slate-700">
                                Anda menyatakan: <strong class="{{ $myRsvp->is_present ? 'text-emerald-600' : 'text-red-600' }}">{{ $myRsvp->is_present ? 'Hadir' : 'Absen' }}</strong>
                            </span>
                        @else
                            <span class="text-xs text-slate-500">Belum mengirim konfirmasi.</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        @if(auth()->user()->isAdmin() || auth()->user()->isKader())
            <!-- Participants Attendance/Medical Records input (Managerial view) -->
            <x-card title="Pengisian Rekam Medis Kegiatan" subtitle="Catat data pemeriksaan fisik peserta posyandu yang hadir">
                @if($participants->isEmpty())
                    <div class="py-8 text-center text-slate-400 text-sm">
                        Belum ada peserta terdaftar untuk sasaran kegiatan ini.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase bg-slate-50/75">
                                    <th class="px-6 py-4">Nama Peserta</th>
                                    <th class="px-6 py-4">Keluarga Penanggung Jawab</th>
                                    <th class="px-6 py-4 text-center">Status Rekam</th>
                                    <th class="px-6 py-4 text-right">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @foreach($participants as $participant)
                                    @php
                                        $hasMeasured = in_array($participant->id, $existingMeasurementIds);
                                    @endphp
                                    <tr class="hover:bg-slate-50/30 transition-colors">
                                        <td class="px-6 py-4 font-bold text-slate-800">{{ $participant->name }}</td>
                                        <td class="px-6 py-4 text-slate-500">{{ $participant->user->name ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if($hasMeasured)
                                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 text-xs font-semibold rounded-full">
                                                    Selesai Diperiksa
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-100 text-xs font-semibold rounded-full">
                                                    Belum Diperiksa
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($hasMeasured)
                                                <span class="text-xs text-slate-400">Data Terrekam</span>
                                            @else
                                                @if($schedule->target_type === 'toddler')
                                                    <a href="{{ route('toddlers.measure.create', [$schedule->id, $participant->id]) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition-colors">
                                                        Input BB/TB
                                                    </a>
                                                @elseif($schedule->target_type === 'pregnant_woman')
                                                    <a href="{{ route('pregnant-women.record.create', [$schedule->id, $participant->id]) }}" class="px-3 py-1.5 bg-pink-600 hover:bg-pink-700 text-white rounded-lg text-xs font-bold transition-colors">
                                                        Input Rekam Bumil
                                                    </a>
                                                @elseif($schedule->target_type === 'elderly')
                                                    <a href="{{ route('elderlies.record.create', [$schedule->id, $participant->id]) }}" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-colors">
                                                        Input Rekam Lansia
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-card>
        @else
            <!-- Parent view: RSVP lists -->
            <x-card title="Daftar Hadir Konfirmasi Warga" subtitle="Daftar warga yang berencana menghadiri kegiatan ini">
                @if($attendances->isEmpty())
                    <div class="py-8 text-center text-slate-400 text-sm">
                        Belum ada konfirmasi kehadiran dari warga lain.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase">
                                    <th class="pb-3">Keluarga</th>
                                    <th class="pb-3">Rencana Kehadiran</th>
                                    <th class="pb-3">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 text-sm">
                                @foreach($attendances as $attendance)
                                    <tr>
                                        <td class="py-3 font-semibold text-slate-800">{{ $attendance->user->name }}</td>
                                        <td class="py-3">
                                            <span class="px-2 py-0.5 rounded text-xs font-semibold 
                                                {{ $attendance->is_present ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}
                                            ">
                                                {{ $attendance->is_present ? 'Akan Hadir' : 'Tidak Hadir' }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-slate-500 text-xs">{{ $attendance->notes ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-card>
        @endif
    </div>
</x-dynamic-component>
