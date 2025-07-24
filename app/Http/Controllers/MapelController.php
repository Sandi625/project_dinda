<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Imports\MapelImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class MapelController extends Controller
{
    // Menampilkan semua data mapel
    public function index()
    {
        $mapel = Mapel::all();
        return view('mapel.index', compact('mapel'));
    }

    // Menampilkan form tambah
    public function create()
    {
        return view('mapel.create');
    }

    // Menyimpan data mapel baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:100',
        ]);

        Mapel::create([
            'nama_mapel' => $request->nama_mapel,
        ]);

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil ditambahkan.');
    }

    // Menampilkan form edit mapel
    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);
        return view('mapel.edit', compact('mapel'));
    }

    // Menyimpan perubahan mapel
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:100',
        ]);

        $mapel = Mapel::findOrFail($id);
        $mapel->update([
            'nama_mapel' => $request->nama_mapel,
        ]);

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil diperbarui.');
    }

    // Menghapus mapel
    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil dihapus.');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    try {
        Excel::import(new MapelImport, $request->file('file'));
        return redirect()->route('mapel.index')->with('success', 'Data mapel berhasil diimport.');
    } catch (\Exception $e) {
        return redirect()->route('mapel.index')->with('error', 'Gagal mengimport data: ' . $e->getMessage());
    }
}

}
