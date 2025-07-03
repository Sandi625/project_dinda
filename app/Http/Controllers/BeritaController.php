<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Tampilkan semua berita.
     */
    public function index()
    {
        $data = Berita::orderBy('created_at', 'desc')->paginate(10);
        return view('berita.index', compact('data'));
    }

    /**
     * Form tambah berita.
     */
    public function create()
    {
        return view('berita.create');
    }

    /**
     * Simpan berita baru.
     */
public function store(Request $request)
{
    $request->merge([
        'status' => $request->has('status') ? 1 : 0,
    ]);

    $validated = $request->validate([
        'judul' => 'required|string|max:255',
        'ringkasan' => 'required|string',
        'isi_berita' => 'required',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'status' => 'required|in:0,1',
    ]);

    $validated['gambar'] = $this->handleUploadGambar($request);
    $validated['created_by'] = Auth::id();
    $validated['updated_by'] = Auth::id();

    Berita::create($validated);

    return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
}



    /**
     * Tampilkan detail berita.
     */
    public function show(Berita $berita)
    {
        return view('berita.show', compact('berita'));
    }

    /**
     * Form edit berita.
     */
 public function edit(Berita $berita)
{
    return view('berita.edit', compact('berita'));
}


    /**
     * Simpan perubahan berita.
     */
public function update(Request $request, Berita $berita)
{
    $request->merge([
        'status' => $request->has('status') ? 1 : 0,
    ]);

    $validated = $request->validate([
        'judul' => 'required|string|max:255',
        'ringkasan' => 'required|string',
        'isi_berita' => 'required',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'status' => 'required|in:0,1',
    ]);

    $validated['gambar'] = $this->handleUploadGambar($request, $berita->gambar);
    $validated['updated_by'] = Auth::id();

    $berita->update($validated);

    return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui.');
}


    /**
     * Hapus berita.
     */
    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }



    private function handleUploadGambar(Request $request, ?string $gambarLama = null): ?string
{
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($gambarLama) {
            \Storage::disk('public')->delete($gambarLama);
        }

        return $request->file('gambar')->store('berita', 'public');
    }

    return $gambarLama; // Tidak ada gambar baru, kembalikan gambar lama
}


public function userShow(Berita $berita)
{
    if ($berita->status != 1) {
        abort(404); // Jangan tampilkan jika nonaktif
    }

    return view('berita.user', compact('berita'));
}


}
