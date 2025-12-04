<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fout - Levering Product</title>
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
        .error-box {
            background-color: #f8d7da;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            font-size: 18px;
            border: 1px solid #dc3545;
            color: #721c24;
        }
        .info-box {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
    <script>
        // Redirect after 4 seconds (Scenario 02 requirement)
        setTimeout(function() {
            window.location.href = "{{ route('leverancier.producten', $leverancier->id) }}";
        }, 4000);
    </script>
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
        
        <div class="error-box">
            Het product {{ $product->naam }} van de leverancier {{ $leverancier->naam }} wordt niet meer geproduceerd
        </div>
        
        @if(isset($error_message))
            <div class="error-box" style="margin-top: 10px;">
                {{ $error_message }}
            </div>
        @endif
        
        <div class="mt-4">
            <p>U wordt over 4 seconden doorgestuurd naar het overzicht geleverde producten...</p>
            <a href="{{ route('leverancier.producten', $leverancier->id) }}" class="text-blue-600 hover:underline">Klik hier om direct terug te gaan</a>
        </div>
    </div>
</body>
</html>

