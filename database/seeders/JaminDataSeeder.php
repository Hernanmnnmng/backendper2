<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Allergeen;
use App\Models\Leverancier;
use App\Models\Magazijn;
use App\Models\ProductPerAllergeen;
use App\Models\ProductPerLeverancier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JaminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Create Products
        $products = [
            ['id' => 1, 'naam' => 'Mintnopjes', 'barcode' => '8719587231278'],
            ['id' => 2, 'naam' => 'Schoolkrijt', 'barcode' => '8719587326713'],
            ['id' => 3, 'naam' => 'Honingdrop', 'barcode' => '8719587327836'],
            ['id' => 4, 'naam' => 'Zure Beren', 'barcode' => '8719587321441'],
            ['id' => 5, 'naam' => 'Cola Flesjes', 'barcode' => '8719587321237'],
            ['id' => 6, 'naam' => 'Turtles', 'barcode' => '8719587322245'],
            ['id' => 7, 'naam' => 'Witte Muizen', 'barcode' => '8719587328256'],
            ['id' => 8, 'naam' => 'Reuzen Slangen', 'barcode' => '8719587325641'],
            ['id' => 9, 'naam' => 'Zoute Rijen', 'barcode' => '8719587322739'],
            ['id' => 10, 'naam' => 'Winegums', 'barcode' => '8719587327527'],
            ['id' => 11, 'naam' => 'Drop Munten', 'barcode' => '8719587322345'],
            ['id' => 12, 'naam' => 'Kruis Drop', 'barcode' => '8719587322265'],
            ['id' => 13, 'naam' => 'Zoute Ruitjes', 'barcode' => '8719587323256'],
        ];

        foreach ($products as $product) {
            Product::create([
                'id' => $product['id'],
                'naam' => $product['naam'],
                'barcode' => $product['barcode'],
                'IsActief' => true,
                'DatumAangemaakt' => $now,
                'DatumGewijzigd' => $now,
            ]);
        }

        // Create Allergenen
        $allergenen = [
            ['id' => 1, 'naam' => 'Gluten', 'omschrijving' => 'Dit product bevat gluten'],
            ['id' => 2, 'naam' => 'Gelatine', 'omschrijving' => 'Dit product bevat gelatine'],
            ['id' => 3, 'naam' => 'AZO-Kleurstof', 'omschrijving' => 'Dit product bevat AZO-kleurstoffen'],
            ['id' => 4, 'naam' => 'Lactose', 'omschrijving' => 'Dit product bevat lactose'],
            ['id' => 5, 'naam' => 'Soja', 'omschrijving' => 'Dit product bevat soja'],
        ];

        foreach ($allergenen as $allergeen) {
            Allergeen::create([
                'id' => $allergeen['id'],
                'naam' => $allergeen['naam'],
                'omschrijving' => $allergeen['omschrijving'],
                'IsActief' => true,
                'DatumAangemaakt' => $now,
                'DatumGewijzigd' => $now,
            ]);
        }

        // Create Leveranciers
        $leveranciers = [
            ['id' => 1, 'naam' => 'Venco', 'ContactPersoon' => 'Bert van Linge', 'LeverancierNummer' => 'L1029384719', 'Mobiel' => '06-28493827'],
            ['id' => 2, 'naam' => 'Astra Sweets', 'ContactPersoon' => 'Jasper del Monte', 'LeverancierNummer' => 'L1029284315', 'Mobiel' => '06-39398734'],
            ['id' => 3, 'naam' => 'Haribo', 'ContactPersoon' => 'Sven Stalman', 'LeverancierNummer' => 'L1029324748', 'Mobiel' => '06-24383291'],
            ['id' => 4, 'naam' => 'Basset', 'ContactPersoon' => 'Joyce Stelterberg', 'LeverancierNummer' => 'L1023845773', 'Mobiel' => '06-48293823'],
            ['id' => 5, 'naam' => 'De Bron', 'ContactPersoon' => 'Remco Veenstra', 'LeverancierNummer' => 'L1023857736', 'Mobiel' => '06-34291234'],
        ];

        foreach ($leveranciers as $leverancier) {
            Leverancier::create([
                'id' => $leverancier['id'],
                'naam' => $leverancier['naam'],
                'ContactPersoon' => $leverancier['ContactPersoon'],
                'LeverancierNummer' => $leverancier['LeverancierNummer'],
                'Mobiel' => $leverancier['Mobiel'],
                'IsActief' => true,
                'DatumAangemaakt' => $now,
                'DatumGewijzigd' => $now,
            ]);
        }

        // Create Magazijn
        $magazijn = [
            ['id' => 1, 'ProductId' => 1, 'VerpakkingsEenheid' => 5, 'AantalAanwezig' => 453],
            ['id' => 2, 'ProductId' => 2, 'VerpakkingsEenheid' => 2.5, 'AantalAanwezig' => 400],
            ['id' => 3, 'ProductId' => 3, 'VerpakkingsEenheid' => 5, 'AantalAanwezig' => 1],
            ['id' => 4, 'ProductId' => 4, 'VerpakkingsEenheid' => 1, 'AantalAanwezig' => 800],
            ['id' => 5, 'ProductId' => 5, 'VerpakkingsEenheid' => 3, 'AantalAanwezig' => 234],
            ['id' => 6, 'ProductId' => 6, 'VerpakkingsEenheid' => 2, 'AantalAanwezig' => 345],
            ['id' => 7, 'ProductId' => 7, 'VerpakkingsEenheid' => 1, 'AantalAanwezig' => 795],
            ['id' => 8, 'ProductId' => 8, 'VerpakkingsEenheid' => 10, 'AantalAanwezig' => 233],
            ['id' => 9, 'ProductId' => 9, 'VerpakkingsEenheid' => 2.5, 'AantalAanwezig' => 123],
            ['id' => 10, 'ProductId' => 10, 'VerpakkingsEenheid' => 3, 'AantalAanwezig' => null],
            ['id' => 11, 'ProductId' => 11, 'VerpakkingsEenheid' => 2, 'AantalAanwezig' => 367],
            ['id' => 12, 'ProductId' => 12, 'VerpakkingsEenheid' => 1, 'AantalAanwezig' => 467],
            ['id' => 13, 'ProductId' => 13, 'VerpakkingsEenheid' => 5, 'AantalAanwezig' => 20],
        ];

        foreach ($magazijn as $item) {
            Magazijn::create([
                'id' => $item['id'],
                'ProductId' => $item['ProductId'],
                'VerpakkingsEenheid' => $item['VerpakkingsEenheid'],
                'AantalAanwezig' => $item['AantalAanwezig'],
                'IsActief' => true,
                'DatumAangemaakt' => $now,
                'DatumGewijzigd' => $now,
            ]);
        }

        // Create ProductPerAllergeen
        $productPerAllergeen = [
            ['id' => 1, 'ProductId' => 1, 'AllergeenId' => 2],
            ['id' => 2, 'ProductId' => 1, 'AllergeenId' => 1],
            ['id' => 3, 'ProductId' => 1, 'AllergeenId' => 3],
            ['id' => 4, 'ProductId' => 3, 'AllergeenId' => 4],
            ['id' => 5, 'ProductId' => 6, 'AllergeenId' => 5],
            ['id' => 6, 'ProductId' => 9, 'AllergeenId' => 2],
            ['id' => 7, 'ProductId' => 9, 'AllergeenId' => 5],
            ['id' => 8, 'ProductId' => 10, 'AllergeenId' => 2],
            ['id' => 9, 'ProductId' => 12, 'AllergeenId' => 4],
            ['id' => 10, 'ProductId' => 13, 'AllergeenId' => 1],
            ['id' => 11, 'ProductId' => 13, 'AllergeenId' => 4],
            ['id' => 12, 'ProductId' => 13, 'AllergeenId' => 5],
        ];

        foreach ($productPerAllergeen as $item) {
            ProductPerAllergeen::create([
                'id' => $item['id'],
                'ProductId' => $item['ProductId'],
                'AllergeenId' => $item['AllergeenId'],
                'IsActief' => true,
                'DatumAangemaakt' => $now,
                'DatumGewijzigd' => $now,
            ]);
        }

        // Create ProductPerLeverancier
        $productPerLeverancier = [
            ['id' => 1, 'LeverancierId' => 1, 'ProductId' => 1, 'DatumLevering' => '2024-10-09', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => '2024-10-16'],
            ['id' => 2, 'LeverancierId' => 1, 'ProductId' => 1, 'DatumLevering' => '2024-10-18', 'Aantal' => 21, 'DatumEerstVolgendeLevering' => '2024-10-25'],
            ['id' => 3, 'LeverancierId' => 1, 'ProductId' => 2, 'DatumLevering' => '2024-10-09', 'Aantal' => 12, 'DatumEerstVolgendeLevering' => '2024-10-16'],
            ['id' => 4, 'LeverancierId' => 1, 'ProductId' => 3, 'DatumLevering' => '2024-10-10', 'Aantal' => 11, 'DatumEerstVolgendeLevering' => '2024-10-17'],
            ['id' => 5, 'LeverancierId' => 2, 'ProductId' => 4, 'DatumLevering' => '2024-10-14', 'Aantal' => 16, 'DatumEerstVolgendeLevering' => '2024-10-21'],
            ['id' => 6, 'LeverancierId' => 2, 'ProductId' => 4, 'DatumLevering' => '2024-10-21', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => '2024-10-28'],
            ['id' => 7, 'LeverancierId' => 2, 'ProductId' => 5, 'DatumLevering' => '2024-10-14', 'Aantal' => 45, 'DatumEerstVolgendeLevering' => '2024-10-21'],
            ['id' => 8, 'LeverancierId' => 2, 'ProductId' => 6, 'DatumLevering' => '2024-10-14', 'Aantal' => 30, 'DatumEerstVolgendeLevering' => '2024-10-21'],
            ['id' => 9, 'LeverancierId' => 3, 'ProductId' => 7, 'DatumLevering' => '2024-10-12', 'Aantal' => 12, 'DatumEerstVolgendeLevering' => '2024-10-19'],
            ['id' => 10, 'LeverancierId' => 3, 'ProductId' => 7, 'DatumLevering' => '2024-10-19', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => '2024-10-26'],
            ['id' => 11, 'LeverancierId' => 3, 'ProductId' => 8, 'DatumLevering' => '2024-10-10', 'Aantal' => 12, 'DatumEerstVolgendeLevering' => '2024-10-17'],
            ['id' => 12, 'LeverancierId' => 3, 'ProductId' => 9, 'DatumLevering' => '2024-10-11', 'Aantal' => 1, 'DatumEerstVolgendeLevering' => '2024-10-18'],
            ['id' => 13, 'LeverancierId' => 4, 'ProductId' => 10, 'DatumLevering' => '2024-10-16', 'Aantal' => 24, 'DatumEerstVolgendeLevering' => '2024-10-30'],
            ['id' => 14, 'LeverancierId' => 5, 'ProductId' => 11, 'DatumLevering' => '2024-10-10', 'Aantal' => 47, 'DatumEerstVolgendeLevering' => '2024-10-17'],
            ['id' => 15, 'LeverancierId' => 5, 'ProductId' => 11, 'DatumLevering' => '2024-10-19', 'Aantal' => 60, 'DatumEerstVolgendeLevering' => '2024-10-26'],
            ['id' => 16, 'LeverancierId' => 5, 'ProductId' => 12, 'DatumLevering' => '2024-10-11', 'Aantal' => 45, 'DatumEerstVolgendeLevering' => null],
            ['id' => 17, 'LeverancierId' => 5, 'ProductId' => 13, 'DatumLevering' => '2024-10-12', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => null],
        ];

        foreach ($productPerLeverancier as $item) {
            ProductPerLeverancier::create([
                'id' => $item['id'],
                'LeverancierId' => $item['LeverancierId'],
                'ProductId' => $item['ProductId'],
                'DatumLevering' => $item['DatumLevering'],
                'Aantal' => $item['Aantal'],
                'DatumEerstVolgendeLevering' => $item['DatumEerstVolgendeLevering'],
                'IsActief' => true,
                'DatumAangemaakt' => $now,
                'DatumGewijzigd' => $now,
            ]);
        }
    }
}
