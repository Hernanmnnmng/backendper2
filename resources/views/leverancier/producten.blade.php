<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geleverde Producten - {{ $leverancier->naam }}</title>
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
            margin: 0 5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .icon-link svg {
            width: 20px;
            height: 20px;
        }
        .icon-link:hover svg {
            opacity: 0.7;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('layouts.navigation')
    <div class="container">
        <h1 class="text-3xl font-bold mb-4">Geleverde Producten</h1>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="info-box">
            <p><strong>Leverancier:</strong> {{ $leverancier->naam }}</p>
            <p><strong>Contactpersoon:</strong> {{ $leverancier->ContactPersoon }}</p>
            <p><strong>Leveranciernummer:</strong> {{ $leverancier->LeverancierNummer }}</p>
            <p><strong>Mobiel:</strong> {{ $leverancier->Mobiel }}</p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Productnaam</th>
                    <th>Barcode</th>
                    <th>Aantal in Magazijn</th>
                    <th>Laatste levering</th>
                    <th>Nieuwe levering</th>
                </tr>
            </thead>
            <tbody>
                @forelse($producten as $product)
                    <tr>
                        <td>{{ $product['ProductNaam'] }}</td>
                        <td>{{ $product['barcode'] }}</td>
                        <td>{{ $product['AantalInMagazijn'] }}</td>
                        <td>{{ $product['LaatsteLevering'] ? \Carbon\Carbon::parse($product['LaatsteLevering'])->format('d-m-Y') : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('leverancier.add-levering', ['leverancierId' => $leverancier->id, 'productId' => $product['ProductId']]) }}" class="icon-link" title="Nieuwe levering toevoegen" style="color: #28a745;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Geen producten gevonden</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-4">
            <a href="{{ route('leverancier.index') }}" class="text-blue-600 hover:underline">Terug naar overzicht leveranciers</a>
        </div>
    </div>
</body>
</html>

