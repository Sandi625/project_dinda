<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Penilaian;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DetailPenilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KriteriaPenilaian;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HalamanKepsekController extends Controller
{
public function index(Request $request)
{
    // Ambil semua penilaian dengan relasi yang dibutuhkan
    $query = Penilaian::with(['guru', 'kelas', 'mapel', 'detailPenilaian.kriteria']);

    // Filter berdasarkan semester (dari tabel penilaian)
    if ($request->filled('semester')) {
        $query->where('semester', $request->semester);
    }

    // Ambil data penilaian terbaru
    $penilaian = $query->orderByDesc('tanggal')->get();

    // Ambil daftar semester unik dari tabel penilaian
    $daftarSemester = Penilaian::select('semester')
        ->whereNotNull('semester')
        ->distinct()
        ->orderBy('semester')
        ->pluck('semester');

    return view('kepsek.index', compact('penilaian', 'daftarSemester'));
}




public function create()
{
    $guru = Guru::all();
    $kriteria = KriteriaPenilaian::all();
    $users = User::all();
    $kelas = Kelas::all();
    $mapel = Mapel::all();
    $semesters = ['ganjil', 'genap']; // Bisa disesuaikan jika ada sistem semester berbeda

    return view('kepsek.create', compact(
        'guru',
        'kriteria',
        'users',
        'kelas',
        'mapel',
        'semesters'
    ));
}




    public function show($id)
    {
        $penilaian = Penilaian::with([
            'guru',                // Relasi ke guru
            'user',                // Relasi ke user yang menilai
            'kelas',               // Relasi ke kelas
            'mapel',               // Relasi ke mata pelajaran
            'detailPenilaian.kriteria' // Relasi detail + kriteria
        ])->findOrFail($id);

        return view('kepsek.show', compact('penilaian'));
    }

public function store(Request $request)
{
    $request->validate([
        'id_guru' => 'required|exists:guru,id_guru',
        'id_user' => 'required|exists:users,id_user',
        'id_kelas' => 'required|exists:kelas,id',
        'id_mapel' => 'required|exists:mapel,id',
        'tanggal' => 'required|date',
        'semester' => 'required|in:ganjil,genap',
        'nilai' => 'required|array',
        'nilai.*' => 'required|numeric|min:0|max:100',
    ]);

    DB::beginTransaction();
    try {
        $penilaian = Penilaian::create([
            'id_guru' => $request->id_guru,
            'id_user' => $request->id_user,
            'id_kelas' => $request->id_kelas,
            'id_mapel' => $request->id_mapel,
            'tanggal' => $request->tanggal,
            'semester' => $request->semester, // Tambahkan semester
        ]);

        foreach ($request->nilai as $id_kriteria => $nilai) {
            DetailPenilaian::create([
                'id_penilaian' => $penilaian->id_penilaian,
                'id_kriteria' => $id_kriteria,
                'nilai' => $nilai,
            ]);
        }

        DB::commit();
        return redirect()->route('kepsek.index')->with('success', 'Penilaian berhasil ditambahkan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal menambahkan penilaian.')->withInput();
    }
}




  public function edit($id)
{
    $penilaian = Penilaian::with('detailPenilaian')->findOrFail($id);
    $guru = Guru::all();
    $kriteria = KriteriaPenilaian::all();
    $users = User::all();
    $kelas = Kelas::all();
    $mapel = Mapel::all();
    $semesters = ['ganjil', 'genap']; // bisa disesuaikan

    return view('kepsek.edit', compact(
        'penilaian',
        'guru',
        'kriteria',
        'users',
        'kelas',
        'mapel',
        'semesters'
    ));
}



public function update(Request $request, $id)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user',
        'id_kelas' => 'required|exists:kelas,id',
        'id_mapel' => 'required|exists:mapel,id',
        'tanggal' => 'required|date',
        'semester' => 'required|in:ganjil,genap',
        'nilai' => 'required|array',
        'nilai.*' => 'required|numeric|min:0|max:100',
    ]);

    $penilaian = Penilaian::findOrFail($id);

    DB::beginTransaction();
    try {
        $penilaian->update([
            'id_user' => $request->id_user,
            'id_kelas' => $request->id_kelas,
            'id_mapel' => $request->id_mapel,
            'tanggal' => $request->tanggal,
            'semester' => $request->semester,
        ]);

        foreach ($request->nilai as $id_kriteria => $nilai) {
            DetailPenilaian::updateOrCreate(
                [
                    'id_penilaian' => $penilaian->id_penilaian,
                    'id_kriteria' => $id_kriteria
                ],
                [
                    'nilai' => $nilai
                ]
            );
        }

        DB::commit();
        return redirect()->route('kepsek.index')->with('success', 'Penilaian berhasil diperbarui.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal memperbarui penilaian.')->withInput();
    }
}




    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->detailPenilaian()->delete();
        $penilaian->delete();

        return redirect()->route('kepsek.index')->with('success', 'Penilaian berhasil dihapus.');
    }



   public function downloadUntukKepalaSekolah($id)
{
    $penilaian = Penilaian::with([
        'guru.mapel',               // memuat relasi mapel guru
        'guru.kelas',               // memuat relasi kelas guru
        'detailPenilaian.kriteria' // memuat detail penilaian
    ])->findOrFail($id);

    $pdf = Pdf::loadView('kepsek.single', compact('penilaian'))
        ->setPaper('A4', 'portrait');

    $namaFile = 'penilaian-' . Str::slug($penilaian->guru->nama) . '-' . $penilaian->periode . '.pdf';

    return $pdf->stream($namaFile);
}
}
