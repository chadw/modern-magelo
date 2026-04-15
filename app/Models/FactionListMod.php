<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactionListMod extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'faction_list_mod';

    public function faction()
    {
        return $this->belongsTo(FactionList::class, 'faction_id');
    }
}
