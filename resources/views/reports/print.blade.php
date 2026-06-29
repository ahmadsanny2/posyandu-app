<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan Posyandu - {{ $monthName }} {{ $year }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            line-height: 1.5;
            padding: 40px;
            background-color: #ffffff;
        }
        .no-print-header {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-print {
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-print:hover {
            background-color: #1d4ed8;
        }
        .letterhead {
            text-align: center;
            border-bottom: 3px double #1e293b;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .letterhead h1 {
            font-size: 22px;
            margin: 0;
            font-weight: 700;
            text-transform: uppercase;
        }
        .letterhead p {
            margin: 5px 0 0 0;
            font-size: 13px;
            color: #64748b;
        }
        .report-title {
            text-align: center;
            margin-bottom: 25px;
        }
        .report-title h2 {
            font-size: 18px;
            margin: 0;
            font-weight: 700;
        }
        .report-title p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #475569;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            font-size: 12px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            font-weight: 700;
        }
        .signature-block {
            float: right;
            text-align: center;
            margin-top: 30px;
            width: 250px;
            font-size: 13px;
        }
        .signature-space {
            height: 75px;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Non-printable top action bar -->
    <div class="no-print no-print-header">
        <div>
            <span style="font-weight: 600; font-size: 14px; color: #475569;">Laporan siap dicetak. Pastikan printer Anda terhubung.</span>
        </div>
        <button onclick="window.print()" class="btn-print">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.816l9.666-9.667a2.222 2.222 0 113.142 3.142L9.866 16.958a4.444 4.444 0 01-2.03 1.2L5 19l.842-2.836a4.444 4.444 0 011.203-2.03M6.72 13.816L5.25 15.25m1.47-1.434L9 15m-1.47-1.434l1.5-1.5m-3 3l.75-.75"/></svg>
            Cetak Sekarang
        </button>
    </div>

    <!-- Official Letterhead (KOP Surat) -->
    <div class="letterhead">
        <h1>Posyandu RW Karsa Bakti</h1>
        <p>Kelurahan Asri Jaya, Kecamatan Sukamakmur, Kota Sejahtera</p>
        <p>Telepon: 0812-3456-7890 | Email: info@posyandurw.or.id</p>
    </div>

    <!-- Title -->
    <div class="report-title">
        <h2>
            @if($reportType === 'toddler') LAPORAN BULANAN PEMERIKSAAN BALITA (KMS) @endif
            @if($reportType === 'pregnant_woman') LAPORAN BULANAN PEMERIKSAAN IBU HAMIL @endif
            @if($reportType === 'elderly') LAPORAN BULANAN PEMERIKSAAN KESEHATAN LANSIA @endif
        </h2>
        <p>Periode Kegiatan: {{ $monthName }} {{ $year }}</p>
    </div>

    <!-- Data Table -->
    @if($records->isEmpty())
        <div style="text-align: center; padding: 40px 0; color: #64748b; font-size: 14px; border: 1px dashed #cbd5e1; border-radius: 8px;">
            Tidak ada rekam medis terdaftar untuk periode bulan ini.
        </div>
    @else
        <table>
            <thead>
                @if($reportType === 'toddler')
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Balita</th>
                        <th>Keluarga (Parent)</th>
                        <th>Tanggal Periksa</th>
                        <th>Berat (kg)</th>
                        <th>Tinggi (cm)</th>
                        <th>Lingkar Kepala (cm)</th>
                        <th>Imunisasi</th>
                    </tr>
                @elseif($reportType === 'pregnant_woman')
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Ibu Hamil</th>
                        <th>Suami / Penanggung Jawab</th>
                        <th>Tanggal Periksa</th>
                        <th>Berat (kg)</th>
                        <th>Tekanan Darah</th>
                        <th>LILA (cm)</th>
                        <th>Usia Hamil (Minggu)</th>
                        <th>Tindakan / Konseling</th>
                    </tr>
                @elseif($reportType === 'elderly')
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Lansia</th>
                        <th>Keluarga Penanggung Jawab</th>
                        <th>Tanggal Periksa</th>
                        <th>Berat (kg)</th>
                        <th>Tekanan Darah</th>
                        <th>Gula Darah</th>
                        <th>Kolesterol</th>
                        <th>Asam Urat</th>
                    </tr>
                @endif
            </thead>
            <tbody>
                @foreach($records as $index => $record)
                    @if($reportType === 'toddler')
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $record->toddler->name }}</strong></td>
                            <td>{{ $record->toddler->user->name ?? '-' }}</td>
                            <td>{{ $record->created_at->translatedFormat('d M Y') }}</td>
                            <td>{{ $record->weight_kg }} kg</td>
                            <td>{{ $record->height_cm }} cm</td>
                            <td>{{ $record->head_circumference_cm }} cm</td>
                            <td>{{ $record->immunization_type ?? '-' }}</td>
                        </tr>
                    @elseif($reportType === 'pregnant_woman')
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $record->pregnantWoman->name }}</strong></td>
                            <td>{{ $record->pregnantWoman->user->name ?? '-' }}</td>
                            <td>{{ $record->created_at->translatedFormat('d M Y') }}</td>
                            <td>{{ $record->weight_kg }} kg</td>
                            <td>{{ $record->blood_pressure }} mmHg</td>
                            <td>{{ $record->upper_arm_circumference_cm }} cm</td>
                            <td>{{ $record->gestational_age_weeks }} minggu</td>
                            <td>{{ $record->action_notes }}</td>
                        </tr>
                    @elseif($reportType === 'elderly')
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $record->elderly->name }}</strong></td>
                            <td>{{ $record->elderly->user->name ?? '-' }}</td>
                            <td>{{ $record->created_at->translatedFormat('d M Y') }}</td>
                            <td>{{ $record->weight_kg ?? '-' }} kg</td>
                            <td>{{ $record->blood_pressure }} mmHg</td>
                            <td>{{ $record->blood_sugar ? $record->blood_sugar . ' mg/dL' : '-' }}</td>
                            <td>{{ $record->cholesterol ? $record->cholesterol . ' mg/dL' : '-' }}</td>
                            <td>{{ $record->uric_acid ? $record->uric_acid . ' mg/dL' : '-' }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Signatures block -->
    <div class="signature-block">
        <p>Kota Sejahtera, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Ketua Posyandu RW</p>
        <div class="signature-space"></div>
        <p><strong>( ____________________ )</strong></p>
        <p style="font-size: 11px; color: #64748b;">NIP. Posyandu-{{ $year }}-{{ $monthName }}</p>
    </div>

</body>
</html>
