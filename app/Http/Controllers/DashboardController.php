<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use App\Models\Magazijn;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics
     */
    public function index()
    {
        // Get statistics
        $totalLeveranciers = Leverancier::where('IsActief', true)->count();
        $totalProducts = Product::where('IsActief', true)->count();
        $totalMagazijnItems = Magazijn::where('IsActief', true)->count();
        
        // Get low stock items (AantalAanwezig < 100 or null)
        $lowStockItems = Magazijn::with('product')
            ->where('IsActief', true)
            ->where(function($query) {
                $query->where('AantalAanwezig', '<', 100)
                      ->orWhereNull('AantalAanwezig');
            })
            ->join('products', 'magazijn.ProductId', '=', 'products.id')
            ->select('magazijn.*', 'products.naam', 'products.barcode')
            ->orderBy('AantalAanwezig', 'asc')
            ->limit(5)
            ->get();
        
        // Get total stock value (sum of all AantalAanwezig)
        $totalStock = Magazijn::where('IsActief', true)
            ->whereNotNull('AantalAanwezig')
            ->sum('AantalAanwezig');
        
        // Get products with no stock
        $noStockCount = Magazijn::where('IsActief', true)
            ->where(function($query) {
                $query->whereNull('AantalAanwezig')
                      ->orWhere('AantalAanwezig', 0);
            })
            ->count();
        
        // Get recent leveranciers (last 5)
        $recentLeveranciers = Leverancier::where('IsActief', true)
            ->orderBy('DatumAangemaakt', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalLeveranciers',
            'totalProducts',
            'totalMagazijnItems',
            'lowStockItems',
            'totalStock',
            'noStockCount',
            'recentLeveranciers'
        ));
    }
}

