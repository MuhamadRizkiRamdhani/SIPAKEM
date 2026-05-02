@extends('layouts.app')

@section('content')
    <h1>Tambah Kategori</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Tambah Kategori</h4>

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.kategori.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
                            @error('nama_kategori')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection