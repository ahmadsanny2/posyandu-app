<x-dynamic-component :component="auth()->user()->isParent() ? 'parent-layout' : 'app-layout'">
    <x-slot name="header">
        Jadwal Kegiatan Posyandu
    </x-slot>

    <div class="space-y-6">
        <!-- Control Panel & Search -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Add Button (Admin/Kader only) -->
            <div>
                @if(auth()->user()->isAdmin() || auth()->user()->isKader())
                    <a href="{{ route('schedules.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Buat Jadwal Baru
                    </a>
                @else
                    <span class="text-sm text-slate-500 font-medium">Lihat dan kirim RSVP kehadiran untuk jadwal kegiatan di bawah ini.</span>
                @endif
            </div>

            <!-- Search and Filter Form -->
            <form method="GET" action="{{ route('schedules.index') }}" class="flex flex-col sm:flex-row gap-3 flex-1 max-w-lg">
                <!-- Search Input -->
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kegiatan..." class="pl-10 w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow">
                </div>

                <!-- Target Type Filter -->
                <select name="target_type" class="rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow">
                    <option value="">Semua Sasaran</option>
                    <option value="toddler" {{ request('target_type') == 'toddler' ? 'selected' : '' }}>Balita</option>
                    <option value="pregnant_woman" {{ request('target_type') == 'pregnant_woman' ? 'selected' : '' }}>Ibu Hamil</option>
                    <option value="elderly" {{ request('target_type') == 'elderly' ? 'selected' : '' }}>Lansia</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition-colors">
                    Filter
                </button>
            </form>
        </div>

        <!-- Schedules Table/List -->
        <x-card :padding="false">
            @if($schedules->isEmpty())
                <div class="py-12 text-center text-slate-400">
                    <p class="font-medium">Tidak ada jadwal kegiatan ditemukan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase bg-slate-50/75">
                                <th class="px-6 py-4">Nama Kegiatan</th>
                                <th class="px-6 py-4">Sasaran</th>
                                <th class="px-6 py-4">Tanggal & Waktu</th>
                                <th class="px-6 py-4">Lokasi</th>
                                <th class="px-6 py-4 text-right">Aksi / RSVP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($schedules as $schedule)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-800">{{ $schedule->title }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                            {{ $schedule->target_type == 'toddler' ? 'bg-blue-50 text-blue-700' : '' }}
                                            {{ $schedule->target_type == 'pregnant_woman' ? 'bg-pink-50 text-pink-700' : '' }}
                                            {{ $schedule->target_type == 'elderly' ? 'bg-emerald-50 text-emerald-700' : '' }}
                                        ">
                                            @if($schedule->target_type == 'toddler') Balita @endif
                                            @if($schedule->target_type == 'pregnant_woman') Ibu Hamil @endif
                                            @if($schedule->target_type == 'elderly') Lansia @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $schedule->scheduled_at->translatedFormat('d F Y, H:i') }} WIB
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">{{ $schedule->location }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <!-- If Admin/Kader, show Edit/Delete -->
                                        @if(auth()->user()->isAdmin() || auth()->user()->isKader())
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('schedules.edit', $schedule->id) }}" class="p-1.5 hover:bg-slate-100 text-slate-500 hover:text-slate-800 rounded-lg transition-colors" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 hover:bg-red-50 text-slate-400 hover:text-red-600 rounded-lg transition-colors" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <!-- Parent: RSVP section -->
                                            <div class="flex items-center justify-end gap-3">
                                                @php
                                                    $rsvp = $userRsvps->get($schedule->id);
                                                @endphp

                                                @if($rsvp)
                                                    <span class="text-xs font-semibold px-2 py-1 rounded 
                                                        {{ $rsvp->is_present ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-red-50 text-red-700 border border-red-100' }}
                                                    ">
                                                        RSVP: {{ $rsvp->is_present ? 'Hadir' : 'Absen' }}
                                                    </span>
                                                @endif

                                                <form method="POST" action="{{ route('schedules.rsvp', $schedule->id) }}" class="flex items-center gap-1.5">
                                                    @csrf
                                                    <input type="hidden" name="notes" value="RSVP via Web">
                                                    
                                                    <button type="submit" name="is_present" value="1" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded text-xs font-bold transition-colors">
                                                        Hadir
                                                    </button>
                                                    <button type="submit" name="is_present" value="0" class="px-2.5 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-bold transition-colors">
                                                        Absen
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $schedules->links() }}
                </div>
            @endif
        </x-card>
    </div>
</x-dynamic-component>
