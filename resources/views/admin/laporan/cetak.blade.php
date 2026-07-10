<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Laporan Surat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        @media screen {
            body { background: #f3f4f6; }
            .print-container {
                max-width: 210mm;
                margin: 20px auto;
                background: white;
                padding: 20mm 25mm;
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
                min-height: 297mm;
            }
        }
        @media print {
            @page { size: A4 landscape; margin: 15mm 20mm; }
            body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; }
            .print-container { padding: 0; margin: 0; box-shadow: none; }
        }
        .report-table { border-collapse: collapse; width: 100%; font-family: 'Times New Roman', Times, serif; font-size: 11pt; }
        .report-table th, .report-table td { border: 1px solid #000; padding: 6px 10px; }
        .report-table th { background-color: #f0f0f0; font-weight: bold; text-align: center; }
        .report-table td { text-align: left; }
    </style>
</head>
<body>
    {{-- Action Buttons --}}
    <div class="no-print fixed top-4 right-4 z-50 flex gap-2">
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 shadow-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m0 0a48.497 48.497 0 0110.5 0m-10.5 0V4.875c0-.621.504-1.125 1.125-1.125h8.25c.621 0 1.125.504 1.125 1.125V6.93" />
            </svg>
            Cetak
        </button>
        <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 shadow-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="print-container">
        {{-- Header --}}
        <div style="text-align: center; margin-bottom: 20px; font-family: 'Times New Roman', Times, serif;">
            <p style="font-size: 13pt; font-weight: bold; margin: 0;">PEMERINTAH KABUPATEN KUNINGAN</p>
            <p style="font-size: 13pt; font-weight: bold; margin: 0;">KECAMATAN CIGUGUR</p>
            <p style="font-size: 14pt; font-weight: bold; margin: 0; letter-spacing: 1px;">KANTOR KEPALA DESA BABAKANMULYA</p>
            <hr style="border: 2px solid #000; margin: 8px 0 4px;">
            <hr style="border: 0.5px solid #000; margin: 0 0 15px;">
        </div>

        <div style="text-align: center; margin-bottom: 20px; font-family: 'Times New Roman', Times, serif;">
            <p style="font-size: 13pt; font-weight: bold; text-decoration: underline;">LAPORAN DATA SURAT KETERANGAN</p>
            <p style="font-size: 11pt;">Bulan {{ \Carbon\Carbon::createFromDate(null, (int)$bulan)->locale('id')->isoFormat('MMMM') }} Tahun {{ $tahun }}</p>
        </div>

        {{-- Table --}}
        @if($pengajuans->count() > 0)
            <table class="report-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th>Tanggal</th>
                        <th>NIK</th>
                        <th>Nama Pemohon</th>
                        <th>Jenis Surat</th>
                        <th>Keperluan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuans as $index => $pengajuan)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan)->format('d/m/Y') }}</td>
                            <td>{{ $pengajuan->user->nik ?? '-' }}</td>
                            <td>{{ $pengajuan->user->name ?? '-' }}</td>
                            <td>{{ $pengajuan->jenis_surat }}</td>
                            <td>{{ $pengajuan->keperluan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p style="font-family: 'Times New Roman', Times, serif; font-size: 11pt; margin-top: 10px;">
                <strong>Total: {{ $pengajuans->count() }} surat</strong>
            </p>
        @else
            <p style="font-family: 'Times New Roman', Times, serif; text-align: center; padding: 40px 0; font-style: italic; color: #666;">
                Tidak ada data surat untuk periode ini.
            </p>
        @endif

        {{-- Signature --}}
        <div style="margin-top: 40px; font-family: 'Times New Roman', Times, serif; font-size: 12pt;">
            <table width="100%">
                <tr>
                    <td width="60%"></td>
                    <td width="40%" style="text-align: center;">
                        <p style="margin-bottom: 0;">Babakanmulya, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
                        <p style="margin-bottom: 70px;">Kepala Desa Babakanmulya</p>
                        <p style="margin-bottom: 0; text-decoration: underline; font-weight: bold;">{{ $pengaturan->nama_kades ?? '................................' }}</p>
                        <p style="margin: 0;">NIP. {{ $pengaturan->nip_kades ?? '................................' }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        // Print is triggered manually by clicking the Cetak button
    </script>
</body>
</html>
