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
            'id_penilaian' => 'required|exists:penilaian,id_penilaian',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        Feedback::create($request->all());

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
            'id_penilaian' => 'required|exists:penilaian,id_penilaian',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->update($request->all());

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil dihapus.');
    }
}
