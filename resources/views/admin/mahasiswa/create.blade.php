@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Tambah Mahasiswa</h4>
                    
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="nim">NIM</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>
                            @error('nim')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama_mhs">Nama Mahasiswa</label>
                            <input type="text" class="form-control @error('nama_mhs') is-invalid @enderror" id="nama_mhs" name="nama_mhs" value="{{ old('nama_mhs') }}" required>
                            @error('nama_mhs')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_user">Akun Mahasiswa</label>
                            <select class="form-control @error('id_user') is-invalid @enderror" id="id_user" name="id_user" required>
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                                        {{ $user->username }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_user')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_prodi">Program Studi</label>
                            <select class="form-control @error('id_prodi') is-invalid @enderror" id="id_prodi" name="id_prodi" required>
                                <option value="">-- Pilih Prodi --</option>
                                @foreach($prodis as $prodi)
                                    <option value="{{ $prodi->id_prodi }}" {{ old('id_prodi') == $prodi->id_prodi ? 'selected' : '' }}>
                                        {{ $prodi->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_prodi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="poin_kredit">Poin Kredit</label>
                            <input type="number" class="form-control @error('poin_kredit') is-invalid @enderror" id="poin_kredit" name="poin_kredit" value="{{ old('poin_kredit', 0) }}" min="0" required>
                            @error('poin_kredit')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tahun_angkatan">Tahun Angkatan</label>
                            <input type="text" class="form-control @error('tahun_angkatan') is-invalid @enderror" id="tahun_angkatan" name="tahun_angkatan" value="{{ old('tahun_angkatan') }}" placeholder="YYYY" required>
                            @error('tahun_angkatan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                        <label>Beasiswa</label>
                            <div style="display: flex; gap: 24px; margin-top: 8px;">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: normal; margin: 0;">
                                    <input type="radio" name="beasiswa" id="beasiswa_tidak" value="0"
                                        {{ old('beasiswa', '0') == '0' ? 'checked' : '' }}>
                                    Bukan Penerima Beasiswa
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: normal; margin: 0;">
                                    <input type="radio" name="beasiswa" id="beasiswa_ya" value="1"
                                        {{ old('beasiswa') == '1' ? 'checked' : '' }}>
                                    Penerima Beasiswa
                                </label>
                            </div>
                            @error('beasiswa')
                                <span class="text-danger d-block mt-1" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
          document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = this;
        const btn = document.querySelector('button[type="submit"]');

        Swal.fire({
            title: 'Konfirmasi Simpan',
            text: 'Apakah Anda yakin ingin menyimpan data mahasiswa ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.disabled = true;
                btn.textContent = 'Menyimpan...';
                form.submit();
            }
        });
    });
    </script>
    @endpush

@endsection