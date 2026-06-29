@php
    $layoutTag = auth()->user()->isParent() ? 'x-parent-layout' : 'x-app-layout';
@endphp

<{{ $layoutTag }}>
    <x-slot name="header">
        Data Lansia
    </x-slot>

    <div class="space-y-6">
        <!-- Control Panel & Search -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Add Button -->
            <div>
                <a href="{{ route('elderlies.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Daftarkan Lansia
                </a>
            </div>

            <!-- Search and Filter Form -->
            @if(!auth()->user()->isParent())
                <form method="GET" action="{{ route('elderlies.index') }}" class="flex flex-col sm:flex-row gap-3 flex-1 max-w-lg">
                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama lansia..." class="pl-10 w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow">
                    </div>

                    <!-- Parent Filter -->
                    <select name="parent_id" class="rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow">
                        <option value="">Semua Orang Tua</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ request('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition-colors">
                        Filter
                    </button>
                </form>
            @endif
        </div>

        <!-- Elderlies Table/List -->
        <x-card :padding="false">
            @if($elderlies->isEmpty())
                <div class="py-12 text-center text-slate-400">
                    <p class="font-medium">Tidak ada data lansia ditemukan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase bg-slate-50/75">
                                <th class="px-6 py-4">Nama Lansia</th>
                                <th class="px-6 py-4">Tanggal Lahir</th>
                                <th class="px-6 py-4">Riwayat Penyakit</th>
                                @if(!auth()->user()->isParent())
                                    <th class="px-6 py-4">Nama Anggota Keluarga</th>
                                @endif
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($elderlies as $elderly)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-800">{{ $elderly->name }}</td>
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ \Carbon\Carbon::parse($elderly->birth_date)->translatedFormat('d F Y') }}
                                        <span class="text-xs text-slate-400">({{ \Carbon\Carbon::parse($elderly->birth_date)->age }} tahun)</span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 truncate max-w-xs">{{ $elderly->medical_history ?? 'Tidak ada' }}</td>
                                    @if(!auth()->user()->isParent())
                                        <td class="px-6 py-4 text-slate-500">{{ $elderly->user->name ?? 'Tidak Terikat' }}</td>
                                    @endif
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Detail -->
                                            <a href="{{ route('elderlies.show', $elderly->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition-colors">
                                                Detail Rekam
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('elderlies.edit', $elderly->id) }}" class="p-1.5 hover:bg-slate-100 text-slate-500 hover:text-slate-800 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('elderlies.destroy', $elderly->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data lansia ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 hover:bg-red-50 text-slate-400 hover:text-red-600 rounded-lg transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $elderlies->links() }}
                </div>
            @endif
        </x-card>
    </div>
</{{ $layoutTag }}>
