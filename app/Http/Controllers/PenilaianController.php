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
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    // Menampilkan semua penilaian
public function index(Request $request)
{
    $query = Penilaian::with(['guru', 'kelas', 'mapel', 'detailPenilaian.kriteria']);

    if ($request->filled('semester')) {
        $query->where('semester', $request->semester);
    }

    $penilaian = $query->get();

    // Ambil daftar semester unik dari tabel penilaian
    $daftarSemester = Penilaian::select('semester')
        ->distinct()
        ->pluck('semester')
        ->filter()
        ->sort()
        ->values();

    return view('penilaian.index', compact('penilaian', 'daftarSemester'));
}








public function show($id)
{
    $penilaian = Penilaian::with(['guru', 'detailPenilaian.kriteria'])->findOrFail($id);
    return view('penilaian.show', compact('penilaian'));
}




    // Form tambah penilaian + detailpublic function create()
public function create()
{
    $gurus = Guru::all();
    $kriterias = KriteriaPenilaian::all();
    $users = User::all();
    $mapels = Mapel::all();
    $kelas = Kelas::all();

    // Otomatis set periode contoh: 2025 - 2026
    $tahun = date('Y');
    $periode = $tahun . ' - ' . ($tahun + 1);

    // Tambahkan pilihan semester tetap
    $daftarSemester = ['ganjil', 'genap'];

    return view('penilaian.create', compact(
        'gurus', 'kriterias', 'users', 'mapels', 'kelas', 'periode', 'daftarSemester'
    ));
}






public function store(Request $request)
{
    $request->validate([
        'id_guru' => 'required|exists:guru,id_guru',
        'id_user' => 'required|exists:users,id_user',
        'id_mapel' => 'required|exists:mapel,id',
        'id_kelas' => 'required|exists:kelas,id',
        'tanggal' => 'required|date',
        'semester' => 'required|in:ganjil,genap', // ✅ validasi semester
        'detail.*.id_kriteria' => 'required|exists:kriteria_penilaian,id_kriteria',
        'detail.*.nilai' => 'required|numeric|min:0|max:100',
    ]);

    DB::transaction(function() use ($request) {
        $penilaian = Penilaian::create([
            'id_guru' => $request->id_guru,
            'id_user' => $request->id_user,
            'id_mapel' => $request->id_mapel,
            'id_kelas' => $request->id_kelas,
            'tanggal' => $request->tanggal,
            'semester' => $request->semester, // ✅ simpan semester
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
    $penilaian = Penilaian::with('guru', 'detailPenilaian.kriteria')->findOrFail($id);
    $gurus = Guru::all();
    $kriterias = KriteriaPenilaian::all();
    $users = User::all();
    $mapels = Mapel::all();
    $kelas = Kelas::all();

    $daftarSemester = ['ganjil', 'genap']; // ✅ bukan dari guru

    return view('penilaian.edit', compact('penilaian', 'gurus', 'kriterias', 'users', 'mapels', 'kelas', 'daftarSemester'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'id_guru' => 'required|exists:guru,id_guru',
        'id_user' => 'required|exists:users,id_user',
        'id_mapel' => 'required|exists:mapel,id',
        'id_kelas' => 'required|exists:kelas,id',
        'tanggal' => 'required|date',
        'semester' => 'required|in:ganjil,genap', // ✅ validasi semester
        'detail.*.id_kriteria' => 'required|exists:kriteria_penilaian,id_kriteria',
        'detail.*.nilai' => 'required|numeric|min:0|max:100',
    ]);

    try {
        DB::transaction(function () use ($request, $id) {
            $penilaian = Penilaian::findOrFail($id);

            Log::info('UPDATE PENILAIAN', [
                'id_penilaian' => $id,
                'semester_from_request' => $request->semester,
                'before_update' => $penilaian->semester,
            ]);

            $penilaian->update([
                'id_guru'   => $request->id_guru,
                'id_user'   => $request->id_user,
                'id_mapel'  => $request->id_mapel,
                'id_kelas'  => $request->id_kelas,
                'tanggal'   => $request->tanggal,
                'semester'  => $request->semester, // ✅ simpan semester
            ]);

            $penilaian->refresh();
            Log::info('AFTER UPDATE PENILAIAN', [
                'after_update' => $penilaian->semester,
            ]);

            DetailPenilaian::where('id_penilaian', $penilaian->id_penilaian)->delete();

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
