<x-dynamic-component :component="auth()->user()->isParent() ? 'parent-layout' : 'app-layout'">
    <x-slot name="header">
        Detail Perkembangan Balita
    </x-slot>

    <div class="space-y-6 max-w-5xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('toddlers.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Daftar</a>
        </div>

        <!-- Participant Profile Summary Card -->
        <div class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center font-bold text-2xl
                    {{ $toddler->gender == 'M' ? 'bg-blue-50 text-blue-600' : 'bg-pink-50 text-pink-600' }}
                ">
                    {{ $toddler->gender == 'M' ? 'B' : 'G' }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">{{ $toddler->name }}</h2>
                    <p class="text-sm text-slate-500 mt-0.5">
                        {{ $toddler->gender == 'M' ? 'Laki-laki' : 'Perempuan' }} &bull;
                        {{ \Carbon\Carbon::parse($toddler->birth_date)->translatedFormat('d F Y') }} ({{ \Carbon\Carbon::parse($toddler->birth_date)->age }} tahun)
                    </p>
                    <p class="text-xs text-slate-400 mt-1">Orang Tua: {{ $toddler->user->name ?? '-' }}</p>
                </div>
            </div>

            <!-- Current Stats Overview -->
            <div class="flex gap-4 w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0">
                <div class="text-center flex-1 px-4 py-2 bg-slate-50 rounded-xl">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">BB Terakhir</span>
                    <p class="text-lg font-bold text-slate-800 mt-0.5">
                        {{ $measurements->last() ? $measurements->last()->weight_kg . ' kg' : '-' }}
                    </p>
                </div>
                <div class="text-center flex-1 px-4 py-2 bg-slate-50 rounded-xl">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">TB Terakhir</span>
                    <p class="text-lg font-bold text-slate-800 mt-0.5">
                        {{ $measurements->last() ? $measurements->last()->height_cm . ' cm' : '-' }}
                    </p>
                </div>
                <div class="text-center flex-1 px-4 py-2 bg-slate-50 rounded-xl">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">LK Terakhir</span>
                    <p class="text-lg font-bold text-slate-800 mt-0.5">
                        {{ $measurements->last() ? $measurements->last()->head_circumference_cm . ' cm' : '-' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Growth Charts Card -->
        @if(!$measurements->isEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-card title="Grafik Tumbuh Kembang (Berat & Tinggi)">
                    <div class="h-64">
                        <canvas id="weightHeightChart"></canvas>
                    </div>
                </x-card>
                <x-card title="Grafik Lingkar Kepala">
                    <div class="h-64">
                        <canvas id="headCircumferenceChart"></canvas>
                    </div>
                </x-card>
            </div>
            
            <!-- Load Chart.js CDN -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctx1 = document.getElementById('weightHeightChart').getContext('2d');
                    const ctx2 = document.getElementById('headCircumferenceChart').getContext('2d');
                    
                    const labels = [
                        @foreach($measurements as $record)
                            "{{ $record->created_at->translatedFormat('d M Y') }}",
                        @endforeach
                    ];
                    
                    const weightData = [
                        @foreach($measurements as $record)
                            {{ $record->weight_kg }},
                        @endforeach
                    ];
                    
                    const heightData = [
                        @foreach($measurements as $record)
                            {{ $record->height_cm }},
                        @endforeach
                    ];
                    
                    const headCircData = [
                        @foreach($measurements as $record)
                            {{ $record->head_circumference_cm }},
                        @endforeach
                    ];

                    new Chart(ctx1, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Berat Badan (kg)',
                                    data: weightData,
                                    borderColor: '#2563EB',
                                    backgroundColor: 'rgba(37, 99, 235, 0.05)',
                                    tension: 0.3,
                                    yAxisID: 'yWeight',
                                },
                                {
                                    label: 'Tinggi Badan (cm)',
                                    data: heightData,
                                    borderColor: '#EC4899',
                                    backgroundColor: 'rgba(236, 72, 153, 0.05)',
                                    tension: 0.3,
                                    yAxisID: 'yHeight',
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                yWeight: {
                                    type: 'linear',
                                    position: 'left',
                                    title: { display: true, text: 'Berat (kg)', font: { size: 10 } }
                                },
                                yHeight: {
                                    type: 'linear',
                                    position: 'right',
                                    title: { display: true, text: 'Tinggi (cm)', font: { size: 10 } },
                                    grid: { drawOnChartArea: false }
                                }
                            }
                        }
                    });

                    new Chart(ctx2, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Lingkar Kepala (cm)',
                                    data: headCircData,
                                    borderColor: '#10B981',
                                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
                                    tension: 0.3,
                                    fill: true,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    title: { display: true, text: 'Lingkar Kepala (cm)', font: { size: 10 } }
                                }
                            }
                        }
                    });
                });
            </script>
        @endif

        <!-- History of Measurements -->
        <x-card title="Kartu Menuju Sehat (KMS)" subtitle="Riwayat pengukuran tinggi, berat badan, lingkar kepala, dan imunisasi balita">
            @if($measurements->isEmpty())
                <div class="py-12 text-center text-slate-400">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="font-medium text-sm">Belum ada riwayat pemeriksaan terdaftar untuk balita ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase bg-slate-50/75">
                                <th class="px-5 py-3.5">Tanggal Periksa</th>
                                <th class="px-5 py-3.5">Kegiatan / Jadwal</th>
                                <th class="px-5 py-3.5 text-center">Berat Badan</th>
                                <th class="px-5 py-3.5 text-center">Tinggi Badan</th>
                                <th class="px-5 py-3.5 text-center">Lingkar Kepala</th>
                                <th class="px-5 py-3.5">Imunisasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($measurements as $record)
                                <tr class="hover:bg-slate-50/35 transition-colors">
                                    <td class="px-5 py-3.5 text-slate-800 font-medium">
                                        {{ $record->created_at->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-5 py-3.5 text-slate-500">
                                        {{ $record->schedule->title ?? 'Pemeriksaan Rutin' }}
                                    </td>
                                    <td class="px-5 py-3.5 text-center font-semibold text-blue-600">{{ $record->weight_kg }} kg</td>
                                    <td class="px-5 py-3.5 text-center font-semibold text-indigo-600">{{ $record->height_cm }} cm</td>
                                    <td class="px-5 py-3.5 text-center font-semibold text-emerald-600">{{ $record->head_circumference_cm }} cm</td>
                                    <td class="px-5 py-3.5">
                                        @if($record->immunization_type)
                                            <span class="px-2 py-1 bg-purple-50 text-purple-700 border border-purple-100 text-xs font-semibold rounded-md">
                                                {{ $record->immunization_type }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-card>
    </div>
</x-dynamic-component>
