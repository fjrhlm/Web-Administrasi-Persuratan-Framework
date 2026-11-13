# -*- coding: utf-8 -*-
"""
Script untuk menghasilkan Laporan Perancangan Use Case Diagram dan Basis Data
dalam format DOCX dengan formatting yang sesuai ketentuan dosen.
"""

from docx import Document
from docx.shared import Pt, Cm, Inches, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT
from docx.enum.section import WD_ORIENT
from docx.oxml.ns import qn, nsdecls
from docx.oxml import parse_xml
import os

OUTPUT_PATH = os.path.join(os.path.dirname(os.path.abspath(__file__)),
                           "Laporan_Perancangan_UseCase_Database.docx")

def set_cell_shading(cell, color_hex):
    """Set background color of a table cell."""
    shading = parse_xml(f'<w:shd {nsdecls("w")} w:fill="{color_hex}"/>')
    cell._tc.get_or_add_tcPr().append(shading)

def set_cell_border(cell, **kwargs):
    """Set cell border for table cells."""
    tc = cell._tc
    tcPr = tc.get_or_add_tcPr()
    tcBorders = parse_xml(f'<w:tcBorders {nsdecls("w")}></w:tcBorders>')
    for edge, val in kwargs.items():
        element = parse_xml(
            f'<w:{edge} {nsdecls("w")} w:val="{val["val"]}" '
            f'w:sz="{val["sz"]}" w:space="0" w:color="{val["color"]}"/>'
        )
        tcBorders.append(element)
    tcPr.append(tcBorders)

def make_paragraph(doc, text, font_size=12, bold=False, italic=False,
                   alignment=WD_ALIGN_PARAGRAPH.JUSTIFY, space_after=6,
                   space_before=0, first_line_indent=None, color=None):
    """Create a formatted paragraph."""
    p = doc.add_paragraph()
    p.alignment = alignment
    p.paragraph_format.space_after = Pt(space_after)
    p.paragraph_format.space_before = Pt(space_before)
    p.paragraph_format.line_spacing = 1.5
    if first_line_indent:
        p.paragraph_format.first_line_indent = Cm(first_line_indent)
    run = p.add_run(text)
    run.font.name = 'Times New Roman'
    run.font.size = Pt(font_size)
    run.bold = bold
    run.italic = italic
    if color:
        run.font.color.rgb = color
    return p

def make_heading(doc, text, level=1):
    """Create a heading with Times New Roman font."""
    if level == 1:
        # BAB heading - centered, bold, 16pt
        p = make_paragraph(doc, text, font_size=16, bold=True,
                           alignment=WD_ALIGN_PARAGRAPH.CENTER,
                           space_after=6, space_before=24)
    elif level == 2:
        # Sub heading - left, bold, 14pt
        p = make_paragraph(doc, text, font_size=14, bold=True,
                           alignment=WD_ALIGN_PARAGRAPH.LEFT,
                           space_after=6, space_before=18)
    elif level == 3:
        # Sub-sub heading - left, bold, 12pt
        p = make_paragraph(doc, text, font_size=12, bold=True,
                           alignment=WD_ALIGN_PARAGRAPH.LEFT,
                           space_after=6, space_before=12)
    return p

def add_table(doc, headers, rows, col_widths=None):
    """Create a formatted table with header row shading."""
    table = doc.add_table(rows=1 + len(rows), cols=len(headers))
    table.alignment = WD_TABLE_ALIGNMENT.CENTER
    table.style = 'Table Grid'

    # Header row
    for i, header in enumerate(headers):
        cell = table.rows[0].cells[i]
        cell.text = ''
        p = cell.paragraphs[0]
        p.alignment = WD_ALIGN_PARAGRAPH.CENTER
        run = p.add_run(header)
        run.font.name = 'Times New Roman'
        run.font.size = Pt(10)
        run.bold = True
        run.font.color.rgb = RGBColor(0xFF, 0xFF, 0xFF)
        set_cell_shading(cell, "2E4057")

    # Data rows
    for r_idx, row_data in enumerate(rows):
        for c_idx, cell_text in enumerate(row_data):
            cell = table.rows[r_idx + 1].cells[c_idx]
            cell.text = ''
            p = cell.paragraphs[0]
            p.alignment = WD_ALIGN_PARAGRAPH.LEFT
            run = p.add_run(str(cell_text))
            run.font.name = 'Times New Roman'
            run.font.size = Pt(10)
            # Alternate row shading
            if r_idx % 2 == 1:
                set_cell_shading(cell, "F2F2F2")

    # Set column widths if provided
    if col_widths:
        for i, width in enumerate(col_widths):
            for row in table.rows:
                row.cells[i].width = Cm(width)

    doc.add_paragraph()  # spacer
    return table

def add_actor_table(doc):
    """Create the actor mapping table."""
    headers = ["Aktor", "Deskripsi Peran"]
    rows = [
        ["Warga",
         "Anggota masyarakat Desa Babakanmulya yang telah terverifikasi emailnya. "
         "Warga dapat mengajukan permohonan surat, mengunggah dokumen persyaratan, "
         "serta memantau status pengajuan mereka secara mandiri."],
        ["Admin Desa",
         "Aparatur Pemerintah Desa yang bertugas memverifikasi kelengkapan berkas warga, "
         "mengubah status pengajuan (Menunggu, Diproses, Selesai, Ditolak), mencetak surat "
         "resmi desa, serta mengonfigurasi data Kepala Desa untuk kop surat."],
    ]
    add_table(doc, headers, rows, col_widths=[3.5, 12.0])

def build_cover_page(doc):
    """Build the cover/title page."""
    # Add spacing before title
    for _ in range(4):
        make_paragraph(doc, '', font_size=12)

    make_paragraph(doc, 'LAPORAN PERANCANGAN', font_size=16, bold=True,
                   alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=4)
    make_paragraph(doc, 'USE CASE DIAGRAM DAN BASIS DATA', font_size=16, bold=True,
                   alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=18)

    make_paragraph(doc, 'Sistem Informasi Administrasi Persuratan', font_size=14, bold=True,
                   alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=2)
    make_paragraph(doc, 'Desa Babakanmulya', font_size=14, bold=True,
                   alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=2)
    make_paragraph(doc, 'Kecamatan Cigugur, Kabupaten Kuningan', font_size=14, bold=True,
                   alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=36)

    make_paragraph(doc, 'PEMERINTAH DESA BABAKANMULYA', font_size=14, bold=True,
                   alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=2)
    make_paragraph(doc, 'KECAMATAN CIGUGUR KABUPATEN KUNINGAN', font_size=14, bold=True,
                   alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=48)

    for _ in range(3):
        make_paragraph(doc, '', font_size=12)

    make_paragraph(doc, 'Disusun Oleh:', font_size=12,
                   alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=4)
    make_paragraph(doc, 'Fajar Halim (20240810047)', font_size=14, bold=True,
                   alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=48)

    for _ in range(2):
        make_paragraph(doc, '', font_size=12)

    make_paragraph(doc, '2026', font_size=14, bold=True,
                   alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=0)

    doc.add_page_break()

def build_bab1(doc):
    """Build BAB I - PENDAHULUAN."""
    make_heading(doc, 'BAB I', level=1)
    make_heading(doc, 'PENDAHULUAN', level=1)

    make_paragraph(doc, '', font_size=6, space_after=6)

    make_paragraph(doc,
        'Sistem Informasi Administrasi Persuratan Desa Babakanmulya dirancang untuk '
        'mendigitalisasi proses pelayanan surat-menyurat yang sebelumnya dilakukan '
        'secara konvensional (manual). Pengajuan surat keterangan oleh warga, proses '
        'verifikasi berkas oleh aparatur desa, hingga pencetakan surat resmi dengan '
        'penomoran otomatis, seluruhnya diintegrasikan ke dalam sebuah platform '
        'berbasis web menggunakan Laravel Framework.',
        first_line_indent=1.25, space_after=12)

    make_paragraph(doc,
        'Laporan ini menyajikan dokumen rancangan teknis yang komprehensif, mencakup '
        'Use Case Diagram sebagai representasi visual interaksi antara aktor (Warga dan Admin Desa) '
        'dengan fungsi-fungsi utama sistem, serta perancangan skema basis data fisik '
        '(Logical Schema) yang diimplementasikan pada database SQLite.',
        first_line_indent=1.25, space_after=12)

    make_paragraph(doc,
        'Sistem ini melayani 9 jenis surat keterangan resmi, yaitu: Surat Keterangan '
        'Tidak Mampu (SKTM), Surat Keterangan Usaha (SKU), Surat Keterangan Domisili, '
        'Surat Pengantar SKCK, Surat Keterangan Belum Menikah, Surat Keterangan '
        'Kematian/Ahli Waris, Surat Keterangan Kelahiran, Surat Keterangan Penghasilan '
        'Orang Tua, dan Surat Keterangan Pindah Penduduk.',
        first_line_indent=1.25, space_after=12)

    doc.add_page_break()

def build_bab2(doc):
    """Build BAB II - PERANCANGAN USE CASE DIAGRAM."""
    make_heading(doc, 'BAB II', level=1)
    make_heading(doc, 'PERANCANGAN USE CASE DIAGRAM', level=1)

    make_paragraph(doc, '', font_size=6, space_after=6)

    make_paragraph(doc,
        'Use Case Diagram mendeskripsikan interaksi antara aktor luar dengan fungsi-fungsi '
        'utama yang disediakan oleh sistem. Sistem ini melibatkan dua aktor utama: '
        'Warga (masyarakat desa yang telah terdaftar) dan Admin Desa (aparatur pemerintah '
        'desa yang mengelola administrasi persuratan).',
        first_line_indent=1.25, space_after=12)

    # Placeholder for Use Case Diagram Image
    make_paragraph(doc, '[Sisipkan Gambar Use Case Diagram di sini]',
                   font_size=11, italic=True,
                   alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=4)
    make_paragraph(doc, 'Gambar 2.1 Use Case Diagram Sistem Informasi Administrasi Persuratan Desa Babakanmulya',
                   font_size=10, italic=True,
                   alignment=WD_ALIGN_PARAGRAPH.CENTER, space_after=18)

    # 2.1 Pemetaan Aktor
    make_heading(doc, '2.1 Pemetaan Aktor dan Use Case', level=2)
    add_actor_table(doc)

    make_paragraph(doc,
        'Tabel di atas memetakan aktor-aktor yang berinteraksi langsung dengan sistem. '
        'Setiap aktor dibatasi oleh hak akses (Role-Based Access Control) yang diatur '
        'melalui middleware Laravel. Warga yang belum terverifikasi emailnya tidak dapat '
        'mengakses fitur apapun selain halaman verifikasi, sementara Admin memiliki akses '
        'penuh terhadap seluruh fitur pengelolaan.',
        first_line_indent=1.25, space_after=12)

    # 2.2 Penjelasan Proses Bisnis
    make_heading(doc, '2.2 Penjelasan Proses Bisnis Inti (Use Case Details)', level=2)

    use_cases = [
        ('Registrasi Akun',
         'Warga mengisi formulir pendaftaran yang berisi NIK (16 digit), Nama Lengkap, '
         'Email Aktif, dan Password. Setelah submit, sistem akan mengirimkan link '
         'verifikasi ke alamat email yang didaftarkan. Warga tidak dapat login atau '
         'menggunakan fitur apapun sebelum email berhasil diverifikasi.'),
        ('Verifikasi Email',
         'Warga membuka inbox Gmail dan mengeklik tautan verifikasi yang dikirimkan oleh '
         'sistem. Setelah berhasil diklik, kolom email_verified_at pada database akan '
         'terisi timestamp dan warga diizinkan untuk login ke dashboard.'),
        ('Login Akun',
         'Warga dan Admin masuk ke sistem melalui satu halaman login yang sama. Sistem '
         'secara cerdas mengenali apakah input berupa Email, NIK (16 digit angka), atau '
         'Username, kemudian mengarahkan ke dashboard sesuai role masing-masing.'),
        ('Mengajukan Surat Baru',
         'Warga memilih salah satu dari 9 jenis surat keterangan yang tersedia. '
         'Persyaratan dokumen yang wajib diunggah berubah secara dinamis sesuai jenis '
         'surat (misalnya Surat Kematian meminta KTP Almarhum, Surat Kelahiran meminta '
         'Surat Lahir dari RS/Bidan). File yang diunggah divalidasi formatnya '
         '(JPG/PNG/PDF) dan dibatasi maksimal 2MB per file.'),
        ('Melihat Status dan Riwayat Pengajuan',
         'Warga dapat memantau seluruh riwayat pengajuan surat yang pernah diajukan '
         'beserta status terkini (Menunggu, Diproses, Selesai, atau Ditolak). Jika '
         'ditolak, warga dapat melihat catatan alasan penolakan dari admin.'),
        ('Mengubah Profil',
         'Warga melengkapi atau memperbarui data pribadi seperti alamat, nomor HP, '
         'pekerjaan, agama, dan tempat tanggal lahir. Data ini secara otomatis akan '
         'terisi ke dalam template surat resmi saat dicetak oleh admin.'),
        ('Mengelola Pengajuan Surat (Admin)',
         'Admin memverifikasi kelengkapan berkas yang diunggah warga dan mengubah '
         'status pengajuan. Alur perubahan status: Menunggu → Diproses → Selesai/Ditolak. '
         'Admin dapat menambahkan catatan keterangan pada setiap perubahan status. '
         'Daftar pengajuan ditampilkan dalam format tabel dengan fitur pagination '
         '(10 baris per halaman) dan filter berdasarkan status.'),
        ('Mencetak Surat Resmi (Admin)',
         'Untuk pengajuan berstatus Selesai, admin dapat mencetak surat resmi desa '
         'dalam format A4 yang dilengkapi kop surat, penomoran otomatis berdasarkan '
         'kode klasifikasi surat pemerintah (contoh: 474.1 untuk Kelahiran, 332 untuk '
         'SKCK), konversi bulan ke Romawi, paragraf isi yang menyesuaikan jenis surat, '
         'serta tanda tangan Kepala Desa.'),
        ('Mengatur Konfigurasi Kepala Desa (Admin)',
         'Admin memperbarui data nama Kepala Desa, NIP, dan jabatan yang sedang menjabat. '
         'Data ini secara otomatis ditarik oleh sistem ke dalam template kop surat resmi '
         'setiap kali dilakukan pencetakan surat.'),
    ]

    for title, desc in use_cases:
        p = doc.add_paragraph()
        p.paragraph_format.line_spacing = 1.5
        p.paragraph_format.space_after = Pt(8)
        # Bullet point style
        run_title = p.add_run(f'• {title}: ')
        run_title.font.name = 'Times New Roman'
        run_title.font.size = Pt(12)
        run_title.bold = True
        run_desc = p.add_run(desc)
        run_desc.font.name = 'Times New Roman'
        run_desc.font.size = Pt(12)

    doc.add_page_break()

def build_bab3(doc):
    """Build BAB III - PERANCANGAN BASIS DATA."""
    make_heading(doc, 'BAB III', level=1)
    make_heading(doc, 'PERANCANGAN BASIS DATA', level=1)

    make_paragraph(doc, '', font_size=6, space_after=6)

    make_paragraph(doc,
        'Rancangan basis data relasional diimplementasikan menggunakan mesin penyimpanan '
        'SQLite yang disimpan dalam satu file fisik (database.sqlite). Struktur tabel '
        'mengikuti konvensi penamaan model Laravel Eloquent. Berikut adalah kamus data '
        '(Data Dictionary) serta struktur rinci dari tabel-tabel utama di dalam database '
        'sistem persuratan.',
        first_line_indent=1.25, space_after=12)

    make_paragraph(doc,
        'Sistem ini memiliki 3 tabel utama yang menjalankan logika bisnis aplikasi, yaitu: '
        'tabel users (data pengguna dan autentikasi), tabel pengajuan_surats (riwayat '
        'transaksi pengajuan surat), dan tabel pengaturans (konfigurasi dinamis kop surat). '
        'Ketiga tabel ini saling berelasi melalui Foreign Key yang menjaga integritas '
        'referensial data.',
        first_line_indent=1.25, space_after=18)

    # ====================== TABEL 1: users ======================
    make_heading(doc, '3.1 Tabel 1. users', level=2)
    make_paragraph(doc,
        'Menyimpan data kredensial akun dan profil lengkap untuk semua peran sistem '
        '(Admin dan Warga). Tabel ini merupakan pusat otentikasi yang menentukan hak '
        'akses pengguna terhadap fitur-fitur sistem.',
        space_after=12)

    headers = ["Kolom (Field)", "Tipe Data", "Atribut / Relasi", "Keterangan"]
    rows = [
        ["id", "bigint(20) unsigned", "PRIMARY KEY,\nAUTO_INCREMENT", "ID unik pengguna."],
        ["name", "varchar(255)", "NOT NULL", "Nama lengkap pengguna."],
        ["email", "varchar(255)", "UNIQUE, NOT NULL", "Alamat email untuk login dan menerima link verifikasi."],
        ["email_verified_at", "timestamp", "NULLABLE", "Penanda waktu kapan pengguna berhasil memverifikasi email."],
        ["password", "varchar(255)", "NOT NULL", "Password terenkripsi (Bcrypt Hash)."],
        ["remember_token", "varchar(100)", "NULLABLE", "Token untuk fitur \"Ingat Saya\" pada login."],
        ["nik", "varchar(16)", "UNIQUE, NULLABLE", "Nomor Induk Kependudukan (wajib 16 digit untuk warga)."],
        ["role", "varchar(255)", "DEFAULT 'warga'", "Hak akses sistem, berisi nilai: 'admin' atau 'warga'."],
        ["username", "varchar(50)", "UNIQUE, NULLABLE", "Username khusus untuk login Admin."],
        ["no_hp", "varchar(15)", "NULLABLE", "Nomor handphone pengguna."],
        ["alamat", "text", "NULLABLE", "Alamat lengkap tempat tinggal."],
        ["tempat_tgl_lahir", "varchar(100)", "NULLABLE", "Tempat dan tanggal lahir pengguna."],
        ["pekerjaan", "varchar(50)", "NULLABLE", "Pekerjaan pengguna."],
        ["agama", "varchar(20)", "NULLABLE", "Agama pengguna."],
        ["created_at", "timestamp", "NULLABLE", "Waktu akun dibuat oleh sistem."],
        ["updated_at", "timestamp", "NULLABLE", "Waktu data terakhir diperbarui."],
    ]
    add_table(doc, headers, rows, col_widths=[3.5, 3.5, 3.8, 4.7])

    # Penjelasan relasi
    p = doc.add_paragraph()
    p.paragraph_format.line_spacing = 1.5
    p.paragraph_format.space_after = Pt(8)
    run1 = p.add_run('Penjelasan Relasi dan Atribut: ')
    run1.font.name = 'Times New Roman'
    run1.font.size = Pt(11)
    run1.bold = True
    run2 = p.add_run(
        "Tabel 'users' adalah tabel pusat otentikasi sistem. Atribut 'role' bertindak "
        "sebagai pemisah akses (admin atau warga) yang dikontrol oleh middleware Laravel. "
        "Hubungan relasi One-to-Many dimiliki oleh tabel 'users' ke tabel 'pengajuan_surats' "
        "melalui kolom 'user_id'. Artinya, satu pengguna (warga) dapat memiliki banyak "
        "pengajuan surat. Atribut 'email_verified_at' berfungsi sebagai gerbang keamanan: "
        "selama kolom ini bernilai NULL, pengguna tidak diizinkan mengakses fitur apapun "
        "selain halaman verifikasi email."
    )
    run2.font.name = 'Times New Roman'
    run2.font.size = Pt(11)

    doc.add_paragraph()

    # ====================== TABEL 2: pengajuan_surats ======================
    make_heading(doc, '3.2 Tabel 2. pengajuan_surats', level=2)
    make_paragraph(doc,
        'Tabel ini merupakan tabel inti transaksi yang menyimpan seluruh riwayat '
        'permintaan surat dari warga beserta status persetujuan atau penolakannya '
        'oleh Admin Desa.',
        space_after=12)

    rows2 = [
        ["id", "bigint(20) unsigned", "PRIMARY KEY,\nAUTO_INCREMENT", "ID unik pengajuan."],
        ["user_id", "bigint(20) unsigned", "FOREIGN KEY → users.id,\nON DELETE CASCADE", "Relasi ke pemilik akun warga yang mengajukan."],
        ["jenis_surat", "varchar(50)", "NOT NULL", "Kategori surat (SKTM, SKU, Domisili, Pengantar SKCK, Belum Menikah, Kematian, Kelahiran, Penghasilan Orang Tua, Pindah Penduduk)."],
        ["keperluan", "text", "NOT NULL", "Penjelasan tujuan/keperluan warga membuat surat."],
        ["file_ktp", "varchar(255)", "NOT NULL", "Path file unggahan scan/foto KTP warga."],
        ["file_pengantar", "varchar(255)", "NULLABLE", "Path file surat pengantar dari RT/RW."],
        ["file_tambahan", "varchar(255)", "NULLABLE", "Path dokumen tambahan (Foto Usaha, Surat RS, Slip Gaji, dll)."],
        ["file_kk", "varchar(255)", "NULLABLE", "Path file unggahan scan Kartu Keluarga."],
        ["tgl_pengajuan", "date", "NOT NULL", "Tanggal saat warga mengirimkan formulir pengajuan."],
        ["status", "varchar(255)", "DEFAULT 'Menunggu'", "Status terkini: 'Menunggu', 'Diproses', 'Ditolak', atau 'Selesai'."],
        ["keterangan_admin", "text", "NULLABLE", "Catatan dari Admin (misal: alasan penolakan berkas)."],
        ["created_at", "timestamp", "NULLABLE", "Waktu rekaman pengajuan dibuat oleh sistem."],
        ["updated_at", "timestamp", "NULLABLE", "Waktu data pengajuan terakhir diperbarui oleh Admin."],
    ]
    add_table(doc, headers, rows2, col_widths=[3.5, 3.5, 3.8, 4.7])

    # Penjelasan relasi
    p = doc.add_paragraph()
    p.paragraph_format.line_spacing = 1.5
    p.paragraph_format.space_after = Pt(8)
    run1 = p.add_run('Penjelasan Relasi dan Atribut: ')
    run1.font.name = 'Times New Roman'
    run1.font.size = Pt(11)
    run1.bold = True
    run2 = p.add_run(
        "Tabel 'pengajuan_surats' adalah tabel transaksi inti. Kolom 'user_id' merupakan "
        "Foreign Key yang menghubungkan setiap pengajuan ke pemilik akun di tabel 'users' "
        "dengan constraint ON DELETE CASCADE, artinya jika akun pengguna dihapus maka "
        "seluruh pengajuan miliknya juga otomatis terhapus. Hubungan relasi ini bersifat "
        "Many-to-One (banyak pengajuan dimiliki oleh satu warga). "
        "Kolom 'status' mewakili siklus hidup pengajuan: Menunggu → Diproses → Selesai/Ditolak. "
        "Kolom 'file_*' menyimpan path relatif ke direktori penyimpanan server "
        "(storage/app/public/uploads/) yang dilindungi oleh akses terkontrol."
    )
    run2.font.name = 'Times New Roman'
    run2.font.size = Pt(11)

    doc.add_paragraph()

    # ====================== TABEL 3: pengaturans ======================
    make_heading(doc, '3.3 Tabel 3. pengaturans', level=2)
    make_paragraph(doc,
        'Menyimpan data variabel konfigurasi dinamis sistem yang digunakan saat '
        'pencetakan kop surat resmi desa. Tabel ini bersifat singleton (hanya berisi '
        'satu baris data yang diperbarui secara berkala oleh Admin).',
        space_after=12)

    rows3 = [
        ["id", "bigint(20) unsigned", "PRIMARY KEY,\nAUTO_INCREMENT", "ID unik konfigurasi."],
        ["nama_kades", "varchar(100)", "NOT NULL", "Nama lengkap Kepala Desa yang sedang menjabat."],
        ["nip_kades", "varchar(50)", "NOT NULL", "Nomor Induk Pegawai (NIP) Kepala Desa."],
        ["jabatan", "varchar(100)", "NOT NULL", "Jabatan penandatangan surat (misal: Kepala Desa Babakanmulya)."],
        ["created_at", "timestamp", "NULLABLE", "Waktu konfigurasi pertama kali dibuat."],
        ["updated_at", "timestamp", "NULLABLE", "Waktu konfigurasi terakhir diperbarui melalui menu Admin."],
    ]
    add_table(doc, headers, rows3, col_widths=[3.5, 3.5, 3.8, 4.7])

    # Penjelasan relasi
    p = doc.add_paragraph()
    p.paragraph_format.line_spacing = 1.5
    p.paragraph_format.space_after = Pt(8)
    run1 = p.add_run('Penjelasan Relasi dan Atribut: ')
    run1.font.name = 'Times New Roman'
    run1.font.size = Pt(11)
    run1.bold = True
    run2 = p.add_run(
        "Tabel 'pengaturans' berdiri sendiri (tidak memiliki Foreign Key ke tabel lain). "
        "Tabel ini bersifat singleton, artinya hanya menyimpan satu baris data konfigurasi "
        "yang akan terus diperbarui (UPDATE) oleh Admin ketika terjadi pergantian jabatan "
        "Kepala Desa. Data dari tabel ini secara otomatis ditarik oleh sistem ke dalam "
        "template pencetakan surat resmi untuk mengisi bagian tanda tangan, nama, dan NIP "
        "pada kop surat."
    )
    run2.font.name = 'Times New Roman'
    run2.font.size = Pt(11)


def main():
    """Main function to generate the complete DOCX report."""
    doc = Document()

    # ============ PAGE SETUP (A4, Margins 4/3/3/3 cm) ============
    section = doc.sections[0]
    section.page_height = Cm(29.7)
    section.page_width = Cm(21.0)
    section.top_margin = Cm(4)
    section.bottom_margin = Cm(3)
    section.left_margin = Cm(3)
    section.right_margin = Cm(3)

    # Set default font
    style = doc.styles['Normal']
    font = style.font
    font.name = 'Times New Roman'
    font.size = Pt(12)
    style.paragraph_format.line_spacing = 1.5

    # ============ BUILD DOCUMENT ============
    build_cover_page(doc)
    build_bab1(doc)
    build_bab2(doc)
    build_bab3(doc)

    # ============ SAVE ============
    doc.save(OUTPUT_PATH)
    print(f"\nLaporan berhasil di-generate!")
    print(f"File tersimpan di: {OUTPUT_PATH}")

if __name__ == '__main__':
    main()
