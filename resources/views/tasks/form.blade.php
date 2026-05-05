@php
    $task = $taskOrder ?? null;
    $isAdmin = auth()->user()->role === 'admin';
    $canSetFinish = ! $isAdmin && $task;
    $selectedAdminId = old('id_admin', $task->id_admin ?? ($currentAdminId ?? null));
@endphp

<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="form-group">
        <label for="deskripsi_tugas">Deskripsi Tugas</label>
        <textarea name="deskripsi_tugas" id="deskripsi_tugas" class="form-control @error('deskripsi_tugas') is-invalid @enderror" rows="4" {{ $isAdmin ? '' : 'readonly' }}>{{ old('deskripsi_tugas', $task->deskripsi_tugas ?? '') }}</textarea>
        @error('deskripsi_tugas')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                    @foreach(['pending' => 'Pending', 'proses' => 'Proses', 'selesai' => 'Selesai'] as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $task->status ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

    </div>

    <div class="form-group">
        <label for="catatan_hasil">Catatan Hasil</label>
        <textarea name="catatan_hasil" id="catatan_hasil" class="form-control @error('catatan_hasil') is-invalid @enderror" rows="3">{{ old('catatan_hasil', $task->catatan_hasil ?? '') }}</textarea>
        @error('catatan_hasil')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    @if($isAdmin)
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_admin">Admin</label>
                    <select name="id_admin" id="id_admin" class="form-control @error('id_admin') is-invalid @enderror">
                        <option value="">Pilih Admin</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ $selectedAdminId == $admin->id ? 'selected' : '' }}>{{ $admin->name }} ({{ $admin->username }})</option>
                        @endforeach
                    </select>
                    @error('id_admin')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_teknisi">Teknisi</label>
                    <select name="id_teknisi" id="id_teknisi" class="form-control @error('id_teknisi') is-invalid @enderror">
                        <option value="">Tidak ada teknisi</option>
                        @foreach($teknicians as $teknisi)
                            <option value="{{ $teknisi->id }}" {{ old('id_teknisi', $task->id_teknisi ?? '') == $teknisi->id ? 'selected' : '' }}>{{ $teknisi->name }} ({{ $teknisi->username }})</option>
                        @endforeach
                    </select>
                    @error('id_teknisi')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    @endif

    <div class="form-group mt-3">
        <button type="submit" class="btn btn-success">{{ $buttonLabel }}</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</form>
