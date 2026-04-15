<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactionList extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'faction_list';

    public function classMod()
    {
        return $this->hasOne(FactionListMod::class, 'faction_id');
    }

    public function raceMod()
    {
        return $this->hasOne(FactionListMod::class, 'faction_id');
    }

    public function deityMod()
    {
        return $this->hasOne(FactionListMod::class, 'faction_id');
    }
}
