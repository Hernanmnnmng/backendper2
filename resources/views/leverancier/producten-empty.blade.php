<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geleverde Producten - {{ $leverancier->naam }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        .message-box {
            background-color: #fff3cd;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            font-size: 18px;
            border: 1px solid #ffc107;
        }
        .info-box {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
    <script>
        // Redirect after 3 seconds (Scenario 02 requirement)
        setTimeout(function() {
            window.location.href = "{{ route('leverancier.index') }}";
        }, 3000);
    </script>
</head>
<body class="bg-gray-100">
    @include('layouts.navigation')
    <div class="container">
        <h1 class="text-3xl font-bold mb-4">Geleverde Producten</h1>
        
        <div class="info-box">
            <p><strong>Leverancier:</strong> {{ $leverancier->naam }}</p>
            <p><strong>Contactpersoon:</strong> {{ $leverancier->ContactPersoon }}</p>
            <p><strong>Leveranciernummer:</strong> {{ $leverancier->LeverancierNummer }}</p>
            <p><strong>Mobiel:</strong> {{ $leverancier->Mobiel }}</p>
        </div>
        
        <div class="message-box">
            Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin
        </div>
        
        <div class="mt-4">
            <p>U wordt over 3 seconden doorgestuurd naar het overzicht leveranciers...</p>
            <a href="{{ route('leverancier.index') }}" class="text-blue-600 hover:underline">Klik hier om direct terug te gaan</a>
        </div>
    </div>
</body>
</html>

