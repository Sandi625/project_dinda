<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Guru;
use App\Models\DetailPenilaian;
use App\Models\KriteriaPenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HalamanKepsekController extends Controller
{
    public function index()
    {
        $penilaian = Penilaian::with('guru')->get();
        return view('kepsek.index', compact('penilaian'));
    }

    public function create()
    {
        $guru = Guru::all();
        $kriteria = KriteriaPenilaian::all();
        return view('kepsek.create', compact('guru', 'kriteria'));
    }
    public function show($id)
{
    // Misal tampilkan detail penilaian atau redirect ke index
    $penilaian = Penilaian::with('detailPenilaian')->findOrFail($id);
    return view('kepsek.show', compact('penilaian'));
}


    public function store(Request $request)
    {
        $request->validate([
            'id_guru' => 'required|exists:guru,id_guru',
            'periode' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            $penilaian = Penilaian::create([
                'id_guru' => $request->id_guru,
                'periode' => $request->periode,
                'tanggal' => $request->tanggal,
            ]);

            foreach ($request->nilai as $id_kriteria => $nilai) {
                DetailPenilaian::create([
                    'id_penilaian' => $penilaian->id_penilaian,
                    'id_kriteria' => $id_kriteria,
                    'nilai' => $nilai,
                ]);
            }

            DB::commit();
            return redirect()->route('kepsek.index')->with('success', 'Penilaian berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan penilaian.')->withInput();
        }
    }

    public function edit($id)
    {
        $penilaian = Penilaian::with('detailPenilaian')->findOrFail($id);
        $guru = Guru::all();
        $kriteria = KriteriaPenilaian::all();
        return view('kepsek.edit', compact('penilaian', 'guru', 'kriteria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'periode' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        $penilaian = Penilaian::findOrFail($id);

        DB::beginTransaction();
        try {
            $penilaian->update([
                'periode' => $request->periode,
                'tanggal' => $request->tanggal,
            ]);

            foreach ($request->nilai as $id_kriteria => $nilai) {
                DetailPenilaian::updateOrCreate(
                    [
                        'id_penilaian' => $penilaian->id_penilaian,
                        'id_kriteria' => $id_kriteria
                    ],
                    [
                        'nilai' => $nilai
                    ]
                );
            }

            DB::commit();
            return redirect()->route('kepsek.index')->with('success', 'Penilaian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui penilaian.')->withInput();
        }
    }

    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->detailPenilaian()->delete();
        $penilaian->delete();

        return redirect()->route('kepsek.index')->with('success', 'Penilaian berhasil dihapus.');
    }
}
