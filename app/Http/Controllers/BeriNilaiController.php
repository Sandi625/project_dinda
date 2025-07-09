<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BeriNilaiController extends Controller
{
    // Form untuk memilih kelas dan mapel (untuk memberi nilai)
public function index()
{
    $guru = \App\Models\Guru::where('id_user', Auth::id())->firstOrFail();

    // Guru hanya boleh memilih mapel miliknya
    $mapel = \App\Models\Mapel::where('id', $guru->id_mapel)->get();

    // Semua kelas boleh dipilih
    $kelas = \App\Models\Kelas::all();

    return view('nilai.pilih', compact('kelas', 'mapel'));
}




    // Menampilkan form nilai siswa berdasarkan kelas & mapel
public function form(Request $request)
{
    $request->validate([
        'id_kelas' => 'required|exists:kelas,id',
        'id_mapel' => 'required|exists:mapel,id',
    ]);

    $guru = \App\Models\Guru::where('id_user', Auth::id())->firstOrFail();

    // Hanya izinkan akses mapel milik guru
    if ($guru->id_mapel != $request->id_mapel) {
        abort(403, 'Anda tidak diizinkan mengakses mapel ini.');
    }

    // Ambil data siswa berdasarkan kelas dan mapel
    $siswa = \App\Models\Siswa::where('id_kelas', $request->id_kelas)
                              ->where('id_mapel', $request->id_mapel)
                              ->get();

    $kelas = \App\Models\Kelas::findOrFail($request->id_kelas);
    $mapel = \App\Models\Mapel::findOrFail($request->id_mapel);

    return view('nilai.form', compact('siswa', 'kelas', 'mapel'));
}




    // Simpan nilai siswa dari guru
    public function simpan(Request $request)
    {
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|integer|min:0|max:100',
        ]);

        foreach ($request->nilai as $id => $nilai) {
            $siswa = Siswa::find($id);
            if ($siswa) {
                $siswa->update([
                    'nilai' => $nilai,
                ]);
            }
        }

        return redirect()->route('beri-nilai.index')->with('success', 'Nilai berhasil disimpan.');
    }

    // Form untuk melihat nilai siswa (pilih kelas & mapel)
   public function lihat()
{
    $guru = \App\Models\Guru::where('id_user', auth()->id())->firstOrFail();

    // Guru hanya melihat mapel miliknya
    $mapel = \App\Models\Mapel::where('id', $guru->id_mapel)->get();

    // Semua kelas boleh dipilih
    $kelas = \App\Models\Kelas::all();

    return view('nilai.lihat', compact('kelas', 'mapel'));
}


    // Tampilkan hasil nilai siswa
   public function hasil(Request $request)
{
    $request->validate([
        'id_kelas' => 'required|exists:kelas,id',
        'id_mapel' => 'required|exists:mapel,id',
    ]);

    $guru = \App\Models\Guru::where('id_user', auth()->id())->firstOrFail();

    // Cegah akses ke mapel yang bukan milik guru
    if ($guru->id_mapel != $request->id_mapel) {
        abort(403, 'Anda tidak memiliki akses untuk melihat nilai mapel ini.');
    }

    $kelas = \App\Models\Kelas::findOrFail($request->id_kelas);
    $mapel = \App\Models\Mapel::findOrFail($request->id_mapel);

    $siswa = \App\Models\Siswa::where('id_kelas', $request->id_kelas)
                              ->where('id_mapel', $request->id_mapel)
                              ->get();

    return view('nilai.hasil', compact('siswa', 'kelas', 'mapel'));
}

}
