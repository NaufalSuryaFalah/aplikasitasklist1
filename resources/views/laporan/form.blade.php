<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="form-group">
        <label for="tgl_cetak">Tanggal Cetak</label>
        <input type="date" name="tgl_cetak" id="tgl_cetak" class="form-control @error('tgl_cetak') is-invalid @enderror" value="{{ old('tgl_cetak', $tgl_cetak ?? '') }}" />
        @error('tgl_cetak')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="periode_laporan">Periode Laporan</label>
        <input type="text" name="periode_laporan" id="periode_laporan" class="form-control @error('periode_laporan') is-invalid @enderror" value="{{ old('periode_laporan', $periode_laporan ?? '') }}" placeholder="Contoh: April 2026" />
        @error('periode_laporan')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="total_tugas">Total Tugas</label>
        <input type="number" name="total_tugas" id="total_tugas" class="form-control @error('total_tugas') is-invalid @enderror" value="{{ old('total_tugas', $total_tugas ?? '') }}" min="0" />
        @error('total_tugas')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="id_admin">Admin</label>
        <select name="id_admin" id="id_admin" class="form-control @error('id_admin') is-invalid @enderror">
            <option value="">Pilih Admin</option>
            @foreach($admins as $admin)
                <option value="{{ $admin->id }}" {{ old('id_admin') == $admin->id ? 'selected' : '' }}>{{ $admin->name }} ({{ $admin->username }})</option>
            @endforeach
        </select>
        @error('id_admin')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mt-3">
        <button type="submit" class="btn btn-success">{{ $buttonLabel }}</button>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</form>
