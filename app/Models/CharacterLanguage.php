<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterLanguage extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'character_languages';

    public function character()
    {
        return $this->belongsTo(CharacterData::class, 'id');
    }
}
