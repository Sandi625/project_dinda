<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Feedback;
use App\Models\Semester;
use App\Models\Penilaian;
use App\Models\NilaiSiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LaporanKinerja;
use App\Models\DetailPenilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KriteriaPenilaian;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\LaporanKinerjaDetail;

class HalamanKepsekController extends Controller
{
public function index(Request $request)
{
    $query = Penilaian::query()
        ->select(
            'penilaian.*',
            'semester.semester as semester_nama',
            'semester.tahun as semester_tahun'
        )
        ->leftJoin('semester', 'penilaian.id_semester', '=', 'semester.id')
        ->with([
            'guru',
            'user',
            'kelas',
            'mapel',
            'detailPenilaian.kriteria'
        ]);

    // Filter berdasarkan id_semester jika dipilih
    if ($request->filled('id_semester')) {
        $query->where('penilaian.id_semester', $request->id_semester);
    }

    // Urutkan berdasarkan waktu pembuatan (data baru di bawah)
    $penilaian = $query->orderBy('penilaian.created_at', 'asc')->get();

    // Ambil daftar semester untuk filter
    $daftarSemester = \App\Models\Semester::orderByDesc('tahun')
        ->orderBy('semester')
        ->get();

    return view('kepsek.index', compact('penilaian', 'daftarSemester'));
}




public function create()
{
    $kriterias = KriteriaPenilaian::all();
    $users = User::all();
    $semesters = Semester::all();
    $gurus = Guru::all();
    $mapels = Mapel::all();
    $kelas = Kelas::all();

    return view('kepsek.create', compact(
        'kriterias',
        'users',
        'kelas',
        'mapels',
        'semesters',
        'gurus'
    ));
}








public function store(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:users,id_user',
        'id_guru' => 'required|exists:guru,id_guru',
        'id_mapel' => 'required|exists:mapel,id',
        'id_kelas' => 'required|exists:kelas,id',
        'id_semester' => 'required|exists:semester,id',
        'tanggal' => 'required|date',
        'detail.*.id_kriteria' => 'required|exists:kriteria_penilaian,id_kriteria',
        'detail.*.nilai' => 'required|numeric|min:0|max:100',
    ]);

    DB::transaction(function () use ($request) {
        $penilaian = Penilaian::create([
            'id_user'     => $request->id_user,
            'id_guru'     => $request->id_guru,
            'id_mapel'    => $request->id_mapel,
            'id_kelas'    => $request->id_kelas,
            'id_semester' => $request->id_semester,
            'tanggal'     => $request->tanggal,
        ]);

        foreach ($request->detail as $d) {
            DetailPenilaian::create([
                'id_penilaian' => $penilaian->id_penilaian,
                'id_kriteria'  => $d['id_kriteria'],
                'nilai'        => $d['nilai'],
            ]);
        }
    });

    return redirect()->route('kepsek.index')->with('success', 'Penilaian berhasil ditambahkan.');
}


    public function getMapelKelasByGuru($id_guru)
{
    $guru = Guru::with(['mapel', 'kelas'])->findOrFail($id_guru);

    return response()->json([
        'mapel' => [
            'id' => $guru->mapel->id ?? null,
            'nama_mapel' => $guru->mapel->nama_mapel ?? null,
        ],
        'kelas' => [
            'id' => $guru->kelas->id ?? null,
            'nama_kelas' => $guru->kelas->nama_kelas ?? null,
        ]
    ]);
}



    public function edit($id)
    {
        $penilaian = Penilaian::with('detailPenilaian')->findOrFail($id);
        $guru = Guru::all();
        $kriteria = KriteriaPenilaian::all();
        $users = User::all();
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        $semesters = \App\Models\Semester::all();

        return view('kepsek.edit', compact(
            'penilaian',
            'guru',
            'kriteria',
            'users',
            'kelas',
            'mapel',
            'semesters'
        ));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_kelas' => 'required|exists:kelas,id',
            'id_mapel' => 'required|exists:mapel,id',
            'id_semester' => 'required|exists:semester,id',
            'tanggal' => 'required|date',
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        $penilaian = Penilaian::findOrFail($id);

        DB::beginTransaction();
        try {
            $penilaian->update([
                'id_user' => $request->id_user,
                'id_kelas' => $request->id_kelas,
                'id_mapel' => $request->id_mapel,
                'id_semester' => $request->id_semester,
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



public function downloadUntukKepalaSekolah($id)
{
    $penilaian = Penilaian::with([
        // 'guru.kelas',               // relasi kelas guru
        'detailPenilaian.kriteria' // memuat detail penilaian
    ])->findOrFail($id);

    $pdf = Pdf::loadView('kepsek.single', compact('penilaian'))
        ->setPaper('A4', 'portrait');

    $namaFile = 'penilaian-' . Str::slug($penilaian->guru->nama) . '-' . $penilaian->periode . '.pdf';

    return $pdf->stream($namaFile);
}



public function nilaiSiswa()
{
    $nilai = \App\Models\NilaiSiswa::all()
        ->groupBy('nisn'); // group by nisn atau nama_siswa sesuai kebutuhan

    $data = $nilai->map(function ($items) {
        return [
            'nama_siswa' => $items->first()->nama_siswa,
            'kelas' => $items->first()->kelas,
            'rata_rata' => round($items->avg('nilai'), 2),
            'nilai_detail' => $items,
        ];
    });

    return view('kepsek.nilai_siswa', compact('data'));
}

public function getFeedback()
{
    $feedbacks = \App\Models\Feedback::with([
        'penilaian.user', // ganti dari 'guru' ke 'user'
        'penilaian.kelas',
        'penilaian.mapel',
        'penilaian.detailPenilaian.kriteria' // untuk nilai per kriteria
    ])->latest()->get();

    return view('kepsek.feedback.index', compact('feedbacks'));
}



public function laporanKinerjaKepsek(Request $request)
{
    // Ambil semua data LaporanKinerja dengan relasi guru, user, detail, dan semester
    $query = LaporanKinerja::with(['guru.user', 'detail', 'semester']);

    // Filter berdasarkan id_semester jika ada permintaan filter
    if ($request->filled('id_semester')) {
        $query->where('id_semester', $request->id_semester);
    }

    $laporanKinerja = $query->get();

    // Ambil semua semester unik yang pernah digunakan dalam laporan_kinerja
    $daftarSemester = Semester::whereIn('id', function ($q) {
        $q->select('id_semester')->from('laporan_kinerja')->whereNotNull('id_semester');
    })->get();

    return view('kepsek.laporan_kinerja.index', compact('laporanKinerja', 'daftarSemester'));
}



 public function show($id)
    {
        $penilaian = Penilaian::with([
            'guru',
            'user',
            'kelas',
            'mapel',
            'semester',
            'detailPenilaian.kriteria'
        ])->findOrFail($id);

        return view('kepsek.show', compact('penilaian'));
    }


}
