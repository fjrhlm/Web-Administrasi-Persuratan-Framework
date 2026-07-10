@extends('layouts.warga')

@section('title', 'Ajukan Surat Baru')

@section('content')
<div class="animate-fade-in-up" x-data="pengajuanForm()">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Ajukan Surat Baru</h2>
        <p class="text-gray-600 text-sm mt-1">Lengkapi formulir di bawah ini untuk mengajukan surat.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('warga.pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Kiri: Form Input --}}
                <div class="space-y-6">
                    {{-- NIK --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NIK Pemohon</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                </svg>
                            </div>
                            <input type="text" value="{{ Auth::user()->nik }}" disabled
                                   class="pl-10 w-full bg-gray-50 border border-gray-200 text-gray-500 rounded-xl px-4 py-2.5 focus:ring-0 sm:text-sm">
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">NIK terisi otomatis sesuai data akun.</p>
                    </div>

                    {{-- Jenis Surat --}}
                    <div>
                        <label for="jenis_surat" class="block text-sm font-medium text-gray-700 mb-2">Jenis Surat <span class="text-red-500">*</span></label>
                        <select id="jenis_surat" name="jenis_surat" x-model="jenisSurat"
                                class="w-full bg-white border border-gray-300 text-gray-800 rounded-xl px-4 py-2.5 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm shadow-sm" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            <option value="SKTM">Surat Keterangan Tidak Mampu (SKTM)</option>
                            <option value="SKU">Surat Keterangan Usaha (SKU)</option>
                            <option value="Domisili">Surat Keterangan Domisili</option>
                            <option value="Pengantar SKCK">Surat Pengantar SKCK</option>
                            <option value="Belum Menikah">Surat Keterangan Belum Menikah</option>
                            <option value="Kematian">Surat Keterangan Kematian / Ahli Waris</option>
                            <option value="Kelahiran">Surat Keterangan Kelahiran</option>
                            <option value="Penghasilan Orang Tua">Surat Keterangan Penghasilan (Orang Tua)</option>
                            <option value="Pindah Penduduk">Surat Keterangan Pindah Penduduk</option>
                        </select>
                        @error('jenis_surat')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Keperluan --}}
                    <div>
                        <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-2">Keperluan <span class="text-red-500">*</span></label>
                        <textarea id="keperluan" name="keperluan" rows="3"
                                  class="w-full bg-white border border-gray-300 text-gray-800 rounded-xl px-4 py-3 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm shadow-sm resize-none"
                                  placeholder="Contoh: Untuk persyaratan pembuatan KTP / Untuk mendaftar beasiswa" required>{{ old('keperluan') }}</textarea>
                        @error('keperluan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Kanan: Upload Dokumen --}}
                <div class="space-y-6">
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-4" x-show="jenisSurat !== ''">
                        <h4 class="text-sm font-medium text-blue-800 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            Persyaratan Dokumen:
                        </h4>
                        <ul class="text-xs text-blue-700 list-disc pl-5 space-y-1">
                            <li x-show="!['Kematian', 'Kelahiran'].includes(jenisSurat)">Scan/Foto KTP Asli</li>
                            <li x-show="['Kematian'].includes(jenisSurat)">Scan/Foto KTP Pelapor & KTP Almarhum</li>
                            <li x-show="['Kelahiran'].includes(jenisSurat)">Scan/Foto KTP Orang Tua</li>
                            <li>Surat Pengantar dari RT/RW</li>
                            <li x-show="['SKTM', 'Domisili', 'Belum Menikah', 'Kematian', 'Kelahiran', 'Pindah Penduduk', 'Penghasilan Orang Tua'].includes(jenisSurat)">Scan/Foto Kartu Keluarga (KK)</li>
                            <li x-show="jenisSurat === 'SKU'">Foto Tempat Usaha / Produk</li>
                            <li x-show="jenisSurat === 'Kematian'">Surat Keterangan Kematian dari RS (Jika ada)</li>
                            <li x-show="jenisSurat === 'Kelahiran'">Surat Lahir dari Bidan/RS</li>
                            <li x-show="jenisSurat === 'Penghasilan Orang Tua'">Slip Gaji / Rincian Penghasilan</li>
                        </ul>
                    </div>

                    {{-- Upload KTP --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto KTP <span class="text-red-500">*</span></label>
                        <input type="file" name="file_ktp" accept="image/jpeg,image/png,image/jpg,application/pdf"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" required>
                        <p class="mt-1 text-xs text-gray-400">Format: JPG, PNG, PDF. Maks: 2MB.</p>
                        @error('file_ktp')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Pengantar --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Surat Pengantar RT/RW <span class="text-red-500">*</span></label>
                        <input type="file" name="file_pengantar" accept="image/jpeg,image/png,image/jpg,application/pdf"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" required>
                        @error('file_pengantar')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Tambahan --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dokumen Tambahan <span class="text-red-500">*</span></label>
                        <input type="file" name="file_tambahan" accept="image/jpeg,image/png,image/jpg,application/pdf"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" required>
                        <p class="mt-1 text-xs text-gray-400" x-text="
                            jenisSurat === 'SKU' ? 'Foto Tempat Usaha / Produk' :
                            (jenisSurat === 'Kematian' ? 'Surat Kematian RS & KTP Almarhum (Jadikan 1 file/PDF)' :
                            (jenisSurat === 'Kelahiran' ? 'Surat Lahir Bidan/RS' :
                            (jenisSurat === 'Penghasilan Orang Tua' ? 'Slip Gaji / Rincian Penghasilan' : 'Kartu Keluarga (KK)')))
                        "></p>
                        @error('file_tambahan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('pengajuanForm', () => ({
            jenisSurat: '{{ old('jenis_surat') }}',
        }))
    })
</script>
@endsection
