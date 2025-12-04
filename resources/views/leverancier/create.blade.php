<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Leverancier</title>
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
        input[type="text"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            resize: vertical;
        }
        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .error {
            color: #dc3545;
            margin-top: 5px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('layouts.navigation')
    <div class="container">
        <h1 class="text-3xl font-bold mb-4">Nieuwe Leverancier</h1>
        
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('leverancier.store') }}">
            @csrf
            
            <div class="form-group">
                <label for="naam">Naam *</label>
                <input type="text" id="naam" name="naam" required value="{{ old('naam') }}">
                @error('naam')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="ContactPersoon">Contactpersoon *</label>
                <input type="text" id="ContactPersoon" name="ContactPersoon" required value="{{ old('ContactPersoon') }}">
                @error('ContactPersoon')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="LeverancierNummer">Leveranciernummer *</label>
                <input type="text" id="LeverancierNummer" name="LeverancierNummer" required value="{{ old('LeverancierNummer') }}">
                @error('LeverancierNummer')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="Mobiel">Mobiel *</label>
                <input type="tel" id="Mobiel" name="Mobiel" required value="{{ old('Mobiel') }}">
                @error('Mobiel')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="Opmerking">Opmerking</label>
                <textarea id="Opmerking" name="Opmerking" rows="3">{{ old('Opmerking') }}</textarea>
                @error('Opmerking')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn">Opslaan</button>
                <a href="{{ route('leverancier.index') }}" class="btn btn-secondary" style="text-decoration: none; display: inline-block;">Annuleren</a>
            </div>
        </form>
    </div>
</body>
</html>

