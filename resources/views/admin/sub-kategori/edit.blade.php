@extends('layouts.app')

@section('content')
<h1>Edit Sub Kategori</h1>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Edit Sub Kategori</h4>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.sub-kategori.update', $subKategori->id_sub_kategori) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- NAMA SUB KATEGORI --}}
                    <div class="form-group mb-3">
                        <label>Nama Sub Kategori</label>
                        <input type="text"
                            name="nama_sub_kategori"
                            class="form-control @error('nama_sub_kategori') is-invalid @enderror"
                            value="{{ old('nama_sub_kategori', $subKategori->nama_sub_kategori) }}"
                            required>

                        @error('nama_sub_kategori')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- PILIH KATEGORI --}}
                    <div class="form-group mb-3">
                        <label>Kategori</label>
                        <select name="id_kategori"
                            class="form-control @error('id_kategori') is-invalid @enderror"
                            required>

                            <option value="">-- Pilih Kategori --</option>

                            @foreach($kategoris as $k)
                                <option value="{{ $k->id_kategori }}"
                                    {{ old('id_kategori', $subKategori->id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>

                        @error('id_kategori')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- BUTTON --}}
                    <div class="form-group">
                        <button class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.sub-kategori.index') }}"
                           class="btn btn-secondary">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection