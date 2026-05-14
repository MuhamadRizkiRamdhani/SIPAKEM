<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            font-size: 12px;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
        }

        td {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Data Mahasiswa</h2>
    <p class="subtitle">Tanggal Export: {{ date('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Tahun Angkatan</th>
                <th>Prodi</th>
                <th>Fakultas</th>
                <th>Poin Kredit</th>
                <th>Beasiswa</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mahasiswas as $index => $m)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $m->nama_mhs }}</td>
                    <td class="text-center">{{ $m->nim }}</td>
                    <td class="text-center">{{ $m->tahun_angkatan }}</td>
                    <td>{{ $m->prodi->nama_prodi ?? '-' }}</td>
                    <td>{{ $m->prodi->fakultas->nama_fakultas ?? '-' }}</td>
                    <td class="text-center">{{ $m->poin_kredit }}</td>
                    <td class="text-center">{{ $m->beasiswa ? 'Ya' : 'Tidak' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data mahasiswa</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>