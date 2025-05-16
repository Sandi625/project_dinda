<?php

namespace App\Http\Controllers;

use App\Models\KriteriaPenilaian;
use Illuminate\Http\Request;

class KriteriaPenilaianController extends Controller
{
    // Tampilkan daftar semua kriteria
    public function index()
    {
        $kriteria = KriteriaPenilaian::all();
        return view('kriteria_penilaian.index', compact('kriteria'));
    }

    // Tampilkan form tambah kriteria
    public function create()
    {
        return view('kriteria_penilaian.create');
    }

    // Simpan data kriteria baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'bobot' => 'required|numeric|between:0,100',
        ]);

        KriteriaPenilaian::create($validated);

        return redirect()->route('kriteria_penilaian.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    // Tampilkan form edit kriteria
    public function edit($id)
    {
        $kriteria = KriteriaPenilaian::findOrFail($id);
        return view('kriteria_penilaian.edit', compact('kriteria'));
    }

    // Update data kriteria
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'bobot' => 'required|numeric|between:0,100',
        ]);

        $kriteria = KriteriaPenilaian::findOrFail($id);
        $kriteria->update($validated);

        return redirect()->route('kriteria_penilaian.index')->with('success', 'Kriteria berhasil diupdate.');
    }

    // Hapus kriteria
    public function destroy($id)
    {
        $kriteria = KriteriaPenilaian::findOrFail($id);
        $kriteria->delete();

        return redirect()->route('kriteria_penilaian.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
