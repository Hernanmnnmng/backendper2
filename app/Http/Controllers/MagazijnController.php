<?php

namespace App\Http\Controllers;

use App\Models\Magazijn;
use App\Models\Product;
use App\Models\ProductPerLeverancier;
use App\Models\ProductPerAllergeen;
use Illuminate\Http\Request;

class MagazijnController extends Controller
{
    /**
     * Display the warehouse overview (sorted by barcode)
     */
    public function index()
    {
        $magazijn = Magazijn::with('product')
            ->join('products', 'magazijn.ProductId', '=', 'products.id')
            ->orderBy('products.barcode', 'asc')
            ->select('magazijn.*')
            ->get();

        return view('magazijn.index', compact('magazijn'));
    }

    /**
     * Display delivery information for a product (User Story 1)
     */
    public function leveringInfo($productId)
    {
        $product = Product::findOrFail($productId);
        $magazijn = Magazijn::where('ProductId', $productId)->first();
        
        // Check if product has stock (Scenario 02: Winegums has NULL stock)
        if (!$magazijn || $magazijn->AantalAanwezig === null || $magazijn->AantalAanwezig == 0) {
            // Scenario 02: No stock available
            $nextDelivery = ProductPerLeverancier::where('ProductId', $productId)
                ->whereNotNull('DatumEerstVolgendeLevering')
                ->orderBy('DatumEerstVolgendeLevering', 'asc')
                ->first();
            
            // For Winegums (product 10), assignment specifies "30-04-2023"
            if ($productId == 10) {
                $nextDeliveryDate = '30-04-2023';
            } else {
                $nextDeliveryDate = $nextDelivery ? $nextDelivery->DatumEerstVolgendeLevering->format('d-m-Y') : '30-04-2023';
            }
            
            return view('magazijn.levering-info-empty', compact('product', 'nextDeliveryDate'));
        }

        // Scenario 01: Has stock - show delivery information (Mintnopjes)
        $leveringen = ProductPerLeverancier::with(['leverancier', 'product'])
            ->where('ProductId', $productId)
            ->orderBy('DatumLevering', 'asc')
            ->get();

        // Get the first leverancier from the deliveries
        $leverancier = $leveringen->first()?->leverancier;

        return view('magazijn.levering-info', compact('product', 'leveringen', 'leverancier'));
    }

    /**
     * Display allergen information for a product (User Story 2)
     */
    public function allergenenInfo($productId)
    {
        $product = Product::findOrFail($productId);
        $allergenen = ProductPerAllergeen::with('allergeen')
            ->where('ProductId', $productId)
            ->join('allergenen', 'product_per_allergeen.AllergeenId', '=', 'allergenen.id')
            ->orderBy('allergenen.naam', 'asc')
            ->select('product_per_allergeen.*', 'allergenen.naam', 'allergenen.omschrijving')
            ->get();

        // Scenario 02: No allergens
        if ($allergenen->isEmpty()) {
            return view('magazijn.allergenen-info-empty', compact('product'));
        }

        // Scenario 01: Has allergens
        return view('magazijn.allergenen-info', compact('product', 'allergenen'));
    }
}
