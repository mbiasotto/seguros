<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>QR Codes para Impressão</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .page-header {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        td {
            width: 33.33%;
            text-align: center;
            border: 1px solid #eee;
            padding: 8px;
            vertical-align: middle;
        }
        .qr-item {
            margin: 0 auto;
            width: 100%;
        }
        .qr-item img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .qr-id {
            font-size: 12px;
            margin-top: 5px;
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    @php
        $itemsPerPage = 12; // 3x4 grid
        $totalItems = count($qrCodeFiles);
        $totalPages = ceil($totalItems / $itemsPerPage);
    @endphp

    @for ($page = 0; $page < $totalPages; $page++)
        <table>
            @for ($row = 0; $row < 4; $row++)
                <tr>
                    @for ($col = 0; $col < 3; $col++)
                        @php
                            $index = ($page * $itemsPerPage) + ($row * 3) + $col;
                            if ($index >= $totalItems) {
                                echo '<td></td>';
                                continue;
                            }
                            $file = $qrCodeFiles[$index];
                            $id = (int) preg_replace('/[^0-9]/', '', $file->getFilename());
                        @endphp
                        <td>
                            <div class="qr-item">
                                <img src="{{ public_path('qr_codes/' . $file->getFilename()) }}" alt="QR Code {{ $id }}">
                            </div>
                        </td>
                    @endfor
                </tr>
            @endfor
        </table>

        @if ($page < $totalPages - 1)
            <div class="page-break"></div>
        @endif
    @endfor
</body>
</html>