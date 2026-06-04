<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TraderAudit extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'trader_audit';

    protected $casts = [
        'time' => 'datetime',
    ];

    public function sellerCharacter(): BelongsTo
    {
        return $this->belongsTo(CharacterData::class, 'seller', 'name')
            ->select('id', 'name');
    }

    public function buyerCharacter(): BelongsTo
    {
        return $this->belongsTo(CharacterData::class, 'buyer', 'name')
            ->select('id', 'name');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'itemname', 'Name')
            ->select('id', 'Name', 'icon');
    }
}
