<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $daftar = [
            'Inflasi', 'Pariwisata', 'Transportasi', 'Pertumbuhan Ekonomi',
            'Ekonomi', 'Ketenagakerjaan', 'Kemiskinan', 'IPM',
        ];

        foreach ($daftar as $nama) {
            Kategori::firstOrCreate(['nama' => $nama]);
        }
    }
}
