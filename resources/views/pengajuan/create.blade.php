@extends('layouts.publik')

@section('title', 'Pengajuan Nomor BRS')

@section('content')
    <div class="bg-white rounded-lg border border-hairline p-5">
        <h3 class="text-sm font-medium mb-1 text-slate-600">Ajukan BRS baru</h3>
        <p class="text-xs text-slate-400 mb-4">Tanggal rilis hanya bisa dipilih di tahun {{ $tahunSekarang }}.</p>

        <form method="POST" action="{{ route('pengajuan.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div class="md:col-span-2">
                <label class="block text-xs text-slate-500 mb-1">Judul BRS</label>
                <input type="text" name="judul" required value="{{ old('judul') }}"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm" placeholder="Perkembangan Indeks Harga Konsumen/Inflasi ...">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Tanggal rilis</label>
                <input type="date" name="tanggal_rilis" required value="{{ old('tanggal_rilis') }}"
                       min="{{ $tahunSekarang }}-01-01" max="{{ $tahunSekarang }}-12-31"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Kategori</label>
                <select name="kategori" required class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    <option value="">Pilih kategori</option>
                    @foreach ($kategoris as $k)
                        <option value="{{ $k->nama }}" {{ old('kategori') == $k->nama ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Periode rilis</label>
                <select name="periode_rilis" class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    @foreach ($periodeList as $p)
                        <option value="{{ $p }}" {{ old('periode_rilis') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Penanggung jawab</label>
                <select name="penanggung_jawab" required class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    <option value="">Pilih tim</option>
                    @foreach ($tims as $t)
                        <option value="{{ $t->nama }}" {{ old('penanggung_jawab') == $t->nama ? 'selected' : '' }}>{{ $t->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Tahun pertama terbit (opsional)</label>
                <input type="number" name="tahun_pertama_terbit" value="{{ old('tahun_pertama_terbit') }}"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm" placeholder="2015">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Jumlah terbitan (opsional)</label>
                <input type="text" name="jumlah_terbitan" value="{{ old('jumlah_terbitan') }}"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="bg-navy text-white text-sm px-5 py-2 rounded hover:bg-navy-deep transition">Ajukan & dapatkan nomor</button>
            </div>
        </form>
    </div>
@endsection