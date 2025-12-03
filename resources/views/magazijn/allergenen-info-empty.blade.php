<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Allergenen - {{ $product->naam }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .message-box {
            background-color: #d1ecf1;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
            border: 1px solid #bee5eb;
            text-align: center;
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
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('magazijn.index') }}";
        }, 4000);
    </script>
</head>
<body class="bg-gray-100">
    <div class="container">
        <h1 class="text-3xl font-bold mb-4">Overzicht Allergenen</h1>
        
        <div class="info-box">
            <p><strong>Naam Product:</strong> {{ $product->naam }}</p>
            <p><strong>Barcode:</strong> {{ $product->barcode }}</p>
        </div>
        
        <div class="message-box">
            <p class="text-lg">In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken</p>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('magazijn.index') }}" class="text-blue-600 hover:underline">Terug naar overzicht</a>
        </div>
    </div>
</body>
</html>

