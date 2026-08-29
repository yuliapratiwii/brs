<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrsEntry extends Model
{
    protected $fillable = [
        'judul',
        'kategori',
        'tanggal_rilis',
        'periode_rilis',
        'jumlah_terbitan',
        'tahun_pertama_terbit',
        'penanggung_jawab',
        'no_urut',
        'nomor_brs',
    ];

    protected $casts = [
        'tanggal_rilis' => 'date',
    ];

    
    public static function assignNomor(self $entry): void
    {
        if ($entry->nomor_brs) {
            return; // sudah pernah diterbitkan, jangan disentuh lagi
        }

        $tahun = (int) $entry->tanggal_rilis->format('Y');
        $romawi = TahunReferensi::where('tahun', $tahun)->value('romawi') ?? '';
        $kodeWilayah = Setting::get('kode_wilayah', '1674');
        $bulan = $entry->tanggal_rilis->format('m');

        $urutTerakhir = static::whereYear('tanggal_rilis', $tahun)
            ->whereNotNull('nomor_brs')
            ->max('no_urut') ?? 0;
        $urut = $urutTerakhir + 1;

        $nomor = sprintf('%02d/%s/%s/Th.%s', $urut, $bulan, $kodeWilayah, $romawi);

        static::where('id', $entry->id)->update([
            'no_urut' => $urut,
            'nomor_brs' => $nomor,
        ]);
    }

    /**
     * Hitung ulang no urut & nomor BRS untuk SEMUA entri di satu tahun takwim.
     * Ini aksi administratif yang sengaja mengganti nomor yang sudah terbit —
     * HANYA dipakai untuk koreksi massal (ubah kode wilayah, benerin angka
     * romawi tahun yang salah). Jangan dipanggil dari alur tambah/ubah/hapus
     * entri biasa, karena itu akan mengubah nomor yang seharusnya permanen.
     */
    public static function renumberYear(int $tahun): void
    {
        $romawi = TahunReferensi::where('tahun', $tahun)->value('romawi') ?? '';
        $kodeWilayah = Setting::get('kode_wilayah', '1674');

        $entries = static::whereYear('tanggal_rilis', $tahun)
            ->orderBy('tanggal_rilis')
            ->orderBy('id')
            ->get();

        $urut = 1;
        foreach ($entries as $entry) {
            $bulan = $entry->tanggal_rilis->format('m');
            $nomor = sprintf('%02d/%s/%s/Th.%s', $urut, $bulan, $kodeWilayah, $romawi);

            static::where('id', $entry->id)->update([
                'no_urut' => $urut,
                'nomor_brs' => $nomor,
            ]);

            $urut++;
        }
    }

    public static function availableYears(): array
    {
        $dariEntri = static::pluck('tanggal_rilis')
            ->map(fn ($d) => (int) $d->format('Y'));

        $dariReferensi = TahunReferensi::pluck('tahun')->map(fn ($t) => (int) $t);

        return $dariEntri->merge($dariReferensi)
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }
}