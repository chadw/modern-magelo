<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Buyer extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'buyer';

    public function character(): BelongsTo
    {
        return $this->belongsTo(CharacterData::class, 'char_id')
            ->select(['id', 'name']);
    }
}
