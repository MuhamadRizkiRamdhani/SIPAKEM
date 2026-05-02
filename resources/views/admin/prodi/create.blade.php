@extends('layouts.app')

@section('content')
    <h1>Tambah Program Studi</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Tambah Program Studi</h4>
                    
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.prodi.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="nama_prodi">Nama Program Studi</label>
                            <input type="text" class="form-control @error('nama_prodi') is-invalid @enderror" id="nama_prodi" name="nama_prodi" value="{{ old('nama_prodi') }}" required>
                            @error('nama_prodi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_fakultas">Fakultas</label>
                            <select class="form-control @error('id_fakultas') is-invalid @enderror" id="id_fakultas" name="id_fakultas" required>
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach($fakultas as $f)
                                    <option value="{{ $f->id_fakultas }}" {{ old('id_fakultas') == $f->id_fakultas ? 'selected' : '' }}>
                                        {{ $f->nama_fakultas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_fakultas')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.prodi.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
