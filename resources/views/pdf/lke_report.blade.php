<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LKE Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        th {
            background-color: #e9e9e9;
            text-align: center;
            font-weight: bold;
            vertical-align: middle;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 11pt;
        }

        .summary-container {
            /* Flexbox atau float container */
            margin-bottom: 15px;
        }

        .summary-column {
            width: 50%;
            /* Adjust width as needed, ensure total <= 100% including margin */
            float: left;
            margin-right: 2%;
            /* Gap between columns */
        }

        .summary-column:last-child {
            margin-right: 0;
            /* No margin on the last column */
            float: right;
            /* Ensure it floats to the right */
        }

        .summary-table {
            width: 100%;
            /* Make table take full width of its column container */
            border-collapse: collapse;
            margin-bottom: 5px;
            /* Small margin between tables if needed */
        }

        .summary-table th,
        .summary-table td {
            border: none;
            padding: 4px 10px;
            font-size: 10pt;
        }

        .summary-table th {
            text-align: left;
            background-color: #ffffff;
            width: 30%;
            /* Adjust label width within each summary table */
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-small {
            font-size: 8pt;
        }

        /* Specific column widths for the main LKE table (now 9 columns) */
        .col-no {
            width: 3%;
        }

        .col-aspek-komponen {
            width: 15%;
            /* Adjusted */
        }

        .col-pertanyaan {
            width: 25%;
            /* Adjusted */
        }

        .col-nilai-max {
            width: 5%;
            /* Adjusted */
        }

        .col-url-bukti {
            width: 8%;
            /* New column - width kept same */
        }

        .col-skor-mandiri,
        .col-skor-penilai {
            width: 6%;
            /* Adjusted (Total 12%) */
        }

        .col-catatan {
            width: 17%;
            /* Adjusted */
        }

        .col-saran {
            width: 15%;
            /* Adjusted */
        }

        /* Total: 3 + 15 + 25 + 5 + 10 + 6 + 6 + 15 + 15 = 100% */

        /* Styles for subcomponent rows */
        .sub-row td {
            font-size: 8.5pt;
        }

        /* Style for parent rows (Aspek, Komponen) */
        .parent-row strong {
            font-size: 9.5pt;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LEMBAR KERJA EVALUASI</h1>
        <p>PENILAIAN AKUNTABILITAS KINERJA INSTANSI PEMERINTAH (SAKIP)</p>
        <p>{{ strtoupper($penilaianOpd->opd->nama_opd) }}</p>
    </div>

    <div class="summary-container clearfix">
        <div class="summary-column">
            <table class="summary-table">
                <tr>
                    <th>Nomor LKE</th>
                    <td>:
                        {{ $penilaianOpd->nomor_lke ?? '700.1.2.1/' }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ '/' . $penilaianOpd->periode->tahun }}
                    </td>
                </tr>
                {{-- <tr>
                    <th>Perangkat Daerah</th>
                    <td>: {{ $penilaianOpd->opd->nama_opd }}</td>
                </tr> --}}
                <tr>
                    <th>Disusun Oleh</th>
                    <td>: </td>
                    {{-- <td>: {{ $penilaianOpd->user->name ?? '-' }}</td> --}}
                </tr>
                <tr>
                    <th>Direviu Oleh</th>
                    <td>: </td>
                    {{-- <td>: {{ $penilaianOpd->penilai->name ?? '-' }}</td> --}}
                </tr>
                <tr>
                    <th>Disetujui Oleh</th>
                    <td>: </td>
                    {{-- <td>: Inspektur Daerah</td> --}}
                </tr>
            </table>
        </div>

        <div class="summary-column">
            <table class="summary-table">
                <tr>
                    <th>Periode Evaluasi</th>
                    <td>: {{ $penilaianOpd->periode->tahun }}</td>
                </tr>
                <tr>
                    <th>Skor Evaluasi</th>
                    <td>: {{ $penilaianOpd->skor_by_penilai }}</td>
                </tr>
                <tr>
                    <th>Nilai Evaluasi</th>
                    <td>: {{ $penilaianOpd->nilai_by_penilai }}</td>
                </tr>
                <tr>
                    <th>Predikat</th>
                    <td>: @if ($penilaianOpd->predikat === 'AA')
                            AA (Sangat Memuaskan)
                        @elseif($penilaianOpd->predikat === 'A')
                            A (Memuaskan)
                        @elseif($penilaianOpd->predikat === 'BB')
                            BB (Sangat Baik)
                        @elseif($penilaianOpd->predikat === 'B')
                            B (Baik)
                        @elseif($penilaianOpd->predikat === 'CC')
                            CC (Cukup / Memadai)
                        @elseif($penilaianOpd->predikat === 'C')
                            C (Kurang)
                        @elseif($penilaianOpd->predikat === 'D')
                            D (Sangat Kurang)
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" class="col-no">No</th>
                <th rowspan="2" class="col-aspek-komponen">Aspek/Komponen/ Subkomponen</th>
                <th rowspan="2" class="col-pertanyaan">Pertanyaan/Indikator Kinerja</th>
                <th rowspan="2" class="col-nilai-max">Skor Max</th>
                <th rowspan="2" class="col-url-bukti">URL Bukti</th>
                <th colspan="2" class="text-center">Skor Penilaian</th>
                <th rowspan="2" class="col-catatan">Catatan</th>
                <th rowspan="2" class="col-saran">Saran</th>
            </tr>
            <tr>
                <th class="col-skor-mandiri">OPD</th>
                <th class="col-skor-penilai">APIP</th>
            </tr>
        </thead>
        <tbody>
            @php $aspek_no = 1; @endphp
            @foreach ($dataAspeks as $aspek)
                <tr class="parent-row">
                    <td class="text-center" style="color:red;"><strong>{{ $aspek['kode'] }}</strong></td>
                    <td colspan="8" style="color:red;"><strong>{{ $aspek['keterangan'] }} (Bobot:
                            {{ $aspek['bobot'] }}%)</strong>
                    </td>
                </tr>
                @foreach ($aspek['komponens'] as $komponen)
                    <tr class="parent-row">
                        <td class="text-center"></td>
                        <td colspan="8" style="color:green;"><strong>{{ $komponen['kode'] }} -
                                {{ $komponen['keterangan'] }} (Bobot:
                                {{ $komponen['bobot'] }}%)</strong></td>
                    </tr>
                    @foreach ($komponen['subkomponens'] as $subkomponen)
                        <tr class="sub-row">
                            <td class="text-center"></td>
                            <td class="text-small">{{ $subkomponen['kode'] }}</td>
                            <td>{{ $subkomponen['pertanyaan'] }}</td>
                            <td class="text-center">{{ $subkomponen['nilai_subkomponen_max'] }}</td>
                            <td class="text-center"><a href="{{ $subkomponen['url_bukti'] }}">Download</a></td>
                            <td class="text-center">{{ $subkomponen['skor_opd'] }}</td>
                            <td class="text-center">{{ $subkomponen['skor_penilai'] }}</td>
                            <td>{{ $subkomponen['catatan'] }}</td>
                            <td>{{ $subkomponen['saran'] }}</td>
                        </tr>
                    @endforeach
                    {{-- Rekapitulasi Skor per Komponen (Mandiri dan Penilai) --}}
                    <tr class="total-row">
                        <td colspan="4" class="text-right" style="color:green;"><strong>Skor Komponen
                                {{ $komponen['kode'] }}</strong>
                        </td>
                        <td colspan="1"></td>
                        <td class="text-center" style="color:green;">
                            {{ $penilaianOpd->{'pm_' . strtolower($komponen['kode']) . '_s'} }}
                        </td>
                        <td class="text-center" style="color:green;">
                            {{ $penilaianOpd->{'ev_' . strtolower($komponen['kode']) . '_s'} }}
                        </td>
                        <td colspan="2"></td>
                    </tr>
                    {{-- Rekapitulasi Nilai per Komponen (Mandiri dan Penilai) --}}
                    <tr class="total-row">
                        <td colspan="4" class="text-right" style="color:green;"><strong>Nilai Komponen
                                {{ $komponen['kode'] }}</strong>
                        </td>
                        <td colspan="1"></td>
                        <td class="text-center" style="color:green;">
                            {{ $penilaianOpd->{'pm_' . strtolower($komponen['kode']) . '_n'} }}
                        </td>
                        <td class="text-center" style="color:green;">
                            {{ $penilaianOpd->{'ev_' . strtolower($komponen['kode']) . '_n'} }}
                        </td>
                        <td colspan="2"></td>
                    </tr>
                @endforeach
                {{-- Rekapitulasi Skor per Aspek (Mandiri dan Penilai) --}}
                <tr class="total-row">
                    <td colspan="4" class="text-right" style="color:red;"><strong>Skor Aspek
                            {{ $aspek['kode'] }}</strong></td>
                    <td colspan="1"></td>
                    <td class="text-center" style="color:red;">
                        {{ $penilaianOpd->{'pm_' . strtolower($aspek['kode']) . '_skor'} }}</td>
                    <td class="text-center" style="color:red;">
                        {{ $penilaianOpd->{'ev_' . strtolower($aspek['kode']) . '_skor'} }}</td>
                    <td colspan="2"></td>
                </tr>
                {{-- Rekapitulasi Nilai per Aspek (Mandiri dan Penilai) --}}
                <tr class="total-row">
                    <td colspan="4" class="text-right" style="color:red;"><strong>Nilai Aspek
                            {{ $aspek['kode'] }}</strong></td>
                    <td colspan="1"></td>
                    <td class="text-center" style="color:red;">
                        {{ $penilaianOpd->{'pm_' . strtolower($aspek['kode']) . '_nilai'} }}</td>
                    <td class="text-center" style="color:red;">
                        {{ $penilaianOpd->{'ev_' . strtolower($aspek['kode']) . '_nilai'} }}</td>
                    <td colspan="2"></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right" style="color:blue;"><strong>Total Skor</strong></td>
                <td colspan="1"></td>
                <td class="text-center" style="color:blue;">{{ $penilaianOpd->skor_by_opd }}</td>
                <td class="text-center" style="color:blue;">{{ $penilaianOpd->skor_by_penilai }}</td>
                <td colspan="2"></td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right" style="color:blue;"><strong>Total Nilai</strong></td>
                <td colspan="1"></td>
                <td class="text-center" style="color:blue;">{{ $penilaianOpd->nilai_by_opd }}</td>
                <td class="text-center" style="color:blue;">{{ $penilaianOpd->nilai_by_penilai }}</td>
                <td colspan="2"></td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right" style="color:blue;"><strong>Predikat</strong></td>
                <td class="text-center" colspan="5" style="color:blue;">
                    @if ($penilaianOpd->predikat === 'AA')
                        AA (Sangat Memuaskan)
                    @elseif($penilaianOpd->predikat === 'A')
                        A (Memuaskan)
                    @elseif($penilaianOpd->predikat === 'BB')
                        BB (Sangat Baik)
                    @elseif($penilaianOpd->predikat === 'B')
                        B (Baik)
                    @elseif($penilaianOpd->predikat === 'CC')
                        CC (Cukup / Memadai)
                    @elseif($penilaianOpd->predikat === 'C')
                        C (Kurang)
                    @elseif($penilaianOpd->predikat === 'D')
                        D (Sangat Kurang)
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
