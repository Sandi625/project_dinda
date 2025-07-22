<?php
namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with(['user', 'mapel'])->get(); // tambahkan relasi mapel
        return view('guru.index', compact('guru'));
    }

    public function show($id)
    {
        $guru = Guru::with(['user', 'mapel'])->findOrFail($id);
        return view('guru.show', compact('guru'));
    }

    public function create()
    {
        $users = User::all();
        $mapel = Mapel::all(); // ambil semua mapel
          $kelas = Kelas::all(); // Tambahkan kelas
    return view('guru.create', compact('users', 'mapel', 'kelas'));
    }

public function store(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user',
        'nip' => 'nullable|string|max:20',
        'nama' => 'required|string|max:100',
        'alamat' => 'nullable|string',
        'id_mapel' => 'nullable|exists:mapel,id',
        'id_kelas' => 'nullable|exists:kelas,id', // Validasi id_kelas
        'semester' => 'required|in:ganjil,genap', // ✅ validasi semester

    ]);

    Guru::create([
        'id_user' => $request->id_user,
        'nip' => $request->nip,
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'id_mapel' => $request->id_mapel,
        'id_kelas' => $request->id_kelas, // Tambahkan ini
        'semester' => $request->semester, // ✅ input semester

    ]);

    return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
}
    public function edit(Guru $guru)
    {
        $users = User::all();
        $mapel = Mapel::all(); // ambil semua mapel
       $kelas = Kelas::all(); // Tambahkan kelas
    return view('guru.edit', compact('guru', 'users', 'mapel', 'kelas'));
    }

public function update(Request $request, Guru $guru)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user',
        'nip' => 'nullable|string|max:20',
        'nama' => 'required|string|max:100',
        'alamat' => 'nullable|string',
        'id_mapel' => 'nullable|exists:mapel,id',
        'id_kelas' => 'nullable|exists:kelas,id', // Validasi id_kelas
        'semester' => 'required|in:ganjil,genap', // ✅ validasi semester

    ]);

    $guru->update([
        'id_user' => $request->id_user,
        'nip' => $request->nip,
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'id_mapel' => $request->id_mapel,
        'id_kelas' => $request->id_kelas, // Tambahkan ini
        'semester' => $request->semester, // ✅ update semester

    ]);

    return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate.');
}

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
