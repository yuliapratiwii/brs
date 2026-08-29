<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunReferensi extends Model
{
    protected $fillable = ['tahun', 'romawi'];

    private static array $peta = [
        'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
        'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
        'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1,
    ];

    public static function romawiKeAngka(string $romawi): int
    {
        $angka = 0;
        $sisa = strtoupper($romawi);
        foreach (self::$peta as $simbol => $nilai) {
            while (str_starts_with($sisa, $simbol)) {
                $angka += $nilai;
                $sisa = substr($sisa, strlen($simbol));
            }
        }
        return $angka;
    }

    public static function angkaKeRomawi(int $angka): string
    {
        $hasil = '';
        foreach (self::$peta as $simbol => $nilai) {
            while ($angka >= $nilai) {
                $hasil .= $simbol;
                $angka -= $nilai;
            }
        }
        return $hasil;
    }

    public static function romawiBerikutnya(): string
    {
        $terakhir = static::orderByDesc('tahun')->first();

        if (!$terakhir) {
            return 'I';
        }

        return self::angkaKeRomawi(self::romawiKeAngka($terakhir->romawi) + 1);
    }

    public static function ensureFor(int $tahun): self
    {
        return static::firstOrCreate(
            ['tahun' => $tahun],
            ['romawi' => self::romawiBerikutnya()]
        );
    }
}