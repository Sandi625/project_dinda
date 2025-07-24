<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use App\Exports\JadwalSingleExport;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Maatwebsite\Excel\Facades\Excel;

class JadwalMengajarController extends Controller
{
    public function index()
    {
        $jadwals = JadwalMengajar::with(['guru', 'mapel', 'kelas'])->orderBy('hari')->orderBy('jam_ke')->get();
        return view('jadwal.index', compact('jadwals'));
    }

   public function create()
{
    $gurus = Guru::all();
    $mapels = Mapel::all();
    $kelas = Kelas::all();
        $users = User::all(); // pastikan model User di-import


    // kirim $jamMapping juga kalau mau tampilkan range waktu di form
    $jamMapping = [
        1 => '07:00 - 07:45',
        2 => '07:45 - 08:30',
        3 => '08:30 - 09:15',
        4 => '09:15 - 10:00',
        5 => '10:20 - 11:05',
        6 => '11:05 - 11:50',
        7 => '12:30 - 13:10',
        8 => '13:10 - 13:50',
        9 => '13:50 - 14:30',
        10 => '14:30 - 15:10',
    ];

    return view('jadwal.create', compact('gurus', 'mapels', 'kelas', 'jamMapping','users'));
}

public function store(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user', // validasi id_user
        'id_guru' => 'required|exists:guru,id_guru',
        'id_mapel' => 'required|exists:mapel,id',
        'id_kelas' => 'required|exists:kelas,id',
        'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
        'jam_ke' => 'required|array',
        'jam_ke.*' => 'required|integer|min:1|max:10',
    ]);

    $idUser = $request->id_user;
    $idGuru = $request->id_guru;
    $hari = $request->hari;
    $jamKeArray = $request->jam_ke;

    // Cek apakah ada bentrok jadwal
    foreach ($jamKeArray as $jamKe) {
        $existing = JadwalMengajar::where('id_guru', $idGuru)
            ->where('hari', $hari)
            ->where('jam_ke', $jamKe)
            ->first();

        if ($existing) {
            return back()->withErrors([
                'jam_ke' => "Guru ini sudah memiliki jadwal pada hari $hari jam ke-$jamKe.",
            ])->withInput();
        }
    }

    // Simpan semua jam_ke yang valid
    foreach ($jamKeArray as $jamKe) {
        JadwalMengajar::create([
            'id_user' => $idUser, // simpan ke kolom id_user
            'id_guru' => $idGuru,
            'id_mapel' => $request->id_mapel,
            'id_kelas' => $request->id_kelas,
            'hari' => $hari,
            'jam_ke' => $jamKe,
        ]);
    }

    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
}



   public function edit($id)
{
    $jadwal = JadwalMengajar::findOrFail($id);
    $gurus = Guru::all();
    $mapels = Mapel::all();
    $kelas = Kelas::all();
    $users = User::all(); // tambahkan ini

    return view('jadwal.edit', compact('jadwal', 'gurus', 'mapels', 'kelas', 'users'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user',
        'id_guru' => 'required|exists:guru,id_guru',
        'id_mapel' => 'required|exists:mapel,id',
        'id_kelas' => 'required|exists:kelas,id',
        'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
        'jam_ke' => 'required|integer|min:1|max:10',
    ]);

    $jadwal = JadwalMengajar::findOrFail($id);
    $jadwal->update([
        'id_user' => $request->id_user,
        'id_guru' => $request->id_guru,
        'id_mapel' => $request->id_mapel,
        'id_kelas' => $request->id_kelas,
        'hari' => $request->hari,
        'jam_ke' => $request->jam_ke,
    ]);

    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diupdate.');
}


    public function destroy($id)
    {
        $jadwal = JadwalMengajar::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }


    public function exportSingle($id)
{
    $jadwal = JadwalMengajar::with(['mapel', 'kelas'])->findOrFail($id);
    $filename = 'jadwal-' . $jadwal->id . '-' . now()->format('Ymd_His') . '.xlsx';

    return Excel::download(new JadwalSingleExport($jadwal), $filename);
}
}
