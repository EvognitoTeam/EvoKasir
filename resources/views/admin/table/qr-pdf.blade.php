<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>QR Code Meja - {{ $mitra->mitra_name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 10px;
        }

        .page-layout-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 25px;
        }

        .card-cell {
            width: 50%;
            vertical-align: top;
        }

        .card {
            border: 2px solid #ddd;
            border-radius: 8px;
            /* height: 144px; */
            width: 100%;
            overflow: hidden;
        }

        .card-header {
            text-align: center;
            padding: 10px;
            border-bottom: 2px solid #eee;
        }

        .card-header-title {
            font-size: 16px;
            font-weight: bold;
            color: #dc2626;
        }

        .card-content {
            padding: 5px;
            height: 98px;
            /* Tinggi konten disesuaikan */
        }

        .card-footer {
            background-color: #dc2626;
            color: white;
            text-align: center;
            padding: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
        }

        .value {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

    <table class="page-layout-table">
        <tbody>
            @foreach ($tablesWithQr->chunk(2) as $tableRow)
                <tr>
                    @foreach ($tableRow as $table)
                        <td class="card-cell">
                            <div class="card">
                                <div class="card-header">
                                    <span class="card-header-title">{{ $mitra->mitra_name }}</span>
                                </div>

                                <div class="card-content">
                                    <table style="width: 100%;">
                                        <tbody>
                                            <tr>
                                                {{-- Kolom 1: Gambar QR Code --}}
                                                <td style="width: 100px; vertical-align: top;">
                                                    <img src="data:image/png;base64,{{ $table['qr_code'] }}"
                                                        alt="QR Code" style="width: 96px; height: 96px;">
                                                </td>

                                                {{-- Kolom 2: Detail Teks --}}
                                                <td style="vertical-align: top; padding-left: 5px;">
                                                    <div class="label">NAMA MEJA</div>
                                                    <div class="value">{{ $table['table_name'] }}</div>
                                                    <div class="label">KODE MEJA</div>
                                                    <div class="value">{{ $table['table_code'] }}</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-footer">
                                    SCAN UNTUK PESAN
                                </div>
                            </div>
                        </td>
                    @endforeach
                    @if (count($tableRow) < 2)
                        <td class="card-cell"></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
