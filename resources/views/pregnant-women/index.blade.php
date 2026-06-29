<x-dynamic-component :component="auth()->user()->isParent() ? 'parent-layout' : 'app-layout'">
    <x-slot name="header">
        Data Ibu Hamil
    </x-slot>

    <div class="space-y-6">
        <!-- Control Panel & Search -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Add Button -->
            <div>
                <a href="{{ route('pregnant-women.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Daftarkan Ibu Hamil
                </a>
            </div>

            <!-- Search and Filter Form -->
            @if(!auth()->user()->isParent())
                <form method="GET" action="{{ route('pregnant-women.index') }}" class="flex flex-col sm:flex-row gap-3 flex-1 max-w-lg">
                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama ibu..." class="pl-10 w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow">
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

        <!-- Pregnant Women Table/List -->
        <x-card :padding="false">
            @if($pregnantWomen->isEmpty())
                <div class="py-12 text-center text-slate-400">
                    <p class="font-medium">Tidak ada data ibu hamil ditemukan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase bg-slate-50/75">
                                <th class="px-6 py-4">Nama Ibu</th>
                                <th class="px-6 py-4">Usia Kandungan</th>
                                <th class="px-6 py-4">Hari Perkiraan Lahir (HPL)</th>
                                @if(!auth()->user()->isParent())
                                    <th class="px-6 py-4">Nama Orang Tua/Suami</th>
                                @endif
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($pregnantWomen as $woman)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-800">{{ $woman->name }}</td>
                                    <td class="px-6 py-4 text-slate-500">{{ $woman->pregnancy_age_weeks }} minggu</td>
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ \Carbon\Carbon::parse($woman->estimated_delivery_date)->translatedFormat('d F Y') }}
                                    </td>
                                    @if(!auth()->user()->isParent())
                                        <td class="px-6 py-4 text-slate-500">{{ $woman->user->name ?? 'Tidak Terikat' }}</td>
                                    @endif
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Detail -->
                                            <a href="{{ route('pregnant-women.show', $woman->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition-colors">
                                                Detail Rekam
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('pregnant-women.edit', $woman->id) }}" class="p-1.5 hover:bg-slate-100 text-slate-500 hover:text-slate-800 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('pregnant-women.destroy', $woman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ibu hamil ini?')">
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
                    {{ $pregnantWomen->links() }}
                </div>
            @endif
        </x-card>
    </div>
</x-dynamic-component>
