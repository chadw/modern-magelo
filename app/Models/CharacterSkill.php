<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterSkill extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'character_skills';

    public function character()
    {
        return $this->belongsTo(CharacterData::class, 'id');
    }
}
