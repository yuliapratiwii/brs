<?php

namespace App\Http\Controllers;

use App\Models\BrsEntry;
use App\Models\Kategori;
use App\Models\TahunReferensi;
use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class BrsEntryController extends Controller
{
    public function index(Request $request)
    {
        $tahun = (int) $request->query('tahun', now()->year);

        $query = BrsEntry::whereYear('tanggal_rilis', $tahun);

        if ($request->filled('cari')) {
            $query->where('judul', 'like', '%' . $request->query('cari') . '%');
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->query('kategori'));
        }
        if ($request->filled('tim')) {
            $query->where('penanggung_jawab', $request->query('tim'));
        }

        $entries = $query->orderBy('no_urut')->get();

        $availableYears = BrsEntry::availableYears();
        if (!in_array($tahun, $availableYears)) {
            $availableYears[] = $tahun;
            sort($availableYears);
        }

        $tahunReferensi = TahunReferensi::where('tahun', $tahun)->first();

        return view('brs.index', [
            'entries' => $entries,
            'tahun' => $tahun,
            'availableYears' => $availableYears,
            'kategoris' => Kategori::orderBy('nama')->get(),
            'tims' => Tim::orderBy('nama')->get(),
            'periodeList' => ['Bulanan', 'Triwulanan', 'Tahunan'],
            'tahunRomawi' => $tahunReferensi?->romawi,
            'filterCari' => $request->query('cari', ''),
            'filterKategori' => $request->query('kategori', ''),
            'filterTim' => $request->query('tim', ''),
        ]);
    }

    public function store(Request $request)
    {
    $data = $this->validated($request);
    $data = $this->resolveNewLookups($request, $data);

    $entry = BrsEntry::create($data);

    TahunReferensi::ensureFor((int) $entry->tanggal_rilis->format('Y'));
    BrsEntry::assignNomor($entry);

    return redirect()
        ->route('brs.index', ['tahun' => $entry->tanggal_rilis->format('Y')])
        ->with('sukses', 'BRS baru tersimpan dengan nomor ' . $entry->fresh()->nomor_brs);
    }

    public function edit(BrsEntry $brsEntry)
    {
        return view('brs.edit', [
            'entry' => $brsEntry,
            'kategoris' => Kategori::orderBy('nama')->get(),
            'tims' => Tim::orderBy('nama')->get(),
            'periodeList' => ['Bulanan', 'Triwulanan', 'Tahunan'],
        ]);
    }

    public function update(Request $request, BrsEntry $brsEntry)
    {
    $data = $this->validated($request);
    $data = $this->resolveNewLookups($request, $data);

    unset($data['tanggal_rilis']);

    $brsEntry->update($data);

    return redirect()
        ->route('brs.index', ['tahun' => $brsEntry->tanggal_rilis->format('Y')])
        ->with('sukses', 'Perubahan tersimpan. Nomor BRS tetap ' . $brsEntry->nomor_brs . '.');
    }

    public function destroy(BrsEntry $brsEntry)
    {
    $tahun = (int) $brsEntry->tanggal_rilis->format('Y');
    $brsEntry->delete();

    return redirect()
        ->route('brs.index', ['tahun' => $tahun])
        ->with('sukses', 'Entri BRS dihapus.');
    }

    public function export(int $tahun): StreamedResponse
    {
    $entries = BrsEntry::whereYear('tanggal_rilis', $tahun)->orderBy('no_urut')->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Agenda BRS ' . $tahun);

    $header = ['No', 'Judul', 'Kategori', 'Tanggal Rilis', 'Periode', 'Jumlah Terbitan', 'Tahun Pertama Terbit', 'Penanggung Jawab', 'Nomor BRS'];
    $sheet->fromArray($header, null, 'A1');
    $sheet->getStyle('A1:I1')->getFont()->setBold(true);

    $baris = 2;
    foreach ($entries as $e) {
        $sheet->fromArray([
            $e->no_urut,
            $e->judul,
            $e->kategori,
            $e->tanggal_rilis->format('d-m-Y'),
            $e->periode_rilis,
            $e->jumlah_terbitan,
            $e->tahun_pertama_terbit,
            $e->penanggung_jawab,
            $e->nomor_brs,
        ], null, "A{$baris}");
        $baris++;
    }

    foreach (range('A', 'I') as $kolom) {
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
    }

    $filename = "agenda-brs-{$tahun}.xlsx";

    return response()->streamDownload(function () use ($spreadsheet) {
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }, $filename, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
    }

    private function validated(Request $request): array
    {
    return $request->validate([
        'judul' => ['required', 'string', 'max:500'],
        'kategori' => ['required_without:kategori_baru', 'nullable', 'string', 'max:100'],
        'kategori_baru' => ['required_without:kategori', 'nullable', 'string', 'max:100'],
        'tanggal_rilis' => ['required', 'date'],
        'periode_rilis' => ['required', 'string', 'max:50'],
        'jumlah_terbitan' => ['nullable', 'string', 'max:50'],
        'tahun_pertama_terbit' => ['nullable', 'integer', 'min:1990', 'max:2100'],
        'penanggung_jawab' => ['required_without:penanggung_jawab_baru', 'nullable', 'string', 'max:150'],
        'penanggung_jawab_baru' => ['required_without:penanggung_jawab', 'nullable', 'string', 'max:150'],
    ], [
        'judul.required' => 'Judul BRS wajib diisi.',
        'kategori.required_without' => 'Pilih kategori, atau isi kolom kategori baru.',
        'kategori_baru.required_without' => 'Pilih kategori, atau isi kolom kategori baru.',
        'tanggal_rilis.required' => 'Tanggal rilis wajib diisi.',
        'tanggal_rilis.date' => 'Tanggal rilis tidak valid.',
        'periode_rilis.required' => 'Periode rilis wajib diisi.',
        'tahun_pertama_terbit.integer' => 'Tahun pertama terbit harus berupa angka.',
        'penanggung_jawab.required_without' => 'Pilih tim, atau isi kolom tim baru.',
        'penanggung_jawab_baru.required_without' => 'Pilih tim, atau isi kolom tim baru.',
    ]);
    }

    private function resolveNewLookups(Request $request, array $data): array
    {
        if ($request->filled('kategori_baru')) {
            $kategori = Kategori::firstOrCreate(['nama' => trim($request->input('kategori_baru'))]);
            $data['kategori'] = $kategori->nama;
        }
        unset($data['kategori_baru']);

        if ($request->filled('penanggung_jawab_baru')) {
            $tim = Tim::firstOrCreate(['nama' => trim($request->input('penanggung_jawab_baru'))]);
            $data['penanggung_jawab'] = $tim->nama;
        }
        unset($data['penanggung_jawab_baru']);

        return $data;
    }
}