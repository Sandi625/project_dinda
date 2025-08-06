@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Laporan Kinerja</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('laporan_kinerja.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

      <div class="mb-3">
    <label for="id_semester" class="form-label">Semester</label>
    <select name="id_semester" id="id_semester" class="form-select" required>
        <option value="">-- Pilih Semester --</option>
        @foreach ($semesters as $semester)
            <option value="{{ $semester->id }}">
                {{ ucfirst($semester->semester) }} - {{ $semester->tahun }}
            </option>
        @endforeach
    </select>
</div>


        <hr>
        <h5>Detail Laporan</h5>
        <div id="laporan-detail-wrapper">
            <div class="laporan-detail border rounded p-3 mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Kategori</label>
                        <select name="kategori[]" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Perencanaan">Perencanaan</option>
                            <option value="Pelaksanaan">Pelaksanaan</option>
                            <option value="Penilaian">Penilaian</option>
                            <option value="Komunikasi">Komunikasi</option>
                            <option value="Profesional">Profesional</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Indikator</label>
                        <input type="text" name="indikator[]" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan[]" class="form-control">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label">File Bukti (PDF/IMG/DOC)</label>
                    <input type="file" name="file_bukti[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                </div>
                {{-- <button type="button" class="btn btn-danger mt-3 btn-remove">Hapus</button> --}}
            </div>
        </div>

        {{-- <button type="button" id="add-detail" class="btn btn-secondary mb-4">+ Tambah Indikator</button> --}}

        <div>
            <button type="submit" class="btn btn-primary">Simpan Laporan</button>
            <a href="{{ route('laporan_kinerja.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('add-detail').addEventListener('click', function () {
        const wrapper = document.getElementById('laporan-detail-wrapper');
        const original = wrapper.querySelector('.laporan-detail');
        const clone = original.cloneNode(true);

        // Kosongkan input
        clone.querySelectorAll('input, select').forEach(el => el.value = '');

        wrapper.appendChild(clone);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove')) {
            const detail = e.target.closest('.laporan-detail');
            const wrapper = document.getElementById('laporan-detail-wrapper');
            if (wrapper.querySelectorAll('.laporan-detail').length > 1) {
                detail.remove();
            } else {
                alert('Minimal 1 indikator harus diisi.');
            }
        }
    });
</script>
@endpush
