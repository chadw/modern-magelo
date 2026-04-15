<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterCorpseItem extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'character_corpse_items';

    public function corpse()
    {
        return $this->belongsTo(CharacterCorpse::class, 'corpse_id');
    }
}
