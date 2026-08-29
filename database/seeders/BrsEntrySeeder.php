<?php

namespace Database\Seeders;

use App\Models\BrsEntry;
use Illuminate\Database\Seeder;

class BrsEntrySeeder extends Seeder
{
    /**
     * Mengisi data historis dari "Agenda Penomoran Berita Resmi Statistik BPS
     * Kota Lubuklinggau" (2021-2026). Nomor BRS dihitung ulang otomatis oleh
     * sistem sesuai urutan tanggal rilis sehingga format Th VII / Th.VII yang
     * dulunya tidak konsisten di file lama, jadi seragam.
     */
    public function run(): void
    {
        $path = __DIR__ . '/data/brs_seed.json';
        $data = json_decode(file_get_contents($path), true);

        $tahunTerpakai = [];

        foreach ($data as $tahun => $daftarEntri) {
            foreach ($daftarEntri as $row) {
                if (empty($row['tanggal'])) {
                    continue;
                }

                BrsEntry::create([
                    'judul' => $row['judul'],
                    'kategori' => $row['kategori'] ?: 'Lainnya',
                    'tanggal_rilis' => $row['tanggal'],
                    'periode_rilis' => $row['periode'] ?: 'Bulanan',
                    'jumlah_terbitan' => $row['jumlahTerbitan'],
                    'tahun_pertama_terbit' => $row['tahunPertama'],
                    'penanggung_jawab' => $row['penanggungJawab'] ?: 'Belum diisi',
                    'no_urut' => 0,
                    'nomor_brs' => null,
                ]);

                $tahunTerpakai[(int) $tahun] = true;
            }
        }

        foreach (array_keys($tahunTerpakai) as $tahun) {
            BrsEntry::renumberYear($tahun);
        }
    }
}
