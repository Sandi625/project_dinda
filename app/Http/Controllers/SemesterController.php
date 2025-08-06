<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    /**
     * Tampilkan daftar semester.
     */
    public function index()
    {
        $semesters = Semester::all();
        return view('semester.index', compact('semesters'));
    }

    /**
     * Tampilkan form tambah semester.
     */
   public function create()
{
    $semesters = Semester::all();
    return view('semester.create', compact('semesters'));
}

    /**
     * Simpan semester baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required|in:ganjil,genap',
            'tahun' => 'required|in:2023,2024,2025,2026,2027',
        ]);

        Semester::create([
            'semester' => $request->semester,
            'tahun' => $request->tahun,
        ]);

        return redirect()->route('semester.index')->with('success', 'Semester berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit semester.
     */
    public function edit($id)
    {
        $semester = Semester::findOrFail($id);
        return view('semester.edit', compact('semester'));
    }

    /**
     * Simpan hasil update semester.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'semester' => 'required|in:ganjil,genap',
            'tahun' => 'required|in:2023,2024,2025,2026,2027',
        ]);

        $semester = Semester::findOrFail($id);
        $semester->update([
            'semester' => $request->semester,
            'tahun' => $request->tahun,
        ]);

        return redirect()->route('semester.index')->with('success', 'Semester berhasil diupdate.');
    }

    /**
     * Hapus semester.
     */
    public function destroy($id)
    {
        $semester = Semester::findOrFail($id);
        $semester->delete();

        return redirect()->route('semester.index')->with('success', 'Semester berhasil dihapus.');
    }
}
