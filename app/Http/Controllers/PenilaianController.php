<?php

namespace App\Http\Controllers;
use App\Models\Guru;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Semester;
use App\Models\Penilaian;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DetailPenilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KriteriaPenilaian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    // Menampilkan semua penilaian
public function index(Request $request)
{
    // Ambil input id_semester dari request
    $idSemesterDipilih = $request->input('id_semester');

    // Ambil data penilaian beserta relasi terkait, SEKARANG sudah termasuk 'guru'
    $penilaian = Penilaian::with([
        'guru', // ✅ ditambahkan
        'kelas',
        'mapel',
        'semester',
        'detailPenilaian.kriteria'
    ])
    ->when($idSemesterDipilih, function ($query) use ($idSemesterDipilih) {
        $query->where('id_semester', $idSemesterDipilih);
    })
    ->get();

    // Ambil daftar semester untuk dropdown filter
    $daftarSemester = \App\Models\Semester::orderByDesc('tahun')
        ->orderBy('semester')
        ->get();

    return view('penilaian.index', compact('penilaian', 'daftarSemester', 'idSemesterDipilih'));
}














public function show($id)
{
    $penilaian = Penilaian::with(['guru', 'detailPenilaian.kriteria'])->findOrFail($id);
    return view('penilaian.show', compact('penilaian'));
}




    // Form tambah penilaian + detailpublic function create()
public function create()
{
    $kriterias = KriteriaPenilaian::all();
    $users = User::all();
    $semesters = Semester::all();
    $gurus = Guru::with(['mapel', 'kelas'])->get();

    // Ambil hanya mapel dan kelas dari data guru yang ada
    $mapels = $gurus->pluck('mapel')->unique('id')->values();
    $kelas = $gurus->pluck('kelas')->unique('id')->values();

    $tahun = date('Y');
    $periode = $tahun . ' - ' . ($tahun + 1);

    return view('penilaian.create', compact(
        'kriterias', 'users', 'mapels', 'kelas', 'periode', 'semesters', 'gurus'
    ));
}

public function getMapelKelasByGuru($id_guru)
{
    $guru = Guru::with(['mapel', 'kelas'])->findOrFail($id_guru);

    return response()->json([
        'mapel' => [
            'id' => $guru->mapel->id ?? null,
            'nama_mapel' => $guru->mapel->nama_mapel ?? null,
        ],
        'kelas' => [
            'id' => $guru->kelas->id ?? null,
            'nama_kelas' => $guru->kelas->nama_kelas ?? null,
        ]
    ]);
}

















public function store(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user',
        'id_guru' => 'required|exists:guru,id_guru', // ✅ tambahkan validasi guru
        'id_mapel' => 'required|exists:mapel,id',
        'id_kelas' => 'required|exists:kelas,id',
        'id_semester' => 'required|exists:semester,id',
        'tanggal' => 'required|date',
        'detail.*.id_kriteria' => 'required|exists:kriteria_penilaian,id_kriteria',
        'detail.*.nilai' => 'required|numeric|min:0|max:100',
    ]);

    DB::transaction(function() use ($request) {
        $penilaian = Penilaian::create([
            'id_user' => $request->id_user,
            'id_guru' => $request->id_guru, // ✅ simpan guru
            'id_mapel' => $request->id_mapel,
            'id_kelas' => $request->id_kelas,
            'id_semester' => $request->id_semester,
            'tanggal' => $request->tanggal,
        ]);

        foreach ($request->detail as $d) {
            DetailPenilaian::create([
                'id_penilaian' => $penilaian->id_penilaian,
                'id_kriteria' => $d['id_kriteria'],
                'nilai' => $d['nilai'],
            ]);
        }
    });

    return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil ditambahkan.');
}





    // Form edit penilaian + detail
public function edit($id)
{
    $penilaian = Penilaian::with(['detailPenilaian.kriteria', 'semester', 'guru'])->findOrFail($id); // ✅ tambahkan 'guru'

    $kriterias = KriteriaPenilaian::all();
    $users = User::all();
    $mapels = Mapel::all();
    $kelas = Kelas::all();
    $semesters = Semester::all();
    $gurus = Guru::all(); // ✅ ambil data guru

    return view('penilaian.edit', compact(
        'penilaian',
        'kriterias',
        'users',
        'mapels',
        'kelas',
        'semesters',
        'gurus' // ✅ kirim ke view
    ));
}






public function update(Request $request, $id)
{
    $request->validate([
        'id_user'     => 'required|exists:users,id_user',
        'id_guru'     => 'required|exists:guru,id_guru', // ✅ Validasi guru
        'id_mapel'    => 'required|exists:mapel,id',
        'id_kelas'    => 'required|exists:kelas,id',
        'tanggal'     => 'required|date',
        'id_semester' => 'required|exists:semester,id',
        'detail.*.id_kriteria' => 'required|exists:kriteria_penilaian,id_kriteria',
        'detail.*.nilai'       => 'required|numeric|min:0|max:100',
    ]);

    try {
        DB::transaction(function () use ($request, $id) {
            $penilaian = Penilaian::findOrFail($id);

            $penilaian->update([
                'id_user'     => $request->id_user,
                'id_guru'     => $request->id_guru, // ✅ Update guru
                'id_mapel'    => $request->id_mapel,
                'id_kelas'    => $request->id_kelas,
                'tanggal'     => $request->tanggal,
                'id_semester' => $request->id_semester,
            ]);

            // Hapus detail lama
            DetailPenilaian::where('id_penilaian', $penilaian->id_penilaian)->delete();

            // Simpan detail baru
            foreach ($request->detail as $d) {
                DetailPenilaian::create([
                    'id_penilaian' => $penilaian->id_penilaian,
                    'id_kriteria'  => $d['id_kriteria'],
                    'nilai'        => $d['nilai'],
                ]);
            }
        });

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil diperbarui.');
    } catch (\Exception $e) {
        Log::error('ERROR UPDATE PENILAIAN', ['error' => $e->getMessage()]);
        return back()->withErrors(['msg' => 'Terjadi kesalahan saat update: ' . $e->getMessage()]);
    }
}










    // Hapus penilaian + detail
    public function destroy($id)
    {
        DB::transaction(function() use ($id) {
            DetailPenilaian::where('id_penilaian', $id)->delete();
            Penilaian::destroy($id);
        });

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil dihapus.');
    }



public function exportPdf()
{
    $penilaian = Penilaian::with(['guru', 'detailPenilaian.kriteria'])->get();

    $pdf = Pdf::loadView('penilaian.pdf', compact('penilaian'))->setPaper('A4', 'landscape');
    return $pdf->stream('data-penilaian.pdf');
}

public function downloadPerPenilaian($id)
{
    $penilaian = Penilaian::with(['guru', 'detailPenilaian.kriteria'])
        ->findOrFail($id);

    $pdf = Pdf::loadView('penilaian.single', compact('penilaian'))
        ->setPaper('A4', 'portrait');

    $namaFile = 'penilaian-' . Str::slug($penilaian->guru->nama) . '-' . $penilaian->periode . '.pdf';

    return $pdf->download($namaFile);
}

}
