<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levering Product - {{ $product->naam }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .info-box {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .error {
            color: #dc3545;
            margin-top: 5px;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('layouts.navigation')
    <div class="container">
        <h1 class="text-3xl font-bold mb-4">Levering Product</h1>
        
        <div class="info-box">
            <p><strong>Leverancier:</strong> {{ $leverancier->naam }}</p>
            <p><strong>Product:</strong> {{ $product->naam }}</p>
            <p><strong>Barcode:</strong> {{ $product->barcode }}</p>
        </div>
        
        <form method="POST" action="{{ route('leverancier.store-levering', ['leverancierId' => $leverancier->id, 'productId' => $product->id]) }}">
            @csrf
            
            <div class="form-group">
                <label for="aantal">Aantal producteenheden *</label>
                <input type="number" id="aantal" name="aantal" min="1" required value="{{ old('aantal') }}">
                @error('aantal')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="datum_eerstvolgende_levering">Datum eerstvolgende levering *</label>
                <input type="date" id="datum_eerstvolgende_levering" name="datum_eerstvolgende_levering" required value="{{ old('datum_eerstvolgende_levering') }}">
                @error('datum_eerstvolgende_levering')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn">Sla op</button>
                <a href="{{ route('leverancier.producten', $leverancier->id) }}" class="text-blue-600 hover:underline ml-4">Annuleren</a>
            </div>
        </form>
    </div>
</body>
</html>

