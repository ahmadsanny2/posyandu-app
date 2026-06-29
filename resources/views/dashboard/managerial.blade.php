<x-app-layout>
    <x-slot name="header">
        Dashboard Manajerial
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-2xl p-6 shadow-sm">
            <h2 class="text-xl md:text-2xl font-bold">Selamat Datang kembali, {{ auth()->user()->name }}!</h2>
            <p class="text-blue-100 text-sm mt-1">Anda masuk sebagai petugas dengan akses <strong>{{ auth()->user()->role }}</strong>. Pantau dan kelola layanan posyandu dengan mudah hari ini.</p>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Balita -->
            <x-card :padding="false">
                <div class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Balita</p>
                        <h4 class="text-2xl font-extrabold text-slate-800 mt-1">{{ $stats['toddlers_count'] }}</h4>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <div class="px-5 py-3 bg-slate-50 border-t border-slate-100">
                    <a href="{{ route('toddlers.index') }}" class="text-xs font-semibold text-primary hover:text-blue-700 flex items-center gap-1">
                        Lihat Data Balita &rarr;
                    </a>
                </div>
            </x-card>

            <!-- Ibu Hamil -->
            <x-card :padding="false">
                <div class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ibu Hamil</p>
                        <h4 class="text-2xl font-extrabold text-slate-800 mt-1">{{ $stats['pregnant_women_count'] }}</h4>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
                <div class="px-5 py-3 bg-slate-50 border-t border-slate-100">
                    <a href="{{ route('pregnant-women.index') }}" class="text-xs font-semibold text-pink-600 hover:text-pink-700 flex items-center gap-1">
                        Lihat Data Bumil &rarr;
                    </a>
                </div>
            </x-card>

            <!-- Lansia -->
            <x-card :padding="false">
                <div class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Lansia</p>
                        <h4 class="text-2xl font-extrabold text-slate-800 mt-1">{{ $stats['elderlies_count'] }}</h4>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                </div>
                <div class="px-5 py-3 bg-slate-50 border-t border-slate-100">
                    <a href="{{ route('elderlies.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        Lihat Data Lansia &rarr;
                    </a>
                </div>
            </x-card>

            <!-- Pengguna Sistem -->
            <x-card :padding="false">
                <div class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total User</p>
                        <h4 class="text-2xl font-extrabold text-slate-800 mt-1">{{ $stats['users_count'] }}</h4>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <div class="px-5 py-3 bg-slate-50 border-t border-slate-100">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('users.index') }}" class="text-xs font-semibold text-purple-600 hover:text-purple-700 flex items-center gap-1">
                            Kelola User &rarr;
                        </a>
                    @else
                        <span class="text-xs text-slate-400">Hanya diakses oleh Admin</span>
                    @endif
                </div>
            </x-card>
        </div>

        <!-- Schedules & Analytics Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Schedules Section -->
            <div class="lg:col-span-2">
                <x-card title="Agenda Kegiatan Terdekat" subtitle="Jadwal posyandu bulanan yang akan datang">
                    @if($schedules->isEmpty())
                        <div class="py-8 text-center text-slate-400">
                            <p>Tidak ada agenda kegiatan terdekat.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase">
                                        <th class="pb-3">Kegiatan</th>
                                        <th class="pb-3">Sasaran</th>
                                        <th class="pb-3">Tanggal & Waktu</th>
                                        <th class="pb-3">Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 text-sm">
                                    @foreach($schedules as $schedule)
                                        <tr>
                                            <td class="py-3 font-semibold text-slate-800">
                                                <a href="{{ route('schedules.show', $schedule->id) }}" class="hover:text-primary transition-colors">
                                                    {{ $schedule->title }}
                                                </a>
                                            </td>
                                            <td class="py-3">
                                                <span class="px-2.5 py-1 rounded-full text-xs font-medium 
                                                    {{ $schedule->target_type == 'toddler' ? 'bg-blue-50 text-blue-700' : '' }}
                                                    {{ $schedule->target_type == 'pregnant_woman' ? 'bg-pink-50 text-pink-700' : '' }}
                                                    {{ $schedule->target_type == 'elderly' ? 'bg-emerald-50 text-emerald-700' : '' }}
                                                ">
                                                    @if($schedule->target_type == 'toddler') Balita @endif
                                                    @if($schedule->target_type == 'pregnant_woman') Ibu Hamil @endif
                                                    @if($schedule->target_type == 'elderly') Lansia @endif
                                                </span>
                                            </td>
                                            <td class="py-3 text-slate-500">{{ $schedule->scheduled_at->translatedFormat('d F Y, H:i') }} WIB</td>
                                            <td class="py-3 text-slate-500">{{ $schedule->location }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </x-card>
            </div>

            <!-- Health check distributions -->
            <div>
                <x-card title="Proporsi Layanan" subtitle="Distribusi total rekam medis yang dicatat">
                    <div class="h-64 flex items-center justify-center">
                        @if($stats['toddler_measurements_count'] + $stats['pregnancy_records_count'] + $stats['elderly_records_count'] == 0)
                            <p class="text-sm text-slate-400 font-medium">Belum ada rekam medis terdaftar.</p>
                        @else
                            <canvas id="checkupChart"></canvas>
                        @endif
                    </div>
                </x-card>
            </div>
        </div>

        @if($stats['toddler_measurements_count'] + $stats['pregnancy_records_count'] + $stats['elderly_records_count'] > 0)
            <!-- Load Chart.js CDN -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctx = document.getElementById('checkupChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Balita', 'Ibu Hamil', 'Lansia'],
                            datasets: [{
                                data: [
                                    {{ $stats['toddler_measurements_count'] }},
                                    {{ $stats['pregnancy_records_count'] }},
                                    {{ $stats['elderly_records_count'] }}
                                ],
                                backgroundColor: ['#2563EB', '#EC4899', '#10B981'],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                }
                            }
                        }
                    });
                });
            </script>
        @endif
    </div>
</x-app-layout>
