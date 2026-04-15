<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CharacterCurrency extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'character_currency';

    public function character(): BelongsTo
    {
        return $this->belongsTo(CharacterData::class, 'id');
    }
}
