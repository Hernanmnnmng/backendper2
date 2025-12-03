<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levering Informatie - {{ $product->naam }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .message-box {
            background-color: #fff3cd;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
            border: 1px solid #ffc107;
            text-align: center;
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
        <h1 class="text-3xl font-bold mb-4">Levering Informatie</h1>
        
        <div class="message-box">
            <p class="text-lg">Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende levering is: {{ $nextDeliveryDate }}</p>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('magazijn.index') }}" class="text-blue-600 hover:underline">Terug naar overzicht</a>
        </div>
    </div>
</body>
</html>

