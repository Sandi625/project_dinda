<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Models\LaporanKinerja;
use App\Http\Controllers\Controller;
use App\Models\LaporanKinerjaDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanKinerjaController extends Controller
{
    // Tampilkan semua laporan guru (index)
public function index(Request $request)
{
    // Ambil data guru berdasarkan user yang login
    $guru = Guru::where('id_user', Auth::id())->first();

    if (!$guru) {
        return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
    }

    // Query laporan kinerja yang dimiliki guru
    $query = LaporanKinerja::with(['detail', 'guru.user', 'semester']) // pastikan relasi semester sudah dibuat
        ->where('id_guru', $guru->id_guru);

    // Filter berdasarkan id_semester jika ada
    if ($request->filled('id_semester')) {
        $query->where('id_semester', $request->id_semester);
    }

    // Ambil semua data semester untuk dropdown filter
    $semesters = Semester::all();

    // Ambil data laporan yang difilter
    $laporan = $query->latest()->get();

    return view('laporan_kinerja.index', compact('laporan', 'semesters'));
}



    // Tampilkan form laporan kinerja
public function create()
{
    $guru = Guru::where('id_user', Auth::id())->first();
    $semesters = Semester::all(); // Ambil semua semester dari tabel

    return view('laporan_kinerja.create', [
        'guru' => $guru,
        'semesters' => $semesters,
    ]);
}


    // Simpan laporan kinerja + detail
   public function store(Request $request)
{
    $guru = Guru::where('id_user', Auth::id())->first();

    $request->validate([
        'id_semester' => 'required|exists:semester,id',
        'kategori.*' => 'required|string',
        'indikator.*' => 'required|string',
        'keterangan.*' => 'nullable|string',
        'file_bukti.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
    ]);

    // Simpan laporan utama
    $laporan = LaporanKinerja::create([
        'id_guru' => $guru->id_guru,
        'id_semester' => $request->id_semester, // simpan id_semester
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
    $semesters = Semester::all(); // ambil semua semester

    return view('laporan_kinerja.edit', compact('laporan', 'semesters'));
}


public function update(Request $request, $id)
{
    $laporan = LaporanKinerja::findOrFail($id);

    $request->validate([
        'id_semester' => 'required|exists:semester,id',
        'semester' => 'required|in:ganjil,genap',
        'kategori.*' => 'required|string',
        'indikator.*' => 'required|string',
        'keterangan.*' => 'nullable|string',
        'file_bukti.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
    ]);

    $laporan->update([
        'id_semester' => $request->id_semester,
        'semester' => $request->semester,
    ]);

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
