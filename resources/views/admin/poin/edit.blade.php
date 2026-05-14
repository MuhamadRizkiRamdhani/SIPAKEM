@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Edit Point Rules</h4>

                {{-- ERROR --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.poin.update', $pointRules->id_rules) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- KATEGORI --}}
                    <div class="form-group mb-3">
                        <label>Kategori</label>
                        <select name="id_kategori" id="kategori"
                            class="form-control @error('id_kategori') is-invalid @enderror" required>

                            <option value="" disabled
                                {{ old('id_kategori', $pointRules->id_kategori ?? '') == '' ? 'selected' : '' }}>
                                -- Pilih Kategori --
                            </option>

                            @foreach($kategoris as $k)
                                <option value="{{ $k->id_kategori }}"
                                    {{ old('id_kategori', $pointRules->id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- SUB KATEGORI --}}
                    <div class="form-group mb-3">
                        <label>Sub Kategori</label>
                        <select name="id_sub_kategori" id="subKategori"
                            class="form-control">

                            <option value=""
                                {{ old('id_sub_kategori', $pointRules->id_sub_kategori ?? '') == '' ? 'selected' : '' }}>
                                -- Pilih Sub Kategori --
                            </option>

                            @foreach($subKategoris as $sk)
                                <option value="{{ $sk->id_sub_kategori }}"
                                    data-kategori="{{ $sk->id_kategori }}"
                                    {{ old('id_sub_kategori', $pointRules->id_sub_kategori) == $sk->id_sub_kategori ? 'selected' : '' }}>
                                    {{ $sk->nama_sub_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- LEVEL --}}
                    <div class="form-group mb-3">
                        <label>Level</label>
                        <select name="id_level"
                            class="form-control @error('id_level') is-invalid @enderror">

                            <option value=""
                                {{ old('id_level', $pointRules->id_level ?? '') == '' ? 'selected' : '' }}>
                                -- Pilih Level --
                            </option>

                            @foreach($levels as $l)
                                <option value="{{ $l->id_level }}"
                                    {{ old('id_level', $pointRules->id_level) == $l->id_level ? 'selected' : '' }}>
                                    {{ $l->nama_level }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- POIN --}}
                    <div class="form-group mb-3">
                        <label>Poin Akhir</label>
                        <input type="number"
                            name="poin_akhir"
                            class="form-control @error('poin_akhir') is-invalid @enderror"
                            value="{{ old('poin_akhir', $pointRules->poin_akhir) }}"
                            required>
                    </div>

                    {{-- BUTTON --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.poin.index') }}" class="btn btn-secondary">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const kategoriSelect = document.getElementById('kategori');
    const subKategoriSelect = document.getElementById('subKategori');

    function filterSubKategori() {
        const selectedKategori = kategoriSelect.value;
        const currentValue = subKategoriSelect.value;

        // disable kalau kategori kosong
        subKategoriSelect.disabled = !selectedKategori;

        Array.from(subKategoriSelect.options).forEach(option => {
            if (!option.value) return;

            option.hidden = option.dataset.kategori !== selectedKategori;
        });

        // cek apakah value lama masih valid
        const isValid = Array.from(subKategoriSelect.options).some(option =>
            option.value === currentValue && !option.hidden
        );

        subKategoriSelect.value = isValid ? currentValue : '';
    }

    kategoriSelect.addEventListener('change', filterSubKategori);

    window.addEventListener('DOMContentLoaded', filterSubKategori);
</script>
@endpush