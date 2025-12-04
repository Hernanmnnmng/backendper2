<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class LeverancierController extends Controller
{
    /**
     * Display overview of suppliers with product count (User Story 01 - Scenario 01)
     */
    public function index()
    {
        try {
            // Get PDO connection
            $pdo = DB::connection()->getPdo();
            
            // Call stored procedure
            $stmt = $pdo->prepare("CALL GetLeveranciersWithProductCount()");
            $stmt->execute();
            $leveranciers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Clear any additional result sets
            $stmt->closeCursor();
            
            return view('leverancier.index', compact('leveranciers'));
        } catch (\Exception $e) {
            // Fallback: Use Eloquent if stored procedure doesn't exist (for testing)
            // NOTE: Stored procedures must be installed for the assignment!
            try {
                $leveranciers = DB::table('leveranciers')
                    ->leftJoin('product_per_leverancier', 'leveranciers.id', '=', 'product_per_leverancier.LeverancierId')
                    ->select(
                        'leveranciers.id',
                        'leveranciers.naam',
                        'leveranciers.ContactPersoon',
                        'leveranciers.LeverancierNummer',
                        'leveranciers.Mobiel',
                        DB::raw('COUNT(DISTINCT product_per_leverancier.ProductId) AS AantalVerschillendeProducten')
                    )
                    ->where('leveranciers.IsActief', 1)
                    ->groupBy('leveranciers.id', 'leveranciers.naam', 'leveranciers.ContactPersoon', 'leveranciers.LeverancierNummer', 'leveranciers.Mobiel')
                    ->orderBy('AantalVerschillendeProducten', 'desc')
                    ->get()
                    ->toArray();
                
                // Convert to array format for view compatibility
                $leveranciers = array_map(function($item) {
                    return (array) $item;
                }, $leveranciers);
                
                return view('leverancier.index', compact('leveranciers'))
                    ->with('warning', 'WAARSCHUWING: Stored procedures zijn niet geïnstalleerd! Gebruik Eloquent fallback. Installeer de stored procedures voor de opdracht.');
            } catch (\Exception $fallbackError) {
                return redirect()->route('dashboard')
                    ->with('error', 'Stored procedure niet gevonden. Installeer eerst de stored procedures. Fout: ' . $e->getMessage());
            }
        }
    }

    /**
     * Display products delivered by a supplier (User Story 01 - Scenario 01 & 02)
     */
    public function showProducten($leverancierId)
    {
        try {
            // Get PDO connection
            $pdo = DB::connection()->getPdo();
            
            // Get supplier info
            $leverancier = DB::table('leveranciers')->where('id', $leverancierId)->first();
            
            if (!$leverancier) {
                return redirect()->route('leverancier.index')
                    ->with('error', 'Leverancier niet gevonden');
            }
            
            // Call stored procedure to get products
            $stmt = $pdo->prepare("CALL GetLeverancierProducten(?)");
            $stmt->bindParam(1, $leverancierId, PDO::PARAM_INT);
            $stmt->execute();
            $producten = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Clear any additional result sets
            $stmt->closeCursor();
            
            // Scenario 02: No products delivered
            if (empty($producten)) {
                return view('leverancier.producten-empty', compact('leverancier'));
            }
            
            // Scenario 01: Has products
            return view('leverancier.producten', compact('leverancier', 'producten'));
        } catch (\Exception $e) {
            // Fallback: Use Eloquent if stored procedure doesn't exist
            try {
                $leverancier = DB::table('leveranciers')->where('id', $leverancierId)->first();
                
                if (!$leverancier) {
                    return redirect()->route('leverancier.index')
                        ->with('error', 'Leverancier niet gevonden');
                }
                
                $producten = DB::table('products')
                    ->join('product_per_leverancier', 'products.id', '=', 'product_per_leverancier.ProductId')
                    ->leftJoin('magazijn', 'products.id', '=', 'magazijn.ProductId')
                    ->where('product_per_leverancier.LeverancierId', $leverancierId)
                    ->select(
                        'products.id AS ProductId',
                        'products.naam AS ProductNaam',
                        'products.barcode',
                        'products.IsActief AS ProductIsActief',
                        DB::raw('COALESCE(magazijn.AantalAanwezig, 0) AS AantalInMagazijn'),
                        DB::raw('MAX(product_per_leverancier.DatumLevering) AS LaatsteLevering')
                    )
                    ->groupBy('products.id', 'products.naam', 'products.barcode', 'products.IsActief', 'magazijn.AantalAanwezig')
                    ->orderBy('AantalInMagazijn', 'desc')
                    ->get()
                    ->toArray();
                
                $producten = array_map(function($item) {
                    return (array) $item;
                }, $producten);
                
                if (empty($producten)) {
                    return view('leverancier.producten-empty', compact('leverancier'));
                }
                
                return view('leverancier.producten', compact('leverancier', 'producten'))
                    ->with('warning', 'WAARSCHUWING: Stored procedures zijn niet geïnstalleerd!');
            } catch (\Exception $fallbackError) {
                return redirect()->route('leverancier.index')
                    ->with('error', 'Stored procedure niet gevonden. Installeer eerst de stored procedures.');
            }
        }
    }

    /**
     * Show form to add new delivery (User Story 02)
     */
    public function showAddLevering($leverancierId, $productId)
    {
        try {
            // Get PDO connection
            $pdo = DB::connection()->getPdo();
            
            // Get supplier and product info
            $leverancier = DB::table('leveranciers')->where('id', $leverancierId)->first();
            
            // Call stored procedure to get product info
            $stmt = $pdo->prepare("CALL GetProductInfo(?)");
            $stmt->bindParam(1, $productId, PDO::PARAM_INT);
            $stmt->execute();
            $productResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            if (!$leverancier || !$productResult) {
                return redirect()->route('leverancier.index')
                    ->with('error', 'Leverancier of product niet gevonden');
            }
            
            $product = (object) $productResult;
            
            return view('leverancier.add-levering', compact('leverancier', 'product'));
        } catch (\Exception $e) {
            return redirect()->route('leverancier.index')
                ->with('error', 'Er is een fout opgetreden: ' . $e->getMessage());
        }
    }

    /**
     * Store new delivery (User Story 02 - Scenario 01 & 02)
     */
    public function storeLevering(Request $request, $leverancierId, $productId)
    {
        $request->validate([
            'aantal' => 'required|integer|min:1',
            'datum_eerstvolgende_levering' => 'required|date',
        ]);

        try {
            // Get PDO connection
            $pdo = DB::connection()->getPdo();
            
            // Prepare parameters
            $aantal = $request->input('aantal');
            $datumLevering = now()->format('Y-m-d');
            $datumEerstvolgendeLevering = $request->input('datum_eerstvolgende_levering');
            
            // Call stored procedure
            $stmt = $pdo->prepare("CALL AddProductLevering(?, ?, ?, ?, ?, @result_message, @success)");
            $stmt->bindParam(1, $leverancierId, PDO::PARAM_INT);
            $stmt->bindParam(2, $productId, PDO::PARAM_INT);
            $stmt->bindParam(3, $aantal, PDO::PARAM_INT);
            $stmt->bindParam(4, $datumLevering, PDO::PARAM_STR);
            $stmt->bindParam(5, $datumEerstvolgendeLevering, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            
            // Get output parameters
            $resultStmt = $pdo->query("SELECT @result_message AS message, @success AS success");
            $result = $resultStmt->fetch(PDO::FETCH_ASSOC);
            
            // Scenario 02: Product not active (MySQL boolean is 0 or 1)
            if (!$result || $result['success'] == 0 || $result['success'] === false) {
                $leverancier = DB::table('leveranciers')->where('id', $leverancierId)->first();
                $product = DB::table('products')->where('id', $productId)->first();
                
                return view('leverancier.add-levering-error', [
                    'leverancier' => $leverancier,
                    'product' => $product,
                    'error_message' => $result['message']
                ]);
            }
            
            // Scenario 01: Success - redirect to producten overview
            return redirect()->route('leverancier.producten', $leverancierId)
                ->with('success', 'Levering succesvol toegevoegd');
        } catch (\Exception $e) {
            return redirect()->route('leverancier.index')
                ->with('error', 'Er is een fout opgetreden: ' . $e->getMessage());
        }
    }

    /**
     * Show form to create a new leverancier (CRUD)
     */
    public function create()
    {
        return view('leverancier.create');
    }

    /**
     * Store a new leverancier (CRUD)
     */
    public function store(Request $request)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'ContactPersoon' => 'required|string|max:255',
            'LeverancierNummer' => 'required|string|max:50',
            'Mobiel' => 'required|string|max:20',
            'Opmerking' => 'nullable|string|max:255',
        ]);

        try {
            $pdo = DB::connection()->getPdo();
            
            $stmt = $pdo->prepare("CALL CreateLeverancier(?, ?, ?, ?, ?, @new_id, @result_message, @success)");
            $stmt->bindParam(1, $request->naam, PDO::PARAM_STR);
            $stmt->bindParam(2, $request->ContactPersoon, PDO::PARAM_STR);
            $stmt->bindParam(3, $request->LeverancierNummer, PDO::PARAM_STR);
            $stmt->bindParam(4, $request->Mobiel, PDO::PARAM_STR);
            $stmt->bindParam(5, $request->Opmerking, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            
            $resultStmt = $pdo->query("SELECT @new_id AS new_id, @result_message AS message, @success AS success");
            $result = $resultStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result || $result['success'] == 0) {
                return redirect()->route('leverancier.create')
                    ->withInput()
                    ->with('error', $result['message'] ?? 'Fout bij aanmaken leverancier');
            }
            
            return redirect()->route('leverancier.index')
                ->with('success', $result['message']);
        } catch (\Exception $e) {
            // Fallback: Use Eloquent if stored procedure doesn't exist
            try {
                // Check if leverancier number already exists
                $exists = DB::table('leveranciers')
                    ->where('LeverancierNummer', $request->LeverancierNummer)
                    ->exists();
                
                if ($exists) {
                    return redirect()->route('leverancier.create')
                        ->withInput()
                        ->with('error', 'Leveranciernummer bestaat al');
                }
                
                DB::table('leveranciers')->insert([
                    'naam' => $request->naam,
                    'ContactPersoon' => $request->ContactPersoon,
                    'LeverancierNummer' => $request->LeverancierNummer,
                    'Mobiel' => $request->Mobiel,
                    'Opmerking' => $request->Opmerking,
                    'IsActief' => 1,
                    'DatumAangemaakt' => now(),
                    'DatumGewijzigd' => now(),
                ]);
                
                return redirect()->route('leverancier.index')
                    ->with('success', 'Leverancier succesvol aangemaakt')
                    ->with('warning', 'WAARSCHUWING: Stored procedures niet geïnstalleerd! Gebruik Eloquent fallback.');
            } catch (\Exception $fallbackError) {
                return redirect()->route('leverancier.create')
                    ->withInput()
                    ->with('error', 'Fout bij aanmaken leverancier: ' . $fallbackError->getMessage());
            }
        }
    }

    /**
     * Show form to edit a leverancier (CRUD)
     */
    public function edit($id)
    {
        $leverancier = DB::table('leveranciers')->where('id', $id)->first();
        
        if (!$leverancier) {
            return redirect()->route('leverancier.index')
                ->with('error', 'Leverancier niet gevonden');
        }
        
        return view('leverancier.edit', compact('leverancier'));
    }

    /**
     * Update a leverancier (CRUD)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'ContactPersoon' => 'required|string|max:255',
            'LeverancierNummer' => 'required|string|max:50',
            'Mobiel' => 'required|string|max:20',
            'Opmerking' => 'nullable|string|max:255',
            'IsActief' => 'boolean',
        ]);

        try {
            $pdo = DB::connection()->getPdo();
            
            $isActief = $request->has('IsActief') ? 1 : 0;
            
            $stmt = $pdo->prepare("CALL UpdateLeverancier(?, ?, ?, ?, ?, ?, ?, @result_message, @success)");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->bindParam(2, $request->naam, PDO::PARAM_STR);
            $stmt->bindParam(3, $request->ContactPersoon, PDO::PARAM_STR);
            $stmt->bindParam(4, $request->LeverancierNummer, PDO::PARAM_STR);
            $stmt->bindParam(5, $request->Mobiel, PDO::PARAM_STR);
            $stmt->bindParam(6, $request->Opmerking, PDO::PARAM_STR);
            $stmt->bindParam(7, $isActief, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            
            $resultStmt = $pdo->query("SELECT @result_message AS message, @success AS success");
            $result = $resultStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result || $result['success'] == 0) {
                return redirect()->route('leverancier.edit', $id)
                    ->withInput()
                    ->with('error', $result['message'] ?? 'Fout bij bijwerken leverancier');
            }
            
            return redirect()->route('leverancier.index')
                ->with('success', $result['message']);
        } catch (\Exception $e) {
            // Fallback: Use Eloquent if stored procedure doesn't exist
            try {
                $leverancier = DB::table('leveranciers')->where('id', $id)->first();
                
                if (!$leverancier) {
                    return redirect()->route('leverancier.index')
                        ->with('error', 'Leverancier niet gevonden');
                }
                
                // Check if new number conflicts
                if ($request->LeverancierNummer != $leverancier->LeverancierNummer) {
                    $exists = DB::table('leveranciers')
                        ->where('LeverancierNummer', $request->LeverancierNummer)
                        ->where('id', '!=', $id)
                        ->exists();
                    
                    if ($exists) {
                        return redirect()->route('leverancier.edit', $id)
                            ->withInput()
                            ->with('error', 'Leveranciernummer bestaat al');
                    }
                }
                
                $isActief = $request->has('IsActief') ? 1 : 0;
                
                DB::table('leveranciers')
                    ->where('id', $id)
                    ->update([
                        'naam' => $request->naam,
                        'ContactPersoon' => $request->ContactPersoon,
                        'LeverancierNummer' => $request->LeverancierNummer,
                        'Mobiel' => $request->Mobiel,
                        'Opmerking' => $request->Opmerking,
                        'IsActief' => $isActief,
                        'DatumGewijzigd' => now(),
                    ]);
                
                return redirect()->route('leverancier.index')
                    ->with('success', 'Leverancier succesvol bijgewerkt')
                    ->with('warning', 'WAARSCHUWING: Stored procedures niet geïnstalleerd!');
            } catch (\Exception $fallbackError) {
                return redirect()->route('leverancier.edit', $id)
                    ->withInput()
                    ->with('error', 'Fout bij bijwerken leverancier: ' . $fallbackError->getMessage());
            }
        }
    }

    /**
     * Delete a leverancier (CRUD)
     */
    public function destroy($id)
    {
        try {
            $pdo = DB::connection()->getPdo();
            
            $stmt = $pdo->prepare("CALL DeleteLeverancier(?, @result_message, @success)");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            
            $resultStmt = $pdo->query("SELECT @result_message AS message, @success AS success");
            $result = $resultStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result || $result['success'] == 0) {
                return redirect()->route('leverancier.index')
                    ->with('error', $result['message'] ?? 'Fout bij verwijderen leverancier');
            }
            
            return redirect()->route('leverancier.index')
                ->with('success', $result['message']);
        } catch (\Exception $e) {
            // Fallback: Use Eloquent if stored procedure doesn't exist
            try {
                $leverancier = DB::table('leveranciers')->where('id', $id)->first();
                
                if (!$leverancier) {
                    return redirect()->route('leverancier.index')
                        ->with('error', 'Leverancier niet gevonden');
                }
                
                // Check if has products
                $hasProducts = DB::table('product_per_leverancier')
                    ->where('LeverancierId', $id)
                    ->exists();
                
                if ($hasProducts) {
                    // Soft delete
                    DB::table('leveranciers')
                        ->where('id', $id)
                        ->update([
                            'IsActief' => 0,
                            'DatumGewijzigd' => now(),
                        ]);
                    
                    return redirect()->route('leverancier.index')
                        ->with('success', 'Leverancier gedeactiveerd (heeft nog producten)')
                        ->with('warning', 'WAARSCHUWING: Stored procedures niet geïnstalleerd!');
                } else {
                    // Hard delete
                    DB::table('leveranciers')->where('id', $id)->delete();
                    
                    return redirect()->route('leverancier.index')
                        ->with('success', 'Leverancier succesvol verwijderd')
                        ->with('warning', 'WAARSCHUWING: Stored procedures niet geïnstalleerd!');
                }
            } catch (\Exception $fallbackError) {
                return redirect()->route('leverancier.index')
                    ->with('error', 'Fout bij verwijderen leverancier: ' . $fallbackError->getMessage());
            }
        }
    }
}

