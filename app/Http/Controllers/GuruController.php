<?php
namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with(['user', 'mapel', 'kelas', 'semester'])->get(); // tambahkan relasi kelas & semester
        return view('guru.index', compact('guru'));
    }

    public function show($id)
    {
        $guru = Guru::with(['user', 'mapel', 'kelas', 'semester'])->findOrFail($id);
        return view('guru.show', compact('guru'));
    }

    public function create()
    {
        $users = User::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        $semesters = Semester::all(); // ambil semua semester
        return view('guru.create', compact('users', 'mapel', 'kelas', 'semesters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'nip' => 'nullable|string|max:20',
            'nama' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'id_mapel' => 'nullable|exists:mapel,id',
            'id_kelas' => 'nullable|exists:kelas,id',
    'id_semester' => 'required|exists:semester,id', // <-- diperbaiki di sini
        ]);

        Guru::create([
            'id_user' => $request->id_user,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'id_mapel' => $request->id_mapel,
            'id_kelas' => $request->id_kelas,
            'id_semester' => $request->id_semester, // simpan semester sebagai id
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        $users = User::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        $semesters = Semester::all(); // ambil semua semester
        return view('guru.edit', compact('guru', 'users', 'mapel', 'kelas', 'semesters'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'nip' => 'nullable|string|max:20',
            'nama' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'id_mapel' => 'nullable|exists:mapel,id',
            'id_kelas' => 'nullable|exists:kelas,id',
    'id_semester' => 'required|exists:semester,id', // <-- diperbaiki di sini
        ]);

        $guru->update([
            'id_user' => $request->id_user,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'id_mapel' => $request->id_mapel,
            'id_kelas' => $request->id_kelas,
            'id_semester' => $request->id_semester,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
