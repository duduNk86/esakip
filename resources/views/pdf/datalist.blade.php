<!DOCTYPE html>
<html>

<head>
    <title>Daftar Nilai Evaluasi SAKIP Tahun {{ $tahun }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 12pt;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        td {
            font-size: 9pt;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Daftar Nilai Evaluasi SAKIP Perangkat Daerah</h1>
        <h1>Kabupaten Wonosobo Tahun {{ $tahun }}</h1>
    </div>

    <table>
        <thead>
            {{-- <tr>
                <th style="width: 3%;" rowspan="3">#</th>
                <th style="width: 8%;" rowspan="3">Periode</th>
                <th style="width: 25%;" rowspan="3">Nama OPD</th>
                <th style="width: 10%;" rowspan="3">Status</th>
                <th style="width: 8%;" colspan="8">Aspek A (30%)</th>
                <th style="width: 8%;" colspan="8">Aspek B (30%)</th>
                <th style="width: 8%;" colspan="8">Aspek C (15%)</th>
                <th style="width: 8%;" colspan="8">Aspek D (25%)</th>
                <th style="width: 8%;" rowspan="3">Nilai Sakip (A+B+C+D) 100%</th>
                <th style="width: 14%;" rowspan="3">Predikat</th>
            </tr> --}}
            <tr>
                <th rowspan="3">No</th>
                {{-- <th rowspan="3">Periode</th> --}}
                <th rowspan="3">Nama OPD</th>
                <th colspan="8">Aspek A (30%)</th>
                <th colspan="8">Aspek B (30%)</th>
                <th colspan="8">Aspek C (15%)</th>
                <th colspan="8">Aspek D (25%)</th>
                <th rowspan="3">Total Skor</th>
                <th rowspan="3">Nilai Sakip</th>
                <th rowspan="3">Predikat</th>
            </tr>
            <tr>
                <th colspan="2">A1 (6%)</th>
                <th colspan="2">A2 (9%)</th>
                <th colspan="2">A3 (15%)</th>
                <th colspan="2">Sub Total A</th>
                <th colspan="2">B1 (6%)</th>
                <th colspan="2">B2 (9%)</th>
                <th colspan="2">B3 (15%)</th>
                <th colspan="2">Sub Total B</th>
                <th colspan="2">C1 (3%)</th>
                <th colspan="2">C2 (4.5%)</th>
                <th colspan="2">C3 (7.5%)</th>
                <th colspan="2">Sub Total C</th>
                <th colspan="2">D1 (5%)</th>
                <th colspan="2">D2 (7.5%)</th>
                <th colspan="2">D3 (12.5%)</th>
                <th colspan="2">Sub Total D</th>
            </tr>
            <tr>
                {{-- Aspek A --}}
                <th>Skor</th>
                <th>Nilai</th>
                <th>Skor</th>
                <th>Nilai</th>
                <th>Skor</th>
                <th>Nilai</th>
                <th>Skor</th>
                <th>Nilai</th>
                {{-- Aspek B --}}
                <th>Skor</th>
                <th>Nilai</th>
                <th>Skor</th>
                <th>Nilai</th>
                <th>Skor</th>
                <th>Nilai</th>
                <th>Skor</th>
                <th>Nilai</th>
                {{-- Aspek C --}}
                <th>Skor</th>
                <th>Nilai</th>
                <th>Skor</th>
                <th>Nilai</th>
                <th>Skor</th>
                <th>Nilai</th>
                <th>Skor</th>
                <th>Nilai</th>
                {{-- Aspek D --}}
                <th>Skor</th>
                <th>Nilai</th>
                <th>Skor</th>
                <th>Nilai</th>
                <th>Skor</th>
                <th>Nilai</th>
                <th>Skor</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datalists as $index => $datalist)
                <tr>
                    <td class="text-left">{{ $index + 1 }}</td>
                    {{-- <td class="text-center">{{ $datalist->periode->tahun }}</td> --}}
                    <td>{{ $datalist->opd->nama_opd }}</td>

                    {{-- Aspek A --}}
                    <td class="text-right">{{ number_format($datalist->ev_a1_s, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_a1_n, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_a2_s, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_a2_n, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_a3_s, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_a3_n, 2) }}</td>
                    <td class="text-right font-bold">{{ number_format($datalist->ev_a_skor, 2) }}</td>
                    <td class="text-right font-bold">{{ number_format($datalist->ev_a_nilai, 2) }}</td>

                    {{-- Aspek B --}}
                    <td class="text-right">{{ number_format($datalist->ev_b1_s, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_b1_n, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_b2_s, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_b2_n, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_b3_s, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_b3_n, 2) }}</td>
                    <td class="text-right font-bold">{{ number_format($datalist->ev_b_skor, 2) }}</td>
                    <td class="text-right font-bold">{{ number_format($datalist->ev_b_nilai, 2) }}</td>

                    {{-- Aspek C --}}
                    <td class="text-right">{{ number_format($datalist->ev_c1_s, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_c1_n, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_c2_s, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_c2_n, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_c3_s, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_c3_n, 2) }}</td>
                    <td class="text-right font-bold">{{ number_format($datalist->ev_c_skor, 2) }}</td>
                    <td class="text-right font-bold">{{ number_format($datalist->ev_c_nilai, 2) }}</td>

                    {{-- Aspek D --}}
                    <td class="text-right">{{ number_format($datalist->ev_d1_s, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_d1_n, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_d2_s, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_d2_n, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_d3_s, 2) }}</td>
                    <td class="text-right">{{ number_format($datalist->ev_d3_n, 2) }}</td>
                    <td class="text-right font-bold">{{ number_format($datalist->ev_d_skor, 2) }}</td>
                    <td class="text-right font-bold">{{ number_format($datalist->ev_d_nilai, 2) }}</td>

                    <td class="text-right font-bold">{{ number_format($datalist->skor_by_penilai, 2) }}</td>
                    <td class="text-right font-bold">{{ number_format($datalist->nilai_by_penilai, 2) }}</td>
                    <td class="text-center font-bold">
                        @if ($datalist->predikat === 'AA')
                            Sangat Memuaskan ({{ $datalist->predikat }})
                        @elseif($datalist->predikat === 'A')
                            Memuaskan ({{ $datalist->predikat }})
                        @elseif($datalist->predikat === 'BB')
                            Sangat Baik ({{ $datalist->predikat }})
                        @elseif($datalist->predikat === 'B')
                            Baik ({{ $datalist->predikat }})
                        @elseif($datalist->predikat === 'CC')
                            Cukup/Memadai ({{ $datalist->predikat }})
                        @elseif($datalist->predikat === 'C')
                            Kurang ({{ $datalist->predikat }})
                        @elseif($datalist->predikat === 'D')
                            Sangat Kurang ({{ $datalist->predikat }})
                        @else
                            {{ $datalist->predikat }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
