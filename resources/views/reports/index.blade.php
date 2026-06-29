<x-app-layout>
    <x-slot name="header">
        Laporan Kegiatan Posyandu
    </x-slot>

    <div class="space-y-6">
        <x-card title="Cetak Rekap Bulanan" subtitle="Pilih filter di bawah ini untuk mengunduh atau mencetak laporan resmi bulanan">
            <form method="GET" action="{{ route('reports.print') }}" target="_blank" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Report Type -->
                    <div>
                        <x-input-label for="report_type" value="Jenis Laporan" />
                        <select id="report_type" name="report_type" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow" required>
                            <option value="toddler">Laporan Pemeriksaan Balita (KMS)</option>
                            <option value="pregnant_woman">Laporan Pemeriksaan Ibu Hamil</option>
                            <option value="elderly">Laporan Pemeriksaan Lansia</option>
                        </select>
                    </div>

                    <!-- Month -->
                    <div>
                        <x-input-label for="month" value="Bulan" />
                        <select id="month" name="month" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow" required>
                            @foreach($months as $num => $name)
                                <option value="{{ $num }}" {{ now()->month == $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year -->
                    <div>
                        <x-input-label for="year" value="Tahun" />
                        <select id="year" name="year" class="mt-1 block w-full rounded-xl border-slate-200 text-sm focus:border-primary focus:ring focus:ring-blue-100 transition-shadow" required>
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ now()->year == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 mt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-semibold rounded-xl text-sm transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Buka & Cetak Laporan
                    </button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
