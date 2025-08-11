<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with(['user'])->get();
        return view('guru.index', compact('guru'));
    }

    public function show($id)
    {
        $guru = Guru::with(['user'])->findOrFail($id);
        return view('guru.show', compact('guru'));
    }

    public function create()
    {
        $users = User::all();
        return view('guru.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'nip' => 'nullable|string|max:20',
            'nama' => 'required|string|max:100',
            'alamat' => 'nullable|string',
        ]);

        Guru::create([
            'id_user' => $request->id_user,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        $users = User::all();
        return view('guru.edit', compact('guru', 'users'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'nip' => 'nullable|string|max:20',
            'nama' => 'required|string|max:100',
            'alamat' => 'nullable|string',
        ]);

        $guru->update([
            'id_user' => $request->id_user,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
