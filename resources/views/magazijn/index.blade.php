<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Magazijn Jamin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .icon-link {
            text-decoration: none;
            font-size: 20px;
            margin: 0 5px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('layouts.navigation')
    <div class="container">
        <h1 class="text-3xl font-bold mb-4">Overzicht Magazijn Jamin</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Barcode</th>
                    <th>Naam</th>
                    <th>VerpakkingsEenheid (kg)</th>
                    <th>AantalAanwezig</th>
                    <th>Leverantie Info</th>
                    <th>Allergenen Info</th>
                </tr>
            </thead>
            <tbody>
                @foreach($magazijn as $item)
                    <tr>
                        <td>{{ $item->product->barcode }}</td>
                        <td>{{ $item->product->naam }}</td>
                        <td>{{ $item->VerpakkingsEenheid }}</td>
                        <td>{{ $item->AantalAanwezig ?? 'NULL' }}</td>
                        <td>
                            <a href="{{ route('magazijn.levering-info', $item->ProductId) }}" class="icon-link" title="Levering Informatie">❓</a>
                        </td>
                        <td>
                            <a href="{{ route('magazijn.allergenen-info', $item->ProductId) }}" class="icon-link" title="Allergenen Informatie" style="color: red;">❌</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-4">
            <a href="{{ route('magazijn.index') }}" class="text-blue-600 hover:underline">Terug naar overzicht</a>
        </div>
    </div>
</body>
</html>

