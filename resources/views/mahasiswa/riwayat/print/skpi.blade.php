<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKPI - {{ $mahasiswa->nama_mhs }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
        }

        .header h2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .header p {
            font-size: 12px;
            margin: 5px 0;
        }

        .content {
            margin: 30px 0;
            text-align: justify;
        }

        .content p {
            margin-bottom: 15px;
            font-size: 14px;
            line-height: 1.8;
        }

        .info-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        .info-table tr {
            border-bottom: 1px solid #ddd;
        }

        .info-table td {
            padding: 8px 0;
            font-size: 14px;
        }

        .info-table td:first-child {
            width: 30%;
            font-weight: bold;
        }

        .sertifikat-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .sertifikat-table thead {
            background-color: #f8f9fa;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
        }

        .sertifikat-table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 13px;
            border: 1px solid #ddd;
        }

        .sertifikat-table td {
            padding: 12px;
            font-size: 13px;
            border: 1px solid #ddd;
        }

        .sertifikat-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .total-poin {
            display: flex;
            justify-content: flex-end;
            margin: 20px 0;
            font-size: 14px;
        }

        .total-poin strong {
            margin-right: 50px;
            font-weight: bold;
            padding-right: 12px;
            border-bottom: 1px solid #000;
        }

        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 200px;
            text-align: center;
            font-size: 12px;
        }

        .signature-box p {
            margin: 5px 0;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
        }

        .text-right {
            text-align: right;
            margin-right: 50px;
        }

        .text-center {
            text-align: center;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                padding: 0;
                max-width: 100%;
            }

            .no-print {
                display: none;
            }
        }

        .print-button {
            margin-bottom: 20px;
            text-align: right;
        }

        .print-button button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .print-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Tombol Print -->
        <div class="print-button no-print">
            <button onclick="window.print()">
                <i class="mdi mdi-printer"></i> Cetak / Print
            </button>
        </div>

        <!-- Header -->
        <div class="header">
            <h2>SURAT KETERANGAN PENDAMPING IJAZAH</h2>
            <h2>(SKPI)</h2>
            <p style="margin-top: 15px;">Nomor:
                {{ $pengajuanSKPI->id_pengajuan_skpi }}/SKPI/{{ \Carbon\Carbon::parse($pengajuanSKPI->tgl_pengajuan_skpi)->format('Y') }}
            </p>
        </div>

        <!-- Informasi Mahasiswa -->
        <table class="info-table">
            <tr>
                <td>Nama Mahasiswa</td>
                <td>: {{ $mahasiswa->nama_mhs }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>: {{ $mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td>Prodi</td>
                <td>: {{ $mahasiswa->prodi->nama_prodi ?? '-' }}</td>
            </tr>
            <tr>
                <td>Fakultas</td>
                <td>: {{ $mahasiswa->prodi->fakultas->nama_fakultas ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal Pengajuan</td>
                <td>: {{ \Carbon\Carbon::parse($pengajuanSKPI->tgl_pengajuan_skpi)->format('d-m-Y') }}</td>
            </tr>
        </table>

        <!-- Isi Surat -->
        <div class="content">
            <p style="text-align: center; font-weight: bold; margin-bottom: 20px;">Daftar Sertifikat yang Telah
                Disetujui</p>

            @if($sertifikatDiterima->count() > 0)
                <table class="sertifikat-table">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center;">No</th>
                            <th style="width: 50%;">Nama Sertifikat</th>
                            <th style="width: 20%;">Kategori</th>
                            <th style="width: 15%; text-align: center;">Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sertifikatDiterima as $index => $sertifikat)
                            <tr>
                                <td style="text-align: center;">{{ $index + 1 }}</td>
                                <td>{{ $sertifikat->nama_sertifikat }}</td>
                                <td>{{ $sertifikat->kategori->nama_kategori ?? '-' }}</td>
                                <td style="text-align: center;">{{ $sertifikat->poin_akhir ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="total-poin">
                    <strong>Total Poin: {{ $totalPoin }}</strong>
                </div>
            @else
                <div class="alert alert-warning"
                    style="padding: 15px; background-color: #fff3cd; border: 1px solid #ffc107; margin: 20px 0;">
                    <p style="margin: 0; font-size: 14px;">Belum ada sertifikat yang disetujui.</p>
                </div>
            @endif

            <p style="margin-top: 30px;">
                Surat keterangan ini diberikan kepada mahasiswa tersebut di atas sebagai pendamping ijazah dalam rangka
                mengakui capaian pembelajaran tambahan yang telah diperoleh di luar program studi utama.
            </p>
        </div>

        <!-- Footer / Tanda Tangan -->
        <div class="footer">
            <div></div>
            <div class="signature-box text-right">
                <p>{{ \Carbon\Carbon::parse($pengajuanSKPI->tgl_pengajuan_skpi)->format('d F Y') }}</p>
                <p style="margin-top: 30px;">Mengetahui,</p>
                <p style="margin-top: 50px; font-weight: bold;">_____________________</p>
                <p>Ketua Program Studi</p>
            </div>
        </div>
    </div>

    <script>
        // Untuk mobile, tambahkan opsi download PDF
        document.addEventListener('DOMContentLoaded', function () {
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                // Tampilkan pesan untuk mobile
            }
        });
    </script>
</body>

</html>