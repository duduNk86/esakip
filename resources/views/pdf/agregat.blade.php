<!DOCTYPE html>
<html>

<head>
    <title>Agregat Nilai Evaluasi SAKIP Tahun {{ $tahunMulai }} - {{ $tahunSampai }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        h1 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h1>Agregat Nilai Evaluasi SAKIP Tahun {{ $tahunMulai }} - {{ $tahunSampai }}</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Perangkat Daerah</th>
                @foreach ($agregatYears as $year)
                    <th class="text-center">{{ $year }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($agregatData as $index => $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $data['nama_opd'] }}</td>
                    @foreach ($agregatYears as $year)
                        <td class="text-right">
                            {{ $data[$year] ?? '-' }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
