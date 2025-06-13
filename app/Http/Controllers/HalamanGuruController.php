<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;


class HalamanGuruController extends Controller
{
    // Tampilkan daftar penilaian dengan relasi
    public function index()
    {
        $penilaians = Penilaian::with(['guru', 'detailPenilaian.kriteria', 'feedback'])
            ->latest()
            ->get();

        return view('halamanguru.index', compact('penilaians'));
    }

    public function show($id)
{
    // Ambil data guru berdasarkan ID
    $guru = Penilaian::findOrFail($id);

    // Tampilkan ke view
    return view('guru.show', compact('guru'));
}


    // Form Tambah Feedback
    public function create(Request $request)
    {
        $id_penilaian = $request->id_penilaian;

        $penilaian = Penilaian::with('guru')
            ->whereDoesntHave('feedback') // hanya jika belum ada feedback
            ->findOrFail($id_penilaian);

        return view('halamanguru.create', compact('penilaian'));
    }

    // Simpan Feedback Baru
    public function store(Request $request)
    {
        $request->validate([
            'id_penilaian' => 'required|exists:penilaian,id_penilaian',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // Cegah duplikat feedback
        if (Feedback::where('id_penilaian', $request->id_penilaian)->exists()) {
            return redirect()->route('halamanguru.index')
                ->with('error', 'Feedback untuk penilaian ini sudah ada.');
        }

        Feedback::create($request->only(['id_penilaian', 'isi', 'tanggal']));

        return redirect()->route('halamanguru.index')
            ->with('success', 'Feedback berhasil ditambahkan.');
    }

    // Form Edit Feedback (gunakan id_penilaian)
public function edit($id)
{
    $feedback = Feedback::findOrFail($id);
    $penilaian = $feedback->penilaian; // Pastikan relasi feedback ke penilaian ada
    return view('halamanguru.edit', compact('penilaian', 'feedback'));
}


    // Update Feedback
    public function update(Request $request, $id)
    {
        $request->validate([
            'isi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->update([
            'isi' => $request->isi,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('halamanguru.index')
            ->with('success', 'Feedback berhasil diperbarui.');
    }

    // Hapus Feedback
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('halamanguru.index')
            ->with('success', 'Feedback berhasil dihapus.');
    }

    public function dashboard()
{
   $guru = Auth::user();


    // Total penilaian yang dilakukan guru ini
    $totalPenilaian = Penilaian::where('guru_id', $guru->id)->count();

    // Total feedback yang sudah diberikan untuk penilaian guru ini
    $totalFeedback = Feedback::whereHas('penilaian', function($q) use ($guru) {
        $q->where('guru_id', $guru->id);
    })->count();

    // Ambil beberapa penilaian terakhir untuk ditampilkan di dashboard
    $penilaianTerbaru = Penilaian::with('detailPenilaian.kriteria', 'feedback')
        ->where('guru_id', $guru->id)
        ->latest()
        ->take(5)
        ->get();

    return view('halamanguru.dashboard', compact('guru', 'totalPenilaian', 'totalFeedback', 'penilaianTerbaru'));
}

}
