<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['kelas', 'mapel'])->get();
        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        return view('siswa.create', compact('kelas', 'mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nis' => 'required|string|max:30|unique:siswa',
            'id_kelas' => 'required|exists:kelas,id',
            'id_mapel' => 'required|exists:mapel,id',
            // 'nilai' => 'nullable|integer|min:0|max:100',
        ]);

        Siswa::create($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        return view('siswa.edit', compact('siswa', 'kelas', 'mapel'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nis' => 'required|string|max:30|unique:siswa,nis,' . $siswa->id,
            'id_kelas' => 'required|exists:kelas,id',
            'id_mapel' => 'required|exists:mapel,id',
            // 'nilai' => 'nullable|integer|min:0|max:100',
        ]);

        $siswa->update($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
