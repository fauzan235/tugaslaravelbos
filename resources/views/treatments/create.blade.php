@extends('layouts.app')

@section('title', 'Catat Kunjungan')
@section('breadcrumb', 'Kunjungan → Catat Baru')

@section('content')
    <div class="card" style="max-width: 800px;">
        <div class="card-header">
            <h3>🩺 Catat Kunjungan Baru</h3>
        </div>

        <form action="{{ route('treatments.store') }}" method="POST" id="treatmentForm">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="student_id">Pilih Siswa</label>
                    <select name="student_id" id="student_id" class="form-control" required>
                        <option value="">— Pilih Siswa —</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->nama }} — {{ $s->kelas->nama_kelas }} ({{ $s->nis }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_kunjungan">Tanggal Kunjungan</label>
                    <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" class="form-control"
                           value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" required>
                    @error('tanggal_kunjungan')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="keluhan">Keluhan</label>
                <textarea name="keluhan" id="keluhan" class="form-control" rows="3"
                          placeholder="Tuliskan keluhan yang disampaikan siswa..." required>{{ old('keluhan') }}</textarea>
                @error('keluhan')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="diagnosa">Diagnosa Awal (Opsional)</label>
                <textarea name="diagnosa" id="diagnosa" class="form-control" rows="2"
                          placeholder="Tuliskan diagnosa awal jika ada...">{{ old('diagnosa') }}</textarea>
                @error('diagnosa')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Obat yang Diberikan --}}
            <div class="form-group">
                <label>💊 Obat yang Diberikan</label>
                <div id="medicine-list" style="margin-top: 8px;">
                    {{-- Dynamic rows akan ditambahkan di sini --}}
                </div>
                <button type="button" class="btn btn-success btn-sm" onclick="addMedicineRow()" style="margin-top: 10px;">
                    + Tambah Obat
                </button>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">💾 Simpan Kunjungan</button>
                <a href="{{ route('treatments.index') }}" class="btn btn-secondary">← Kembali</a>
            </div>
        </form>
    </div>

    @push('styles')
    <style>
        .medicine-row {
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 10px;
            align-items: end;
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            margin-bottom: 8px;
            animation: slideDown 0.2s ease;
        }
        .medicine-row select,
        .medicine-row input {
            padding: 8px 12px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
        }
        .medicine-row select:focus,
        .medicine-row input:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn-remove {
            padding: 8px 14px;
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        .btn-remove:hover { background: #e94560; color: #fff; }
    </style>
    @endpush

    @push('scripts')
    <script>
        const medicines = @json($medicines);
        let rowCounter = 0;

        function addMedicineRow() {
            rowCounter++;
            const list = document.getElementById('medicine-list');
            const row = document.createElement('div');
            row.className = 'medicine-row';
            row.id = 'med-row-' + rowCounter;

            let options = '<option value="">— Pilih Obat —</option>';
            medicines.forEach(m => {
                options += `<option value="${m.id}">${m.nama_obat} (stok: ${m.stok} ${m.satuan})</option>`;
            });

            row.innerHTML = `
                <div>
                    <label style="font-size:0.75rem;font-weight:600;color:#64748b;margin-bottom:4px;display:block;">Obat</label>
                    <select name="medicines[${rowCounter}][id]" style="width:100%;" required>
                        ${options}
                    </select>
                </div>
                <div>
                    <label style="font-size:0.75rem;font-weight:600;color:#64748b;margin-bottom:4px;display:block;">Jumlah</label>
                    <input type="number" name="medicines[${rowCounter}][jumlah]" value="1" min="1" style="width:100%;" required>
                </div>
                <div>
                    <label style="font-size:0.75rem;visibility:hidden;margin-bottom:4px;display:block;">x</label>
                    <button type="button" class="btn-remove" onclick="removeMedicineRow(${rowCounter})">✕</button>
                </div>
            `;

            list.appendChild(row);
        }

        function removeMedicineRow(id) {
            const row = document.getElementById('med-row-' + id);
            if (row) row.remove();
        }
    </script>
    @endpush
@endsection
