@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
    <h2 class="font-serif-brs text-lg font-semibold mb-6">Pengaturan agenda penomoran</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Kode wilayah --}}
        <div class="bg-white rounded-lg border border-hairline p-5">
            <h3 class="text-sm font-medium mb-3">Kode wilayah</h3>
            <form method="POST" action="{{ route('settings.kodewilayah.update') }}" class="flex gap-2">
                @csrf
                @method('PUT')
                <input type="text" name="kode_wilayah" value="{{ $kodeWilayah }}" class="border border-hairline rounded px-3 py-2 text-sm font-mono-brs">
                <button type="submit" class="bg-navy text-white text-sm px-4 py-2 rounded hover:bg-navy-deep">Simpan</button>
            </form>
            <p class="text-xs text-slate-400 mt-2">Mengubah ini akan menghitung ulang nomor BRS di semua tahun.</p>
        </div>

        {{-- Tahun referensi --}}
        <div class="bg-white rounded-lg border border-hairline p-5">
            <h3 class="text-sm font-medium mb-3">Tahun ke-berapa (angka romawi)</h3>
            <table class="w-full text-sm mb-3">
                <thead>
                    <tr class="text-left text-xs uppercase text-slate-500">
                        <th class="py-1">Tahun takwim</th>
                        <th class="py-1">Romawi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tahunReferensi as $tr)
                        <tr class="border-t border-hairline">
                            <td class="py-2">{{ $tr->tahun }}</td>
                            <td class="py-2">
                                <details>
                                    <summary class="cursor-pointer text-sm font-mono-brs">{{ $tr->romawi }}
                                        <span class="text-xs text-slate-400 no-underline">(koreksi)</span></summary>
                                    <form method="POST" action="{{ route('settings.tahun.update', $tr) }}" class="flex gap-2 mt-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="romawi" value="{{ $tr->romawi }}" class="border border-hairline rounded px-2 py-1 text-sm w-20 font-mono-brs">
                                        <button type="submit" class="text-xs brass hover:underline">Simpan koreksi</button>
                                    </form>
                                </details>
                            </td>
                            <td>
                                <td class="py-2 text-right">
                                    <form method="POST" action="{{ route('settings.tahun.destroy', $tr) }}"
                                        onsubmit="return confirm('Hapus tahun {{ $tr->tahun }} dari daftar referensi?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-xs text-red-700 hover:underline">Hapus</button>
                                    </form>
                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <form method="POST" action="{{ route('settings.tahun.store') }}" class="flex items-center gap-2">
                @csrf
                <input type="number" name="tahun" value="{{ $tahunBerikutnya }}" required class="border border-hairline rounded px-3 py-2 text-sm w-24">
                <span class="text-sm text-slate-500">akan jadi tahun ke-<span class="font-mono-brs font-medium">{{ $romawiBerikutnya }}</span></span>
                <button type="submit" class="border border-hairline rounded px-3 py-2 text-sm hover:bg-[#FAFAF8]">Tambah tahun</button>
            </form>
            <p class="text-xs text-slate-400 mt-2">Angka romawi selalu otomatis melanjutkan tahun sebelumnya. Kalau perlu dibetulkan (mis. data lama), buka "koreksi" di baris tahunnya.</p>
        </div>

        {{-- Kategori --}}
        <div class="bg-white rounded-lg border border-hairline p-5">
            <h3 class="text-sm font-medium mb-3">Daftar kategori BRS</h3>
            <ul class="mb-3 space-y-1">
                @foreach ($kategoris as $k)
                    <li class="flex items-center justify-between text-sm border-b border-hairline py-1.5">
                        <span>{{ $k->nama }}</span>
                        <form method="POST" action="{{ route('settings.kategori.destroy', $k) }}"
                              onsubmit="return confirm('Hapus kategori {{ $k->nama }} dari daftar pilihan?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-xs text-red-700 hover:underline">Hapus</button>
                        </form>
                    </li>
                @endforeach
            </ul>
            <form method="POST" action="{{ route('settings.kategori.store') }}" class="flex gap-2">
                @csrf
                <input type="text" name="nama" placeholder="Kategori baru" required class="border border-hairline rounded px-3 py-2 text-sm flex-1">
                <button type="submit" class="border border-hairline rounded px-3 py-2 text-sm hover:bg-[#FAFAF8]">Tambah</button>
            </form>
        </div>

        {{-- Tim --}}
        <div class="bg-white rounded-lg border border-hairline p-5">
            <h3 class="text-sm font-medium mb-3">Daftar tim / penanggung jawab</h3>
            <ul class="mb-3 space-y-1">
                @foreach ($tims as $t)
                    <li class="flex items-center justify-between text-sm border-b border-hairline py-1.5">
                        <span>{{ $t->nama }}</span>
                        <form method="POST" action="{{ route('settings.tim.destroy', $t) }}"
                              onsubmit="return confirm('Hapus tim {{ $t->nama }} dari daftar pilihan?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-xs text-red-700 hover:underline">Hapus</button>
                        </form>
                    </li>
                @endforeach
            </ul>
            <form method="POST" action="{{ route('settings.tim.store') }}" class="flex gap-2">
                @csrf
                <input type="text" name="nama" placeholder="Tim baru" required class="border border-hairline rounded px-3 py-2 text-sm flex-1">
                <button type="submit" class="border border-hairline rounded px-3 py-2 text-sm hover:bg-[#FAFAF8]">Tambah</button>
            </form>
        </div>

    </div>
@endsection