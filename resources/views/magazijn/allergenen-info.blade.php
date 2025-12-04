<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Allergenen - {{ $product->naam }}</title>
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
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .info-box {
            background-color: #e8f4f8;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('layouts.navigation')
    <div class="container">
        <h1 class="text-3xl font-bold mb-4">Overzicht Allergenen</h1>
        
        <div class="info-box">
            <p><strong>Naam Product:</strong> {{ $product->naam }}</p>
            <p><strong>Barcode:</strong> {{ $product->barcode }}</p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Omschrijving</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allergenen as $item)
                    <tr>
                        <td>{{ $item->naam }}</td>
                        <td>{{ $item->omschrijving }}</td>
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

