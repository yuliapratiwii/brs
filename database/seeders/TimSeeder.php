<?php

namespace Database\Seeders;

use App\Models\Tim;
use Illuminate\Database\Seeder;

class TimSeeder extends Seeder
{
    public function run(): void
    {
        $daftar = [
            'Tim HADIST', 'Tim KTIP', 'Tim RASA-Q', 'Tim NWAS', 'Tim PEACE',
            'Tim Harga', 'Tim Distribusi', 'Tim Ketenagakerjaan', 'Tim Kesra',
            'Tim Neraca', 'Tim Sosial', 'Tim Nerwilis',
        ];

        foreach ($daftar as $nama) {
            Tim::firstOrCreate(['nama' => $nama]);
        }
    }
}
