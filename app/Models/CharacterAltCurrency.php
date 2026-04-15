<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CharacterAltCurrency extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'character_alt_currency';

    public function character(): BelongsTo
    {
        return $this->belongsTo(CharacterData::class, 'character_id');
    }

    public function altCurrency(): BelongsTo
    {
        return $this->belongsTo(AlternateCurrency::class, 'currency_id');
    }
}
