@extends('layouts.app')

@section('title', 'Edit Laporan Kinerja')

@section('content')
<div class="container mt-4">
    <h3>Edit Laporan Kinerja</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('laporan_kinerja.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <select name="semester" id="semester" class="form-select" required>
                <option value="">-- Pilih Semester --</option>
                <option value="ganjil" {{ $laporan->semester === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="genap" {{ $laporan->semester === 'genap' ? 'selected' : '' }}>Genap</option>
            </select>
        </div>

        <hr>
        <h5>Detail Laporan</h5>
        <div id="laporan-detail-wrapper">
            @foreach ($laporan->detail as $index => $detail)
                <div class="laporan-detail border rounded p-3 mb-3">
                    <input type="hidden" name="detail_ids[]" value="{{ $detail->id }}">

                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Kategori</label>
                            <select name="kategori[]" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach (['Perencanaan', 'Pelaksanaan', 'Penilaian', 'Komunikasi', 'Profesional'] as $kategori)
                                    <option value="{{ $kategori }}" {{ $detail->kategori == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Indikator</label>
                            <input type="text" name="indikator[]" class="form-control" value="{{ old('indikator.' . $index, $detail->indikator) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan[]" class="form-control" value="{{ old('keterangan.' . $index, $detail->keterangan) }}">
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">File Bukti (Biarkan kosong jika tidak ingin mengubah)</label>
                        <input type="file" name="file_bukti[]" class="form-control">
                        @if ($detail->file_bukti)
                            <small>File saat ini: <a href="{{ asset('storage/' . $detail->file_bukti) }}" target="_blank">Lihat</a></small>
                        @endif
                    </div>

                    {{-- <button type="button" class="btn btn-danger mt-3 btn-remove">Hapus</button> --}}
                </div>
            @endforeach
        </div>

        {{-- <button type="button" id="add-detail" class="btn btn-secondary mb-4">+ Tambah Indikator</button> --}}

        <div>
            <button type="submit" class="btn btn-primary">Update Laporan</button>
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

        // Bersihkan nilai input dan select
        clone.querySelectorAll('input, select').forEach(el => {
            if (el.type === 'file') return;
            el.value = '';
        });

        // Hapus preview file jika ada
        const fileLink = clone.querySelector('small');
        if (fileLink) fileLink.remove();

        // Hapus hidden input detail_ids
        const hidden = clone.querySelector('input[name="detail_ids[]"]');
        if (hidden) hidden.remove();

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
