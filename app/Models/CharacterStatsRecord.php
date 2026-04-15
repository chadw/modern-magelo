<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterStatsRecord extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'character_stats_record';

    public function character()
    {
        return $this->belongsTo(CharacterData::class, 'id');
    }
}
