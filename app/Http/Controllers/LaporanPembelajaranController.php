<?php

namespace App\Http\Controllers;

use App\Models\LaporanPembelajaran;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanPembelajaranController extends Controller
{
    /**
     * Tampilkan semua laporan milik guru yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();

        // Pastikan user punya relasi guru
        if (!$user->guru) {
            abort(403, 'Anda bukan guru.');
        }

        $laporan = LaporanPembelajaran::with(['kelas', 'mapel'])
            ->where('id_guru', $user->guru->id_guru)
            ->orderByDesc('bulan')
            ->get();

return view('guru.laporan.index', ['laporanList' => $laporan]);
    }


    /**
 * Tampilkan detail laporan.
 */
public function show($id)
{
    $laporan = LaporanPembelajaran::with(['kelas', 'mapel'])->findOrFail($id);

    // Cegah akses oleh guru lain
    if ($laporan->id_guru !== Auth::user()->guru->id_guru) {
        abort(403, 'Akses ditolak.');
    }

    return view('guru.laporan.show', compact('laporan'));
}


    /**
     * Tampilkan form buat laporan baru.
     */
    public function create()
    {
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        return view('guru.laporan.create', compact('kelas', 'mapel'));
    }

    /**
     * Simpan laporan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id',
            'id_mapel' => 'required|exists:mapel,id',
            'bulan' => 'required|string',
            'materi' => 'nullable|string',
            'metode' => 'nullable|string',
            'jumlah_pertemuan' => 'nullable|integer',
            'rata_kehadiran' => 'nullable|string',
            'evaluasi' => 'nullable|string',
            'kendala' => 'nullable|string',
            'solusi' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $user = Auth::user();

        if (!$user->guru) {
            abort(403, 'Anda bukan guru.');
        }

        LaporanPembelajaran::create([
            'id_guru' => $user->guru->id_guru,
            'id_kelas' => $request->id_kelas,
            'id_mapel' => $request->id_mapel,
            'bulan' => $request->bulan,
            'materi' => $request->materi,
            'metode' => $request->metode,
            'jumlah_pertemuan' => $request->jumlah_pertemuan,
            'rata_kehadiran' => $request->rata_kehadiran,
            'evaluasi' => $request->evaluasi,
            'kendala' => $request->kendala,
            'solusi' => $request->solusi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil disimpan.');
    }

    /**
     * Tampilkan form edit laporan.
     */
    public function edit($id)
    {
        $laporan = LaporanPembelajaran::findOrFail($id);

        // Cegah akses oleh guru lain
        if ($laporan->id_guru !== Auth::user()->guru->id_guru) {
            abort(403, 'Akses ditolak.');
        }

        $kelas = Kelas::all();
        $mapel = Mapel::all();
        return view('guru.laporan.edit', compact('laporan', 'kelas', 'mapel'));
    }

    /**
     * Update laporan.
     */
    public function update(Request $request, $id)
    {
        $laporan = LaporanPembelajaran::findOrFail($id);

        if ($laporan->id_guru !== Auth::user()->guru->id_guru) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'id_kelas' => 'required|exists:kelas,id',
            'id_mapel' => 'required|exists:mapel,id',
            'bulan' => 'required|string',
            'materi' => 'nullable|string',
            'metode' => 'nullable|string',
            'jumlah_pertemuan' => 'nullable|integer',
            'rata_kehadiran' => 'nullable|string',
            'evaluasi' => 'nullable|string',
            'kendala' => 'nullable|string',
            'solusi' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $laporan->update($request->all());

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Hapus laporan.
     */
    public function destroy($id)
    {
        $laporan = LaporanPembelajaran::findOrFail($id);

        if ($laporan->id_guru !== Auth::user()->guru->id_guru) {
            abort(403, 'Akses ditolak.');
        }

        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
