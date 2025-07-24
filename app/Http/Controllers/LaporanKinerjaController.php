<?php

namespace App\Http\Controllers;

use App\Models\LaporanKinerja;
use App\Models\LaporanKinerjaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Guru;

class LaporanKinerjaController extends Controller
{
    // Tampilkan semua laporan guru (index)
public function index(Request $request)
{
    // Ambil data guru berdasarkan user yang login
    $guru = Guru::where('id_user', Auth::id())->first();

    // Cek jika tidak ditemukan guru, redirect atau abort
    if (!$guru) {
        return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
    }

    // Query laporan kinerja yang dimiliki guru
    $query = LaporanKinerja::with(['detail', 'guru.user'])
        ->where('id_guru', $guru->id_guru);

    // Filter berdasarkan semester jika ada
    if ($request->has('semester') && in_array($request->semester, ['ganjil', 'genap'])) {
        $query->where('semester', $request->semester);
    }

    // Ambil semua data laporan kinerja
    $laporan = $query->latest()->get();

    // Tampilkan ke view
    return view('laporan_kinerja.index', compact('laporan'));
}


    // Tampilkan form laporan kinerja
    public function create()
    {
        $guru = Guru::where('id_user', Auth::id())->first();

        return view('laporan_kinerja.create', [
            'guru' => $guru,
        ]);
    }

    // Simpan laporan kinerja + detail
    public function store(Request $request)
    {
        $guru = Guru::where('id_user', Auth::id())->first();

        $request->validate([
            'semester' => 'required|in:ganjil,genap',
            'kategori.*' => 'required|string',
            'indikator.*' => 'required|string',
            'keterangan.*' => 'nullable|string',
            'file_bukti.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        // Simpan laporan utama
        $laporan = LaporanKinerja::create([
            'id_guru' => $guru->id_guru,
            'semester' => $request->semester,
        ]);

        // Simpan detail laporan
        foreach ($request->kategori as $index => $kategori) {
            $filePath = null;

            if ($request->hasFile("file_bukti.$index")) {
                $file = $request->file("file_bukti.$index");
                $filePath = $file->store('bukti_laporan', 'public');
            }

            LaporanKinerjaDetail::create([
                'laporan_kinerja_id' => $laporan->id,
                'kategori' => $kategori,
                'indikator' => $request->indikator[$index],
                'keterangan' => $request->keterangan[$index],
                'file_bukti' => $filePath,
                'poin' => null,
            ]);
        }

        return redirect()->route('laporan_kinerja.index')->with('success', 'Laporan berhasil dikirim.');
    }

    // Tampilkan detail laporan
    public function show($id)
    {
        $laporan = LaporanKinerja::with('detail', 'guru')->findOrFail($id);
        return view('laporan_kinerja.show', compact('laporan'));
    }

    // Tampilkan form edit laporan
public function edit($id)
{
    $laporan = LaporanKinerja::with('detail')->findOrFail($id);
    return view('laporan_kinerja.edit', compact('laporan'));
}

public function update(Request $request, $id)
{
    $laporan = LaporanKinerja::findOrFail($id);

    $request->validate([
        'semester' => 'required|in:ganjil,genap',
        'kategori.*' => 'required|string',
        'indikator.*' => 'required|string',
        'keterangan.*' => 'nullable|string',
        'file_bukti.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
    ]);

    $laporan->update(['semester' => $request->semester]);

    foreach ($request->detail_ids as $i => $detail_id) {
        $detail = \App\Models\LaporanKinerjaDetail::findOrFail($detail_id);

        $filePath = $detail->file_bukti;
        if ($request->hasFile("file_bukti.$i")) {
            if ($filePath) Storage::disk('public')->delete($filePath);
            $filePath = $request->file("file_bukti.$i")->store('bukti_laporan', 'public');
        }

        $detail->update([
            'kategori' => $request->kategori[$i],
            'indikator' => $request->indikator[$i],
            'keterangan' => $request->keterangan[$i],
            'file_bukti' => $filePath,
        ]);
    }

    return redirect()->route('laporan_kinerja.index')->with('success', 'Laporan berhasil diperbarui.');
}

    // Hapus laporan
    public function destroy($id)
    {
        $laporan = LaporanKinerja::with('detail')->findOrFail($id);

        foreach ($laporan->detail as $detail) {
            if ($detail->file_bukti && Storage::disk('public')->exists($detail->file_bukti)) {
                Storage::disk('public')->delete($detail->file_bukti);
            }
        }

        $laporan->detail()->delete();
        $laporan->delete();

        return redirect()->route('laporan_kinerja.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
