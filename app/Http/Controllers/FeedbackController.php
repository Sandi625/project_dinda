<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with('penilaian')->latest()->get();
        return view('feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        $penilaians = Penilaian::all();
        return view('feedback.create', compact('penilaians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_penilaian'   => 'required|exists:penilaian,id_penilaian',
            'isi'            => 'required|string',
            // 'feedback_guru'  => 'nullable|string', // ✅ tambahkan validasi
            'tanggal'        => 'required|date',
        ]);

        Feedback::create([
            'id_penilaian'  => $request->id_penilaian,
            'isi'           => $request->isi,
            // 'feedback_guru' => $request->feedback_guru,
            'tanggal'       => $request->tanggal,
        ]);

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);
        $penilaians = Penilaian::all();
        return view('feedback.edit', compact('feedback', 'penilaians'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_penilaian'   => 'required|exists:penilaian,id_penilaian',
            'isi'            => 'required|string',
            // 'feedback_guru'  => 'nullable|string', // ✅ tambahkan validasi
            'tanggal'        => 'required|date',
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->update([
            'id_penilaian'  => $request->id_penilaian,
            'isi'           => $request->isi,
            // 'feedback_guru' => $request->feedback_guru,
            'tanggal'       => $request->tanggal,
        ]);

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil dihapus.');
    }
}
