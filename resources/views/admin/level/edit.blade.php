@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Edit Level</h4>

                    {{-- ERROR --}}
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.level.update', $level) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="nama_level">Nama Level</label>
                            <input type="text" class="form-control @error('nama_level') is-invalid @enderror"
                                id="nama_level" name="nama_level" value="{{ old('nama_level', $level->nama_level) }}"
                                required>

                            @error('nama_level')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.level.index') }}" class="btn btn-secondary">Batal</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            javascriptdocument.querySelector('form').addEventListener('submit', function (e) {
                e.preventDefault();
                const form = this;
                const btn = document.querySelector('button[type="submit"]');

                Swal.fire({
                    title: 'Konfirmasi Update',
                    text: 'Apakah Anda yakin ingin menyimpan perubahan data level ini?',
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