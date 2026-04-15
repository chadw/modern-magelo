<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlternateCurrency extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'alternate_currency';

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id', 'id')
            ->select('id', 'Name', 'icon');
    }

    public static function allAltCurrency(): Collection
    {
        return Cache::remember('alt_currency', now()->addMonth(), function () {
            return self::with('item:id,Name,icon')->get();
        });
    }
}
