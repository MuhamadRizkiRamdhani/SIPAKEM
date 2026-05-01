@extends('layouts.app')

@section('content')
    <h1>Data Poin</h1>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manajemen Data Poin</h4>
                    <div class="d-flex justify-content-end mb-3 gap-3">
                    </div>
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID_Rules</th>
                                <th>Kategori</th>
                                <th>Sub-Kategori</th>
                                <th>Level</th>
                                <th>Poin Akhir</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0001</td>
                                <td>Perlombaan</td>
                                <td>Nasional</td>
                                <td>Juara 1</td>
                                <td>50</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>0002</td>
                                <td>Perlombaan</td>
                                <td>Nasional</td>
                                <td>Juara 2</td>
                                <td>40</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>0001</td>
                                <td>Perlombaan</td>
                                <td>Nasional</td>
                                <td>Juara 3</td>
                                <td>30</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection