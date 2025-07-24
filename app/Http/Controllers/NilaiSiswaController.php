<?php

namespace App\Http\Controllers;

use App\Models\NilaiSiswa;
use Illuminate\Http\Request;
use App\Imports\NilaiSiswaImport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class NilaiSiswaController extends Controller
{
  public function index()
{
    $nilai = NilaiSiswa::orderByDesc('tanggal')->get();
    $rataRata = $nilai->avg('nilai'); // menghitung rata-rata kolom 'nilai'

    return view('nilai_siswa.index', compact('nilai', 'rataRata'));
}


    public function create()
    {
        return view('nilai_siswa.create');
    }

public function store(Request $request)
{
    $request->validate([
        'nama_siswa' => 'required|string|max:100',
        'nisn'       => 'required|string|max:20',
        'kelas'      => 'required|string|max:50',
        'mapel'      => 'required|string|max:50',
        'kriteria'   => 'required|string|max:100',
        'semester'   => 'required|in:ganjil,genap',
        'nilai'      => 'required|numeric|min:0|max:100',
        'tanggal'    => 'required|date',
        'nama_guru'  => 'required|string|max:100', // ✅ tambahkan ini
    ]);

    NilaiSiswa::create($request->all());

    return redirect()->route('nilai-siswa.index')->with('success', 'Data nilai siswa berhasil disimpan.');
}


    public function edit($id)
    {
        $nilai = NilaiSiswa::findOrFail($id);
        return view('nilai_siswa.edit', compact('nilai'));
    }

  public function update(Request $request, $id)
{
    $request->validate([
        'nama_siswa' => 'required|string|max:100',
        'nisn'       => 'required|string|max:20',
        'kelas'      => 'required|string|max:50',
        'mapel'      => 'required|string|max:50',
        'kriteria'   => 'required|string|max:100',
        'semester'   => 'required|in:ganjil,genap',
        'nilai'      => 'required|numeric|min:0|max:100',
        'tanggal'    => 'required|date',
        'nama_guru'  => 'required|string|max:100', // ✅ tambahkan ini
    ]);

    $nilai = NilaiSiswa::findOrFail($id);
    $nilai->update($request->all());

    return redirect()->route('nilai-siswa.index')->with('success', 'Data nilai siswa berhasil diperbarui.');
}


    public function destroy($id)
    {
        $nilai = NilaiSiswa::findOrFail($id);
        $nilai->delete();

        return redirect()->route('nilai-siswa.index')->with('success', 'Data nilai siswa berhasil dihapus.');
    }

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xls,xlsx'
    ]);

    try {
        Excel::import(new NilaiSiswaImport, $request->file('file'));

        return redirect()->route('nilai-siswa.index')->with('success', 'Data berhasil diimpor.');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        return redirect()->back()->with('error', 'Format file tidak valid atau struktur data salah.');
    } catch (\Throwable $e) {
        Log::error('Gagal impor nilai: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor. Pastikan kolom tanggal menggunakan format tanggal (bukan angka serial Excel).');
    }
}

}
