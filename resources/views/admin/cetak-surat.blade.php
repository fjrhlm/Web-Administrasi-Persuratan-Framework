<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Surat - {{ $pengajuan->jenis_surat }}</title>
    <style>
        /* ========== RESET ========== */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
        }

        /* ========== SCREEN VIEW ========== */
        @media screen {
            body { background: #d1d5db; padding: 30px 0; }
            .page {
                width: 210mm;
                min-height: 297mm;
                margin: 0 auto;
                background: #fff;
                box-shadow: 0 4px 24px rgba(0,0,0,0.18);
                padding: 18mm 25mm 0 25mm;
                display: flex;
                flex-direction: column;
                position: relative;
            }
        }

        /* ========== PRINT ========== */
        @media print {
            @page { size: A4; margin: 18mm 25mm 10mm 25mm; }
            body { background: #fff; padding: 0; }
            .page { width: auto; min-height: auto; padding: 0; box-shadow: none; margin: 0; }
            .no-print { display: none !important; }
        }

        /* ========== ACTION BUTTONS (screen only) ========== */
        .no-print {
            position: fixed; top: 16px; right: 16px; z-index: 50;
            display: flex; gap: 8px; font-family: 'Segoe UI', sans-serif;
        }
        .no-print button, .no-print a {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 20px; font-size: 14px; font-weight: 500;
            border-radius: 8px; border: none; cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2); text-decoration: none;
        }
        .no-print .btn-cetak { background: #16a34a; color: #fff; }
        .no-print .btn-cetak:hover { background: #15803d; }
        .no-print .btn-back { background: #4b5563; color: #fff; }
        .no-print .btn-back:hover { background: #374151; }

        /* ========== KOP SURAT ========== */
        .kop { text-align: center; padding-bottom: 10px; border-bottom: 3px solid #000; margin-bottom: 18px; }
        .kop img { width: 60px; height: auto; display: block; margin: 0 auto 6px; }
        .kop-text { font-weight: bold; font-style: italic; font-size: 12pt; line-height: 1.4; }

        /* ========== JUDUL SURAT ========== */
        .judul { text-align: center; margin-bottom: 18px; }
        .judul h2 { font-size: 12pt; font-weight: bold; font-style: italic; text-decoration: underline; margin-bottom: 2px; }
        .judul p { font-size: 11pt; }

        /* ========== DATA TABLE ========== */
        .data-tbl { border-collapse: collapse; margin-left: 20px; }
        .data-tbl td { padding: 2px 0; vertical-align: top; font-size: 12pt; line-height: 1.5; }
        .data-tbl .lbl { width: 155px; white-space: nowrap; }
        .data-tbl .sep { width: 15px; text-align: center; }

        /* ========== BODY TEXT ========== */
        .section { margin-bottom: 12px; }
        .section-title { margin-bottom: 4px; }
        .indent { text-indent: 40px; }
        .body-text { text-align: justify; line-height: 1.6; margin-bottom: 10px; }

        /* ========== TTD ========== */
        .ttd-wrap { margin-top: 20px; }
        .ttd-wrap table { width: 100%; border-collapse: collapse; }
        .ttd-wrap td { vertical-align: top; }
        .ttd-right { text-align: center; }
        .ttd-right img { width: 90px; height: auto; margin: 8px 0 4px; }
        .nip { color: #c0392b; font-size: 11pt; }

        /* ========== CAMAT SECTION ========== */
        .camat-section { margin-top: 20px; }
        .camat-section p { line-height: 1.5; }

        /* ========== FOOTER ========== */
        .surat-content { flex: 1; }
        .footer {
            border-top: 2px solid #000;
            padding-top: 6px;
            text-align: center;
            font-size: 9pt;
            line-height: 1.4;
            margin-top: auto;
            padding-bottom: 10mm;
        }
    </style>
</head>
<body>
    {{-- Tombol Cetak & Kembali --}}
    <div class="no-print">
        <button class="btn-cetak" onclick="window.print()">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m0 0a48.497 48.497 0 0110.5 0m-10.5 0V4.875c0-.621.504-1.125 1.125-1.125h8.25c.621 0 1.125.504 1.125 1.125V6.93"/></svg>
            Cetak
        </button>
        <a class="btn-back" href="{{ route('admin.kelola-surat.show', $pengajuan->id) }}">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="page">
        {{-- === KONTEN SURAT === --}}
        <div class="surat-content">

            {{-- KOP --}}
            <div class="kop">
                <img src="{{ asset('storage/img/logo_garuda.png') }}" alt="Garuda">
                <div class="kop-text">KEPALA DESA BABAKANMULYA</div>
                <div class="kop-text">KECAMATAN CIGUGUR KABUPATEN KUNINGAN</div>
            </div>

            {{-- JUDUL --}}
            <div class="judul">
                @php
                    $judulSurat = match($pengajuan->jenis_surat) {
                        'SKTM' => 'SURAT KETERANGAN MISKIN',
                        'SKU' => 'SURAT KETERANGAN USAHA MIKRO DAN KECIL',
                        'Domisili' => 'SURAT KETERANGAN DOMISILI',
                        'Pengantar SKCK' => 'SURAT PENGANTAR SKCK',
                        'Belum Menikah' => 'SURAT KETERANGAN BELUM MENIKAH',
                        'Kematian' => 'SURAT KETERANGAN KEMATIAN / AHLI WARIS',
                        'Kelahiran' => 'SURAT KETERANGAN KELAHIRAN',
                        'Penghasilan Orang Tua' => 'SURAT KETERANGAN PENGHASILAN ORANG TUA',
                        'Pindah Penduduk' => 'SURAT KETERANGAN PINDAH PENDUDUK',
                        default => 'SURAT KETERANGAN',
                    };
                @endphp
                <h2>{{ $judulSurat }}</h2>
                <p>Nomor : {{ $nomorSurat }}</p>
            </div>

            {{-- YANG BERTANDA TANGAN --}}
            <div class="section">
                <p class="section-title">Yang bertanda tangan di bawah ini :</p>
                <table class="data-tbl">
                    <tr>
                        <td class="lbl">Nama</td>
                        <td class="sep">:</td>
                        <td><strong>{{ $pengaturan->nama_kades ?? '..............................' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="lbl">Jabatan</td>
                        <td class="sep">:</td>
                        <td>{{ $pengaturan->jabatan ?? 'Kepala Desa Babakanmulya' }}</td>
                    </tr>
                </table>
            </div>

            {{-- DENGAN INI MENERANGKAN --}}
            <div class="section">
                <p class="section-title">Dengan ini menerangkan bahwa :</p>
                <table class="data-tbl">
                    <tr>
                        <td class="lbl">Nama</td>
                        <td class="sep">:</td>
                        <td><strong>{{ $pengajuan->user->name ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="lbl">NIK</td>
                        <td class="sep">:</td>
                        <td>{{ $pengajuan->user->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Tempat Tanggal Lahir</td>
                        <td class="sep">:</td>
                        <td>{{ $pengajuan->user->tempat_tgl_lahir ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Pekerjaan</td>
                        <td class="sep">:</td>
                        <td>{{ $pengajuan->user->pekerjaan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Agama</td>
                        <td class="sep">:</td>
                        <td>{{ $pengajuan->user->agama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Alamat</td>
                        <td class="sep">:</td>
                        <td>{{ $pengajuan->user->alamat ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            {{-- MAKSUD --}}
            <div class="section">
                <table class="data-tbl">
                    @if($pengajuan->jenis_surat == 'SKTM')
                        <tr>
                            <td class="lbl">Maksud</td>
                            <td class="sep">:</td>
                            <td style="text-align:justify;">Orang tersebut diatas Benar Penduduk Desa Kami, Dan termasuk dari <strong>Keluarga Miskin (Tidak Mampu)</strong> dalam Segi Perekonomian.</td>
                        </tr>
                    @elseif($pengajuan->jenis_surat == 'Domisili')
                        <tr>
                            <td class="lbl">Maksud</td>
                            <td class="sep">:</td>
                            <td style="text-align:justify;">Benar orang tersebut diatas <strong>berdomisili</strong> di Desa kami, Tepatnya di {{ $pengajuan->user->alamat ?? '-' }}.</td>
                        </tr>
                    @elseif($pengajuan->jenis_surat == 'SKU')
                        <tr>
                            <td class="lbl">Maksud</td>
                            <td class="sep">:</td>
                            <td style="text-align:justify;">Yang bersangkutan mempunyai usaha..................................<br>Sepanjang sepengetahuan kami baik sifat maupun tempat usahanya tidak mengganggu ketertiban umum dan tidak bertentangan dengan peraturan Pemerintah setempat.</td>
                        </tr>
                    @elseif($pengajuan->jenis_surat == 'Pengantar SKCK')
                        <tr>
                            <td class="lbl">Maksud</td>
                            <td class="sep">:</td>
                            <td style="text-align:justify;">Orang tersebut diatas benar berkelakuan baik dan belum pernah tersangkut perkara polisi/kriminal. Surat ini dibuat untuk keperluan pengurusan <strong>SKCK (Surat Keterangan Catatan Kepolisian)</strong>.</td>
                        </tr>
                    @elseif($pengajuan->jenis_surat == 'Belum Menikah')
                        <tr>
                            <td class="lbl">Maksud</td>
                            <td class="sep">:</td>
                            <td style="text-align:justify;">Berdasarkan catatan yang ada di Desa kami, orang tersebut diatas statusnya saat ini benar <strong>BELUM PERNAH MENIKAH / KAWIN</strong> dengan siapapun.</td>
                        </tr>
                    @elseif($pengajuan->jenis_surat == 'Kematian')
                        <tr>
                            <td class="lbl">Maksud</td>
                            <td class="sep">:</td>
                            <td style="text-align:justify;">Surat keterangan ini diberikan kepada yang bersangkutan untuk pengurusan administrasi ahli waris / kematian.</td>
                        </tr>
                    @elseif($pengajuan->jenis_surat == 'Kelahiran')
                        <tr>
                            <td class="lbl">Maksud</td>
                            <td class="sep">:</td>
                            <td style="text-align:justify;">Surat Keterangan ini dibuat sebagai pengantar untuk persyaratan pembuatan <strong>Akta Kelahiran</strong>.</td>
                        </tr>
                    @elseif($pengajuan->jenis_surat == 'Penghasilan Orang Tua')
                        <tr>
                            <td class="lbl">Maksud</td>
                            <td class="sep">:</td>
                            <td style="text-align:justify;">Orang tersebut diatas selaku orang tua / wali, menerangkan rincian penghasilannya. Surat ini dibuat untuk keperluan pengajuan beasiswa / administrasi pendidikan anak.</td>
                        </tr>
                    @elseif($pengajuan->jenis_surat == 'Pindah Penduduk')
                        <tr>
                            <td class="lbl">Maksud</td>
                            <td class="sep">:</td>
                            <td style="text-align:justify;">Orang tersebut diatas bermaksud untuk pindah domisili dari Desa Babakanmulya ke alamat baru. Surat ini dibuat sebagai pengantar pindah ke kecamatan/kabupaten tujuan.</td>
                        </tr>
                    @else
                        <tr>
                            <td class="lbl">Maksud</td>
                            <td class="sep">:</td>
                            <td>{{ $pengajuan->keperluan ?? '-' }}</td>
                        </tr>
                    @endif
                </table>
            </div>

            {{-- PENUTUP --}}
            <div class="section" style="margin-top: 16px;">
                <p class="indent body-text">Demikian surat keterangan ini dibuat dengan sebenarnya, agar dapat dipergunakan sebagaimana mestinya.</p>
            </div>

            {{-- TANDA TANGAN --}}
            @if($pengajuan->jenis_surat == 'SKTM')
                {{-- SKTM: TTD Kades kanan atas + Camat kiri bawah --}}
                <div class="ttd-wrap">
                    <table>
                        <tr>
                            <td width="50%">&nbsp;</td>
                            <td width="50%" class="ttd-right">
                                <p>Babakanmulya, {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
                                <p><strong>KEPALA DESA BABAKANMULYA</strong></p>
                                <img src="{{ asset('storage/img/ttd.png') }}" alt="TTD">
                                <p><strong><u>{{ $pengaturan->nama_kades ?? '..............................' }}</u></strong></p>
                                <p class="nip">NIP. {{ $pengaturan->nip_kades ?? '..............................' }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="camat-section">
                    <p>Cigugur, ................................</p>
                    <p>No. ................................</p>
                    <p><strong>CAMAT CIGUGUR</strong></p>
                    <br><br><br>
                    <p>................................</p>
                </div>
            @else
                {{-- Domisili & SKU: TTD Kades saja di kanan --}}
                <div class="ttd-wrap">
                    <table>
                        <tr>
                            <td width="50%">&nbsp;</td>
                            <td width="50%" class="ttd-right">
                                <p>Babakanmulya, {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
                                <p><strong>KEPALA DESA BABAKANMULYA</strong></p>
                                <img src="{{ asset('storage/img/ttd.png') }}" alt="TTD">
                                <p><strong><u>{{ $pengaturan->nama_kades ?? '..............................' }}</u></strong></p>
                                <p class="nip">NIP. {{ $pengaturan->nip_kades ?? '..............................' }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
            @endif

        </div>{{-- / surat-content --}}

        {{-- FOOTER --}}
        <div class="footer">
            <p>Jalan Desa Babakanmulya Dusun Cirabak Rt 11 Rw 04</p>
            <p>Website : desa-babakanmulya-cigugur.kuningankab.go.id</p>
            <p><strong>KEC. CIGUGUR - KAB. KUNINGAN - 45552</strong></p>
        </div>

    </div>{{-- / page --}}
</body>
</html>
