<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levering Informatie - {{ $product->naam }}</title>
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
        <h1 class="text-3xl font-bold mb-4">Levering Informatie</h1>
        
        @if($leverancier)
            <div class="info-box">
                <p><strong>Naam leverancier:</strong> {{ $leverancier->naam }}</p>
                <p><strong>Contactpersoon leverancier:</strong> {{ $leverancier->ContactPersoon }}</p>
                <p><strong>Leveranciernummer:</strong> {{ $leverancier->LeverancierNummer }}</p>
                <p><strong>Mobiel:</strong> {{ $leverancier->Mobiel }}</p>
            </div>
        @endif
        
        <h2 class="text-2xl font-semibold mb-2">Product: {{ $product->naam }}</h2>
        <p class="mb-4"><strong>Barcode:</strong> {{ $product->barcode }}</p>
        
        <table>
            <thead>
                <tr>
                    <th>Datum laatste levering</th>
                    <th>Aantal</th>
                    <th>Datum eerstvolgende levering</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leveringen as $levering)
                    <tr>
                        <td>{{ $levering->DatumLevering->format('d-m-Y') }}</td>
                        <td>{{ $levering->Aantal }}</td>
                        <td>{{ $levering->DatumEerstVolgendeLevering ? $levering->DatumEerstVolgendeLevering->format('d-m-Y') : 'N/A' }}</td>
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

