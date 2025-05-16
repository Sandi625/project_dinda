<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\DetailPenilaian;
use App\Models\Guru;
use App\Models\KriteriaPenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    // Menampilkan semua penilaian
  public function index()
{
    $penilaian = Penilaian::with(['guru', 'detailPenilaian.kriteria'])->get();
    return view('penilaian.index', compact('penilaian'));
}



    // Form tambah penilaian + detail
    public function create()
    {
        $gurus = Guru::all();
        $kriterias = KriteriaPenilaian::all();
        return view('penilaian.create', compact('gurus', 'kriterias'));
    }

    // Simpan penilaian + detail
    public function store(Request $request)
    {
        $request->validate([
            'id_guru' => 'required|exists:guru,id_guru',
            'periode' => 'required',
            'tanggal' => 'required|date',
            'detail.*.id_kriteria' => 'required|exists:kriteria_penilaian,id_kriteria',
            'detail.*.nilai' => 'required|numeric',
        ]);

        DB::transaction(function() use ($request) {
            $penilaian = Penilaian::create([
                'id_guru' => $request->id_guru,
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
        return view('penilaian.edit', compact('penilaian', 'gurus', 'kriterias'));
    }

    // Update penilaian + detail
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_guru' => 'required|exists:guru,id_guru',
            'periode' => 'required',
            'tanggal' => 'required|date',
            'detail.*.id_kriteria' => 'required|exists:kriteria_penilaian,id_kriteria',
            'detail.*.nilai' => 'required|numeric',
        ]);

        DB::transaction(function() use ($request, $id) {
            $penilaian = Penilaian::findOrFail($id);
            $penilaian->update([
                'id_guru' => $request->id_guru,
                'periode' => $request->periode,
                'tanggal' => $request->tanggal,
            ]);

            // Hapus semua detail sebelumnya
            DetailPenilaian::where('id_penilaian', $penilaian->id_penilaian)->delete();

            // Tambah ulang
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
}
