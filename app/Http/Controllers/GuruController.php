<?php
namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Mapel;
use Illuminate\Http\Request;

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
        return view('guru.create', compact('users', 'mapel'));
    }

  public function store(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user',
        'nip' => 'nullable|string|max:20',
        'nama' => 'required|string|max:100',
        'alamat' => 'nullable|string',
        'id_mapel' => 'nullable|exists:mapel,id',
        'periode_mulai' => 'nullable|digits:4|integer|min:2000|max:' . (date('Y') + 10),
        'periode_selesai' => 'nullable|digits:4|integer|min:2000|max:' . (date('Y') + 10),
    ]);

    Guru::create([
        'id_user' => $request->id_user,
        'nip' => $request->nip,
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'id_mapel' => $request->id_mapel,
        'periode_mulai' => $request->periode_mulai,
        'periode_selesai' => $request->periode_selesai,
    ]);

    return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
}
    public function edit(Guru $guru)
    {
        $users = User::all();
        $mapel = Mapel::all(); // ambil semua mapel
        return view('guru.edit', compact('guru', 'users', 'mapel'));
    }

 public function update(Request $request, Guru $guru)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user',
        'nip' => 'nullable|string|max:20',
        'nama' => 'required|string|max:100',
        'alamat' => 'nullable|string',
        'id_mapel' => 'nullable|exists:mapel,id',
        'periode_mulai' => 'nullable|digits:4|integer|min:2000|max:' . (date('Y') + 10),
        'periode_selesai' => 'nullable|digits:4|integer|min:2000|max:' . (date('Y') + 10),
    ]);

    $guru->update([
        'id_user' => $request->id_user,
        'nip' => $request->nip,
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'id_mapel' => $request->id_mapel,
        'periode_mulai' => $request->periode_mulai,
        'periode_selesai' => $request->periode_selesai,
    ]);

    return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate.');
}

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
