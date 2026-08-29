<?php

namespace App\Http\Controllers;

use App\Models\BrsEntry;
use App\Models\Kategori;
use App\Models\Setting;
use App\Models\TahunReferensi;
use App\Models\Tim;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
    return view('settings.index', [
        'kategoris' => Kategori::orderBy('nama')->get(),
        'tims' => Tim::orderBy('nama')->get(),
        'tahunReferensi' => TahunReferensi::orderBy('tahun')->get(),
        'kodeWilayah' => Setting::get('kode_wilayah', '1674'),
        'romawiBerikutnya' => TahunReferensi::romawiBerikutnya(),
        'tahunBerikutnya' => (TahunReferensi::orderByDesc('tahun')->value('tahun') ?? (now()->year - 1)) + 1,
    ]);
    }

    public function storeKategori(Request $request)
    {
        $request->validate(['nama' => ['required', 'string', 'max:100', 'unique:kategoris,nama']]);
        Kategori::create(['nama' => trim($request->input('nama'))]);
        return back()->with('sukses', 'Kategori ditambahkan.');
    }

    public function destroyKategori(Kategori $kategori)
    {
        $kategori->delete();
        return back()->with('sukses', 'Kategori dihapus dari daftar pilihan (entri lama tidak berubah).');
    }

    public function storeTim(Request $request)
    {
        $request->validate(['nama' => ['required', 'string', 'max:150', 'unique:tims,nama']]);
        Tim::create(['nama' => trim($request->input('nama'))]);
        return back()->with('sukses', 'Tim/penanggung jawab ditambahkan.');
    }

    public function destroyTim(Tim $tim)
    {
        $tim->delete();
        return back()->with('sukses', 'Tim dihapus dari daftar pilihan (entri lama tidak berubah).');
    }

    public function storeTahunReferensi(Request $request)
    {
    $request->validate([
        'tahun' => ['required', 'integer', 'min:1990', 'max:2100', 'unique:tahun_referensis,tahun'],
    ]);

    $tahun = (int) $request->input('tahun');
    $romawi = TahunReferensi::romawiBerikutnya();

    TahunReferensi::create(['tahun' => $tahun, 'romawi' => $romawi]);
    BrsEntry::renumberYear($tahun);

    return back()->with('sukses', "Tahun {$tahun} ditambahkan sebagai tahun ke-{$romawi} (otomatis, lanjut dari tahun sebelumnya).");
    }

    public function updateTahunReferensi(Request $request, TahunReferensi $tahunReferensi)
    {
    $request->validate(['romawi' => ['required', 'string', 'max:20']]);
    $tahunReferensi->update(['romawi' => strtoupper(trim($request->input('romawi')))]);
    BrsEntry::renumberYear($tahunReferensi->tahun);
    return back()->with('sukses', "Angka romawi tahun {$tahunReferensi->tahun} dikoreksi, nomor BRS tahun itu sudah dihitung ulang.");
    }

    public function updateKodeWilayah(Request $request)
    {
        $request->validate(['kode_wilayah' => ['required', 'string', 'max:20']]);
        Setting::set('kode_wilayah', trim($request->input('kode_wilayah')));

        foreach (BrsEntry::availableYears() as $tahun) {
            BrsEntry::renumberYear($tahun);
        }

        return back()->with('sukses', 'Kode wilayah diperbarui dan seluruh nomor BRS di semua tahun sudah dihitung ulang.');
    }

    public function destroyTahunReferensi(TahunReferensi $tahunReferensi)
    {
    $adaEntri = BrsEntry::whereYear('tanggal_rilis', $tahunReferensi->tahun)->exists();

    if ($adaEntri) {
        return back()->with('gagal', "Tahun {$tahunReferensi->tahun} tidak bisa dihapus karena masih ada BRS terdaftar di tahun itu.");
    }

    $tahunReferensi->delete();

    return back()->with('sukses', "Tahun {$tahunReferensi->tahun} dihapus dari daftar referensi.");
    }
}
