<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Imports\ProdiImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ProdiController extends Controller
{
    // Tampilkan semua data prodi
    public function index()
    {
        $prodis = Prodi::all();
        return view('prodi.index', compact('prodis'));
    }

    // Tampilkan form tambah prodi
    public function create()
    {
        return view('prodi.create');
    }

    // Simpan data prodi baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:100',
        ]);

        Prodi::create($request->all());

        return redirect()->route('prodi.index')->with('success', 'Data prodi berhasil ditambahkan.');
    }

    // Tampilkan form edit prodi
    public function edit($id)
    {
        $prodi = Prodi::findOrFail($id);
        return view('prodi.edit', compact('prodi'));
    }

    // Update data prodi
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:100',
        ]);

        $prodi = Prodi::findOrFail($id);
        $prodi->update($request->all());

        return redirect()->route('prodi.index')->with('success', 'Data prodi berhasil diperbarui.');
    }

    // Hapus data prodi
    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id);
        $prodi->delete();

        return redirect()->route('prodi.index')->with('success', 'Data prodi berhasil dihapus.');
    }



    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv',
    ]);

    try {
        Excel::import(new ProdiImport, $request->file('file'));
        return redirect()->route('prodi.index')->with('success', 'Data Prodi berhasil diimport.');
    } catch (\Exception $e) {
        return redirect()->route('prodi.index')->with('error', 'Terjadi kesalahan saat mengimpor file.');
    }
}
}
