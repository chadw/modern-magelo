<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KeyRing extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'keyring';

    public function item(): HasOne
    {
        return $this->hasOne(Item::class, 'id', 'item_id')
            ->select('id', 'Name', 'icon');
    }
}
