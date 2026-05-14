<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Pengelola</title>
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

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Data Pengelola</h2>
    <p class="subtitle">Tanggal Export: {{ date('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengelola</th>
                <th>Role</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengelolas as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->nama_pengelola }}</td>
                    <td class="text-center">{{ $p->user->role ?? '-' }}</td>
                    <td class="text-center">{{ $p->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data pengelola</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>