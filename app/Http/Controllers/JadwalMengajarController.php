<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class JadwalMengajarController extends Controller
{
    public function index()
    {
        $jadwal = JadwalMengajar::with(['guru', 'mapel', 'kelas'])->get();
        return view('jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $gurus = Guru::all();
        $mapels = Mapel::all();
        $kelas = Kelas::all();
        return view('jadwal.create', compact('gurus', 'mapels', 'kelas'));
    }

 public function store(Request $request)
{
    $request->validate([
        'guru_id'     => 'required|exists:guru,id_guru',
        'mapel_id'    => 'required|exists:mapel,id',
        'kelas_id'    => 'required|exists:kelas,id',
        'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
        'jam_mulai'   => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
    ]);

    try {
        // Gunakan timezone Asia/Jakarta
        $jamMulai = Carbon::createFromFormat('H:i', $request->jam_mulai, 'Asia/Jakarta')->format('H:i:s');
        $jamSelesai = Carbon::createFromFormat('H:i', $request->jam_selesai, 'Asia/Jakarta')->format('H:i:s');

        JadwalMengajar::create([
            'guru_id'     => $request->guru_id,
            'mapel_id'    => $request->mapel_id,
            'kelas_id'    => $request->kelas_id,
            'hari'        => $request->hari,
            'jam_mulai'   => $jamMulai,
            'jam_selesai' => $jamSelesai,
        ]);

        return redirect()->route('jadwal-mengajar.index')->with('success', 'Jadwal berhasil ditambahkan.');
    } catch (\Exception $e) {
        Log::error('Gagal menyimpan jadwal: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
    }
}

    public function edit($id)
    {
        $jadwal = JadwalMengajar::findOrFail($id);
        $gurus  = Guru::all();
        $mapels = Mapel::all();
        $kelas  = Kelas::all();
        return view('jadwal.edit', compact('jadwal', 'gurus', 'mapels', 'kelas'));
    }

  public function update(Request $request, $id)
{
    $request->validate([
        'guru_id'     => 'required|exists:guru,id_guru',
        'mapel_id'    => 'required|exists:mapel,id',
        'kelas_id'    => 'required|exists:kelas,id',
        'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
        'jam_mulai'   => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
    ]);

    try {
        $jamMulai = Carbon::createFromFormat('H:i', $request->jam_mulai, 'Asia/Jakarta')->format('H:i:s');
        $jamSelesai = Carbon::createFromFormat('H:i', $request->jam_selesai, 'Asia/Jakarta')->format('H:i:s');

        $jadwal = JadwalMengajar::findOrFail($id);
        $jadwal->update([
            'guru_id'     => $request->guru_id,
            'mapel_id'    => $request->mapel_id,
            'kelas_id'    => $request->kelas_id,
            'hari'        => $request->hari,
            'jam_mulai'   => $jamMulai,
            'jam_selesai' => $jamSelesai,
        ]);

        return redirect()->route('jadwal-mengajar.index')->with('success', 'Jadwal berhasil diperbarui.');
    } catch (\Exception $e) {
        Log::error('Gagal update jadwal: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.']);
    }
}

    public function destroy($id)
    {
        try {
            $jadwal = JadwalMengajar::findOrFail($id);
            $jadwal->delete();
            return redirect()->route('jadwal-mengajar.index')->with('success', 'Jadwal berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal hapus jadwal: ' . $e->getMessage());
            return redirect()->route('jadwal-mengajar.index')->withErrors(['error' => 'Gagal menghapus data.']);
        }
    }
}
