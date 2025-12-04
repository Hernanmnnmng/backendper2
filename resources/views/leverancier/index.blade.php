<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Leveranciers</title>
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
        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px 0 rgba(102, 126, 234, 0.4);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(102, 126, 234, 0.6);
        }
        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
            box-shadow: 0 2px 8px 0 rgba(0, 0, 0, 0.1);
        }
        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px 0 rgba(102, 126, 234, 0.3);
        }
        .button-group {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-top: 24px;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('layouts.navigation')
    <div class="container">
        <h1 class="text-3xl font-bold mb-4">Overzicht Leveranciers</h1>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('warning'))
            <div class="alert" style="background-color: #fff3cd; border-color: #ffc107; color: #856404;">
                {{ session('warning') }}
            </div>
        @endif
        
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Contactpersoon</th>
                    <th>Leveranciernummer</th>
                    <th>Mobiel</th>
                    <th>Aantal verschillende producten</th>
                    <th>Toon producten</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leveranciers as $leverancier)
                    <tr>
                        <td>{{ $leverancier['naam'] }}</td>
                        <td>{{ $leverancier['ContactPersoon'] }}</td>
                        <td>{{ $leverancier['LeverancierNummer'] }}</td>
                        <td>{{ $leverancier['Mobiel'] }}</td>
                        <td>{{ $leverancier['AantalVerschillendeProducten'] }}</td>
                        <td>
                            <a href="{{ route('leverancier.producten', $leverancier['id']) }}" class="icon-link" title="Toon producten">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('leverancier.edit', $leverancier['id']) }}" class="icon-link" title="Bewerken" style="color: #007bff;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('leverancier.destroy', $leverancier['id']) }}" method="POST" style="display: inline;" onsubmit="return confirm('Weet je zeker dat je deze leverancier wilt verwijderen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon-link" title="Verwijderen" style="color: #dc3545; border: none; background: none; cursor: pointer; padding: 0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Geen leveranciers gevonden</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="button-group">
            <a href="{{ route('leverancier.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nieuwe Leverancier
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Terug naar dashboard
            </a>
        </div>
    </div>
</body>
</html>

