<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Models\DetailPenilaian;
use App\Models\KriteriaPenilaian;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
    $users = User::all(); // ✅ ambil user untuk observer

    return view('kepsek.create', compact('guru', 'kriteria', 'users'));
}

public function show($id)
{
    $penilaian = Penilaian::with('detailPenilaian')->findOrFail($id);
    return view('kepsek.show', compact('penilaian'));
}

public function store(Request $request)
{
    $request->validate([
        'id_guru' => 'required|exists:guru,id_guru',
        'id_user' => 'required|exists:users,id_user', // ✅ validasi user
        'periode' => 'required|string|max:50',
        'tanggal' => 'required|date',
        'nilai' => 'required|array',
        'nilai.*' => 'required|numeric|min:0|max:100',
    ]);

    DB::beginTransaction();
    try {
        $penilaian = Penilaian::create([
            'id_guru' => $request->id_guru,
            'id_user' => $request->id_user, // ✅ simpan observer
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
    $users = User::all(); // ✅ tambahkan untuk form edit

    return view('kepsek.edit', compact('penilaian', 'guru', 'kriteria', 'users'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user', // ✅ validasi user
        'periode' => 'required|string|max:50',
        'tanggal' => 'required|date',
        'nilai' => 'required|array',
        'nilai.*' => 'required|numeric|min:0|max:100',
    ]);

    $penilaian = Penilaian::findOrFail($id);

    DB::beginTransaction();
    try {
        $penilaian->update([
            'id_user' => $request->id_user, // ✅ update observer
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
