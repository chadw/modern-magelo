<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AaRank extends Model
{
    use HasFactory;

    protected $connection = 'eqemu';
    protected $table = 'aa_ranks';

    public function character(): BelongsTo
    {
        return $this->belongsTo(CharacterData::class, 'id');
    }
}
