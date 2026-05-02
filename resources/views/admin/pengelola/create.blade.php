@extends('layouts.app')

@section('content')
    <h1>Tambah Pengelola</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Tambah Pengelola</h4>

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.pengelola.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="nama_pengelola">Nama Pengelola</label>
                            <input type="text" class="form-control @error('nama_pengelola') is-invalid @enderror"
                                id="nama_pengelola" name="nama_pengelola" value="{{ old('nama_pengelola') }}" required>
                            @error('nama_pengelola')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_user">User Pengelola</label>
                            <select class="form-control @error('id_user') is-invalid @enderror" id="id_user" name="id_user"
                                required>
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

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.pengelola.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection