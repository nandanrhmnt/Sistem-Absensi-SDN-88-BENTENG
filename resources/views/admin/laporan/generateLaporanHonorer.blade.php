<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi Honorer</title>
    <style>
        @page {
            size: landscape;
            margin: 1cm;
        }
        body {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 50px;
        }
        th, td {
            padding: 5px;
            border: 1px solid black;
        }
        th {
            background-color: #ddd;
        }
        .footer {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }
        .signature-box {
            /* border: 1px solid black; */
            width: 300px;
            height: 150px;
            text-align: left;
            padding: 10px;
            position: relative;
        }
        .signature-box p {
            margin: 0;
            padding: 0;
        }
        .center {
            text-align: center;
        }
        .signature {
            position: absolute;
            bottom: 20px;
            left: 10px;
            right: 10px;
            text-align: center;
        }
        .signature-space {
            margin-top: 50px;
        }
        h1, h2, h3, h4 {
            margin: 5px 0;
        }
        .jumlah-honorer {
            margin-top: -20px; 
        }
    </style>
</head>
<body>
    <h1>DAFTAR HADIR HONORER</h1>
    <h2>SDN 88 BENGKULU TENGAH</h2>
    <h3>TAHUN PELAJARAN 2023/2024</h3>
    <h4>Bulan : {{ $bulan }}</h4>
    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Jenis Kelamin</th>
                <th colspan="{{ count($tanggal) }}">Tanggal</th>
                <th colspan="3">Jumlah</th>
            </tr>
            <tr>
                @foreach ($tanggal as $date)
                <th>{{ $date->format('d') }}</th>
                @endforeach
                <th>S</th>
                <th>I</th>
                <th>A</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listHonorer as $index => $honorer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $honorer->Nama }}</td>
                <td>{{ $honorer->jenis_kelamin }}</td>
                
                @php
                $jumlahS = 0;
                $jumlahI = 0;
                $jumlahA = 0;
                @endphp
                
                @foreach ($tanggal as $date)
                <td>
                    @php
                    $kehadiran = isset($listAbsen[$honorer->id_pegawai][$date->format('d')]) ? $listAbsen[$honorer->id_pegawai][$date->format('d')]->kehadiran : null;
                    @endphp
                    @if ($kehadiran)
                    @php
                    $kehadiran = $kehadiran['kehadiran'];
                    @endphp
                    @if ($kehadiran == 'Hadir')
                    &#10003;
                    @elseif ($kehadiran == 'Sakit')
                    S
                    @php $jumlahS++ @endphp
                    @elseif ($kehadiran == 'Izin')
                    I
                    @php $jumlahI++ @endphp
                    @elseif ($kehadiran == 'Tanpa keterangan')
                    A
                    @php $jumlahA++ @endphp
                    @endif
                    @else
                    -
                    @endif
                </td>
                @endforeach
                
                <td>{{ $jumlahS }}</td>
                <td>{{ $jumlahI }}</td>
                <td>{{ $jumlahA }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h4 class="jumlah-honorer">Jumlah Honorer (Laki-laki: {{ $jumlahHonorer['laki'] }}, Perempuan: {{ $jumlahHonorer['perempuan'] }})</h4>
    
    <div class="footer">
        <div class="signature-box">
            <p class="center">Mengetahui,</p>
            <div class="signature">
                <p class="signature-space">______________________</p>
            </div>
        </div>
    </div>
</body>
</html>
