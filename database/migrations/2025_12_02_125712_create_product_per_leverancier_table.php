<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_per_leverancier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('LeverancierId')->constrained('leveranciers')->onDelete('cascade');
            $table->foreignId('ProductId')->constrained('products')->onDelete('cascade');
            $table->date('DatumLevering');
            $table->integer('Aantal');
            $table->date('DatumEerstVolgendeLevering')->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 250)->nullable();
            $table->dateTime('DatumAangemaakt')->useCurrent();
            $table->dateTime('DatumGewijzigd')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_per_leverancier');
    }
};
