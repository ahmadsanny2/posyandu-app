<x-app-layout>
    <x-slot name="header">
        Kelola Pengguna Sistem
    </x-slot>

    <div class="space-y-6">
        <!-- Control Panel & Search -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Add User Button -->
            <div>
                <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Tambah User
                </a>
            </div>

            <!-- Search and Filter Form -->
            <form method="GET" action="{{ route('users.index') }}" class="flex flex-col sm:flex-row gap-3 flex-1 max-w-lg">
                <!-- Search Input -->
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="pl-10 w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow">
                </div>

                <!-- Role Filter -->
                <select name="role" class="rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow">
                    <option value="">Semua Peran</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kader" {{ request('role') == 'kader' ? 'selected' : '' }}>Kader</option>
                    <option value="parent" {{ request('role') == 'parent' ? 'selected' : '' }}>Orang Tua</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition-colors">
                    Filter
                </button>
            </form>
        </div>

        <!-- Users Table -->
        <x-card :padding="false">
            @if($users->isEmpty())
                <div class="py-12 text-center text-slate-400">
                    <p class="font-medium">Tidak ada data pengguna ditemukan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase bg-slate-50/75">
                                <th class="px-6 py-4">Nama</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Peran</th>
                                <th class="px-6 py-4">Bergabung</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($users as $user)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-800">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-slate-500">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold capitalize
                                            {{ $user->isAdmin() ? 'bg-red-50 text-red-700 border border-red-100' : '' }}
                                            {{ $user->isKader() ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                                            {{ $user->isParent() ? 'bg-slate-100 text-slate-700 border border-slate-200' : '' }}
                                        ">
                                            @if($user->role == 'parent') Orang Tua @else {{ $user->role }} @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">{{ $user->created_at->translatedFormat('d M Y') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Edit -->
                                            <a href="{{ route('users.edit', $user->id) }}" class="p-1.5 hover:bg-slate-100 text-slate-500 hover:text-slate-800 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>

                                            <!-- Delete -->
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Semua data terkait juga akan terpengaruh.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 hover:bg-red-50 text-slate-400 hover:text-red-600 rounded-lg transition-colors" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $users->links() }}
                </div>
            @endif
        </x-card>
    </div>
</x-app-layout>
