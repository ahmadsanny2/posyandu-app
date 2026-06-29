<x-dynamic-component :component="auth()->user()->isParent() ? 'parent-layout' : 'app-layout'">
    <x-slot name="header">
        Detail Kesehatan Ibu Hamil
    </x-slot>

    <div class="space-y-6 max-w-5xl">
        <div class="mb-4">
            <a href="{{ route('pregnant-women.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">&larr; Kembali ke Daftar</a>
        </div>

        <!-- Participant Profile Summary Card -->
        <div class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center font-bold text-2xl">
                    W
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">{{ $pregnantWoman->name }}</h2>
                    <p class="text-sm text-slate-500 mt-0.5">
                        Usia Kandungan: {{ $pregnantWoman->pregnancy_age_weeks }} minggu &bull;
                        HPL: {{ \Carbon\Carbon::parse($pregnantWoman->estimated_delivery_date)->translatedFormat('d F Y') }}
                    </p>
                    <p class="text-xs text-slate-400 mt-1">Orang Tua/Suami: {{ $pregnantWoman->user->name ?? '-' }}</p>
                    @if($pregnantWoman->address)
                        <p class="text-xs text-slate-500 mt-1"><strong>Alamat:</strong> {{ $pregnantWoman->address }}</p>
                    @endif
                    @if($pregnantWoman->medical_history)
                        <p class="text-xs text-slate-500 mt-1"><strong>Riwayat Kesehatan:</strong> {{ $pregnantWoman->medical_history }}</p>
                    @endif
                </div>
            </div>

            <!-- Current Stats Overview -->
            <div class="flex gap-4 w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0">
                <div class="text-center flex-1 px-4 py-2 bg-slate-50 rounded-xl">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">BB Terakhir</span>
                    <p class="text-base font-bold text-slate-800 mt-0.5">
                        {{ $records->last() ? $records->last()->weight_kg . ' kg' : '-' }}
                    </p>
                </div>
                <div class="text-center flex-1 px-4 py-2 bg-slate-50 rounded-xl">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Tekanan Darah</span>
                    <p class="text-base font-bold text-slate-800 mt-0.5">
                        {{ $records->last() ? $records->last()->blood_pressure : '-' }}
                    </p>
                </div>
                <div class="text-center flex-1 px-4 py-2 bg-slate-50 rounded-xl">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">LILA</span>
                    <p class="text-base font-bold text-slate-800 mt-0.5">
                        {{ $records->last() ? $records->last()->upper_arm_circumference_cm . ' cm' : '-' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- History of Pregnancy Records -->
        <x-card title="Rekam Medis Kehamilan" subtitle="Riwayat pemeriksaan kehamilan bulanan">
            @if($records->isEmpty())
                <div class="py-12 text-center text-slate-400">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="font-medium text-sm">Belum ada riwayat rekam medis kehamilan untuk ibu ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase bg-slate-50/75">
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3 text-center">BB (kg)</th>
                                <th class="px-4 py-3 text-center">TD (mmHg)</th>
                                <th class="px-4 py-3 text-center">LILA (cm)</th>
                                <th class="px-4 py-3 text-center">UK (Minggu)</th>
                                <th class="px-4 py-3 text-center">DJA (dpm)</th>
                                <th class="px-4 py-3">Catatan & Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($records as $record)
                                <tr class="hover:bg-slate-50/35 transition-colors">
                                    <td class="px-4 py-3 text-slate-800 font-medium whitespace-nowrap">
                                        {{ $record->created_at->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-slate-600 font-semibold">{{ $record->weight_kg }}</td>
                                    <td class="px-4 py-3 text-center text-slate-600 font-semibold">{{ $record->blood_pressure }}</td>
                                    <td class="px-4 py-3 text-center text-slate-600 font-semibold">{{ $record->upper_arm_circumference_cm }}</td>
                                    <td class="px-4 py-3 text-center text-slate-600 font-semibold">{{ $record->gestational_age_weeks }}</td>
                                    <td class="px-4 py-3 text-center text-slate-600 font-semibold">{{ $record->fetal_heart_rate ?? '-' }}</td>
                                    <td class="px-4 py-3 text-slate-500 text-xs max-w-xs">{{ $record->action_notes }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-card>
    </div>
</x-dynamic-component>
