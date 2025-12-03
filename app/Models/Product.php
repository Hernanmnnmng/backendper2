<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'naam',
        'barcode',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function magazijn(): HasMany
    {
        return $this->hasMany(Magazijn::class, 'ProductId');
    }

    public function allergenen(): BelongsToMany
    {
        return $this->belongsToMany(Allergeen::class, 'product_per_allergeen', 'ProductId', 'AllergeenId');
    }

    public function leveranciers(): BelongsToMany
    {
        return $this->belongsToMany(Leverancier::class, 'product_per_leverancier', 'ProductId', 'LeverancierId')
            ->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering');
    }

    public function productPerLeverancier(): HasMany
    {
        return $this->hasMany(ProductPerLeverancier::class, 'ProductId');
    }
}
