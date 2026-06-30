<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan Posyandu - {{ $monthName }} {{ $year }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            line-height: 1.4;
            padding: 10px;
            font-size: 12px;
        }
        .letterhead {
            text-align: center;
            border-bottom: 2px solid #1e293b;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .letterhead h1 {
            font-size: 18px;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
        }
        .letterhead p {
            margin: 3px 0 0 0;
            font-size: 11px;
            color: #475569;
        }
        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title h2 {
            font-size: 14px;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
        }
        .report-title p {
            margin: 3px 0 0 0;
            font-size: 11px;
            color: #475569;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #94a3b8;
            padding: 8px 10px;
            font-size: 10px;
            text-align: left;
        }
        table.data-table th {
            background-color: #f1f5f9;
            font-weight: bold;
        }
        .signature-table {
            width: 100%;
            border: none;
            margin-top: 30px;
        }
        .signature-table td {
            border: none;
            font-size: 11px;
            text-align: center;
        }
    </style>
</head>
<body>

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
        <div style="text-align: center; padding: 30px; color: #64748b; font-size: 12px; border: 1px dashed #cbd5e1; border-radius: 8px;">
            Tidak ada rekam medis terdaftar untuk periode bulan ini.
        </div>
    @else
        <table class="data-table">
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

    <!-- Signatures table -->
    <table class="signature-table">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%;">
                <p>Kota Sejahtera, {{ now()->translatedFormat('d F Y') }}</p>
                <p style="margin-top: 5px;">Ketua Posyandu RW</p>
                <div style="height: 60px;"></div>
                <p><strong>( ____________________ )</strong></p>
                <p style="font-size: 9px; color: #64748b; margin-top: 5px;">NIP. Posyandu-{{ $year }}-{{ $monthName }}</p>
            </td>
        </tr>
    </table>

</body>
</html>
