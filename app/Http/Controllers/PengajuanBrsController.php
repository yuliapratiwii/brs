<?php

namespace App\Http\Controllers;

use App\Models\BrsEntry;
use App\Models\Kategori;
use App\Models\TahunReferensi;
use App\Models\Tim;
use Illuminate\Http\Request;

class PengajuanBrsController extends Controller
{
    public function create()
    {
        return view('pengajuan.create', [
            'kategoris' => Kategori::orderBy('nama')->get(),
            'tims' => Tim::orderBy('nama')->get(),
            'periodeList' => ['Bulanan', 'Triwulanan', 'Tahunan'],
            'tahunSekarang' => now()->year,
        ]);
    }

    public function store(Request $request)
    {
        $tahunSekarang = now()->year;

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:500'],
            'kategori' => ['required', 'string', 'max:100', 'exists:kategoris,nama'],
            'tanggal_rilis' => [
                'required',
                'date',
                'after_or_equal:' . $tahunSekarang . '-01-01',
                'before_or_equal:' . $tahunSekarang . '-12-31',
            ],
            'periode_rilis' => ['required', 'string', 'max:50'],
            'jumlah_terbitan' => ['nullable', 'string', 'max:50'],
            'tahun_pertama_terbit' => ['nullable', 'integer', 'min:1990', 'max:2100'],
            'penanggung_jawab' => ['required', 'string', 'max:150', 'exists:tims,nama'],
        ], [
            'judul.required' => 'Judul BRS wajib diisi.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.exists' => 'Kategori tidak dikenali, pilih dari daftar.',
            'tanggal_rilis.required' => 'Tanggal rilis wajib diisi.',
            'tanggal_rilis.after_or_equal' => "Tanggal rilis harus di tahun {$tahunSekarang}.",
            'tanggal_rilis.before_or_equal' => "Tanggal rilis harus di tahun {$tahunSekarang}.",
            'periode_rilis.required' => 'Periode rilis wajib diisi.',
            'penanggung_jawab.required' => 'Tim wajib dipilih.',
            'penanggung_jawab.exists' => 'Tim tidak dikenali, pilih dari daftar.',
        ]);

        $entry = BrsEntry::create($data);

        TahunReferensi::ensureFor($tahunSekarang);
        BrsEntry::assignNomor($entry);

        return redirect()
            ->route('pengajuan.create')
            ->with('nomorBaru', $entry->fresh()->nomor_brs);
    }
}