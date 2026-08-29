<?php

namespace Database\Seeders;

use App\Models\TahunReferensi;
use Illuminate\Database\Seeder;

class TahunReferensiSeeder extends Seeder
{
    public function run(): void
    {
        // 2021 adalah tahun ke-VII rilis BRS BPS Kota Lubuklinggau (lihat catatan di file agenda asli)
        $map = [
            2021 => 'VII',
            2022 => 'VIII',
            2023 => 'IX',
            2024 => 'X',
            2025 => 'XI',
            2026 => 'XII',
        ];

        foreach ($map as $tahun => $romawi) {
            TahunReferensi::firstOrCreate(['tahun' => $tahun], ['romawi' => $romawi]);
        }
    }
}
