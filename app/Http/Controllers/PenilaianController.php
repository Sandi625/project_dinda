<?php

namespace App\Http\Controllers;
use App\Models\Guru;

use App\Models\User;
use App\Models\Penilaian;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DetailPenilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KriteriaPenilaian;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    // Menampilkan semua penilaian
public function index(Request $request)
{
    // Ambil semua penilaian, relasi guru dan kriteria
    $query = Penilaian::with(['guru', 'detailPenilaian.kriteria']);

    // Jika request mengandung filter periode, terapkan
    if ($request->filled('periode')) {
        $query->where('periode', $request->periode);
    }

    // Ambil hasil penilaian (terurut dari tanggal terbaru)
    $penilaian = $query->orderByDesc('tanggal')->get();

    // Ambil daftar periode unik (untuk filter dropdown)
    $daftarPeriode = Penilaian::select('periode')
        ->distinct()
        ->orderByDesc('periode')
        ->pluck('periode');

    return view('penilaian.index', compact('penilaian', 'daftarPeriode'));
}


public function show($id)
{
    $penilaian = Penilaian::with(['guru', 'detailPenilaian.kriteria'])->findOrFail($id);
    return view('penilaian.show', compact('penilaian'));
}




    // Form tambah penilaian + detail
public function create()
{
    $gurus = Guru::all();
    $kriterias = KriteriaPenilaian::all();
    $users = User::all();

    // Otomatis set periode contoh: 2025 - 2026
    $tahun = date('Y');
    $periode = $tahun . ' - ' . ($tahun + 1);

    return view('penilaian.create', compact('gurus', 'kriterias', 'users', 'periode'));
}



public function store(Request $request)
{
    $request->validate([
        'id_guru' => 'required|exists:guru,id_guru',
        'id_user' => 'required|exists:users,id_user', // ✅ validasi user jika dipilih dari dropdown
        'periode' => 'required',
        'tanggal' => 'required|date',
        'detail.*.id_kriteria' => 'required|exists:kriteria_penilaian,id_kriteria',
        'detail.*.nilai' => 'required|numeric',
    ]);

    DB::transaction(function() use ($request) {
        $penilaian = Penilaian::create([
            'id_guru' => $request->id_guru,
            'id_user' => $request->id_user, // ✅ gunakan dari request (dropdown)
            'periode' => $request->periode,
            'tanggal' => $request->tanggal,
        ]);

        foreach ($request->detail as $d) {
            DetailPenilaian::create([
                'id_penilaian' => $penilaian->id_penilaian,
                'id_kriteria' => $d['id_kriteria'],
                'nilai' => $d['nilai'],
            ]);
        }
    });

    return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil ditambahkan.');
}
    // Form edit penilaian + detail
 public function edit($id)
{
    $penilaian = Penilaian::with('guru', 'detailPenilaian.kriteria')->findOrFail($id);
    $gurus = Guru::all();
    $kriterias = KriteriaPenilaian::all();
    $users = User::all();

    return view('penilaian.edit', compact('penilaian', 'gurus', 'kriterias', 'users'));
}


    // Update penilaian + detail
  public function update(Request $request, $id)
{
    $request->validate([
        'id_guru' => 'required|exists:guru,id_guru',
        'id_user' => 'required|exists:users,id_user', // ✅ validasi id_user dari dropdown
        'periode' => 'required',
        'tanggal' => 'required|date',
        'detail.*.id_kriteria' => 'required|exists:kriteria_penilaian,id_kriteria',
        'detail.*.nilai' => 'required|numeric',
    ]);

    DB::transaction(function () use ($request, $id) {
        $penilaian = Penilaian::findOrFail($id);

        // Update data utama
        $penilaian->update([
            'id_guru' => $request->id_guru,
            'id_user' => $request->id_user, // ✅ simpan user yang dipilih
            'periode' => $request->periode,
            'tanggal' => $request->tanggal,
        ]);

        // Hapus semua detail sebelumnya
        DetailPenilaian::where('id_penilaian', $penilaian->id_penilaian)->delete();

        // Tambah ulang detail
        foreach ($request->detail as $d) {
            DetailPenilaian::create([
                'id_penilaian' => $penilaian->id_penilaian,
                'id_kriteria' => $d['id_kriteria'],
                'nilai' => $d['nilai'],
            ]);
        }
    });

    return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil diperbarui.');
}

    // Hapus penilaian + detail
    public function destroy($id)
    {
        DB::transaction(function() use ($id) {
            DetailPenilaian::where('id_penilaian', $id)->delete();
            Penilaian::destroy($id);
        });

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil dihapus.');
    }



public function exportPdf()
{
    $penilaian = Penilaian::with(['guru', 'detailPenilaian.kriteria'])->get();

    $pdf = Pdf::loadView('penilaian.pdf', compact('penilaian'))->setPaper('A4', 'landscape');
    return $pdf->download('data-penilaian.pdf');
}

public function downloadPerPenilaian($id)
{
    $penilaian = Penilaian::with(['guru', 'detailPenilaian.kriteria'])
        ->findOrFail($id);

    $pdf = Pdf::loadView('penilaian.single', compact('penilaian'))
        ->setPaper('A4', 'portrait');

    $namaFile = 'penilaian-' . Str::slug($penilaian->guru->nama) . '-' . $penilaian->periode . '.pdf';

    return $pdf->download($namaFile);
}

}
