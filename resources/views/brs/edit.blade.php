@extends('layouts.app')

@section('title', 'Ubah BRS')

@section('content')
    <a href="{{ route('brs.index', ['tahun' => $entry->tanggal_rilis->format('Y')]) }}" class="text-sm text-slate-500 hover:underline mb-4 inline-block">&larr; Kembali ke daftar</a>

    <div class="bg-white rounded-lg border border-hairline p-5 max-w-3xl">
        <h3 class="font-serif-brs text-lg font-semibold mb-1">Ubah entri BRS</h3>
        <p class="font-mono-brs brass text-sm mb-4">{{ $entry->nomor_brs }}</p>

        <form method="POST" action="{{ route('brs.update', $entry) }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            @method('PUT')

            <div class="md:col-span-2">
                <label class="block text-xs text-slate-500 mb-1">Judul BRS</label>
                <input type="text" name="judul" required value="{{ old('judul', $entry->judul) }}"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Tanggal rilis</label>
                <input type="hidden" name="tanggal_rilis" value="{{ $entry->tanggal_rilis->format('Y-m-d') }}">
                <div class="w-full border border-hairline rounded px-3 py-2 text-sm bg-[#F3F4F1] text-slate-600">
                    {{ $entry->tanggal_rilis->format('d-m-Y') }}
                </div>
                <p class="text-xs text-slate-400 mt-1">Tanggal rilis tidak bisa diubah karena nomor BRS ({{ $entry->nomor_brs }}) sudah diterbitkan berdasarkan tanggal ini.</p>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Kategori</label>
                <select name="kategori" id="kategori-select" class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    @foreach ($kategoris as $k)
                        <option value="{{ $k->nama }}" {{ $entry->kategori == $k->nama ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                    @if (!$kategoris->pluck('nama')->contains($entry->kategori))
                        <option value="{{ $entry->kategori }}" selected>{{ $entry->kategori }}</option>
                    @endif
                    <option value="__baru__">+ Tambah kategori baru</option>
                </select>
                <input type="text" name="kategori_baru" id="kategori-baru" placeholder="Nama kategori baru"
                       class="hidden mt-2 w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Periode rilis</label>
                <select name="periode_rilis" class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    @foreach ($periodeList as $p)
                        <option value="{{ $p }}" {{ $entry->periode_rilis == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Penanggung jawab</label>
                <select name="penanggung_jawab" id="tim-select" class="w-full border border-hairline rounded px-3 py-2 text-sm">
                    @foreach ($tims as $t)
                        <option value="{{ $t->nama }}" {{ $entry->penanggung_jawab == $t->nama ? 'selected' : '' }}>{{ $t->nama }}</option>
                    @endforeach
                    @if (!$tims->pluck('nama')->contains($entry->penanggung_jawab))
                        <option value="{{ $entry->penanggung_jawab }}" selected>{{ $entry->penanggung_jawab }}</option>
                    @endif
                    <option value="__baru__">+ Tambah tim baru</option>
                </select>
                <input type="text" name="penanggung_jawab_baru" id="tim-baru" placeholder="Nama tim baru"
                       class="hidden mt-2 w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Tahun pertama terbit</label>
                <input type="number" name="tahun_pertama_terbit" value="{{ old('tahun_pertama_terbit', $entry->tahun_pertama_terbit) }}"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-slate-500 mb-1">Jumlah terbitan</label>
                <input type="text" name="jumlah_terbitan" value="{{ old('jumlah_terbitan', $entry->jumlah_terbitan) }}"
                       class="w-full border border-hairline rounded px-3 py-2 text-sm">
            </div>

            <div class="md:col-span-2 flex gap-3 mt-2">
                <button type="submit" class="bg-navy text-white text-sm px-5 py-2 rounded hover:bg-navy-deep transition">Simpan perubahan</button>
                <a href="{{ route('brs.index', ['tahun' => $entry->tanggal_rilis->format('Y')]) }}" class="text-sm px-5 py-2 rounded border border-hairline hover:bg-[#FAFAF8]">Batal</a>
            </div>
        </form>
    </div>

    <script>
        function toggleBaru(selectId, inputId, fieldName) {
            const select = document.getElementById(selectId);
            const input = document.getElementById(inputId);
            select.addEventListener('change', () => {
                if (select.value === '__baru__') {
                    input.classList.remove('hidden');
                    input.focus();
                    select.removeAttribute('name');
                } else {
                    input.classList.add('hidden');
                    input.value = '';
                    select.name = fieldName;
                }
            });
        }
        toggleBaru('kategori-select', 'kategori-baru', 'kategori');
        toggleBaru('tim-select', 'tim-baru', 'penanggung_jawab');
    </script>
@endsection
