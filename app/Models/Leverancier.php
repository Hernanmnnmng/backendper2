<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Leverancier extends Model
{
    protected $fillable = [
        'naam',
        'ContactPersoon',
        'LeverancierNummer',
        'Mobiel',
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

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_per_leverancier', 'LeverancierId', 'ProductId')
            ->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering');
    }

    public function productPerLeverancier(): HasMany
    {
        return $this->hasMany(ProductPerLeverancier::class, 'LeverancierId');
    }
}
