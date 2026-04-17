<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'items';

    public function procEffectSpell(): BelongsTo
    {
        return $this->belongsTo(Spell::class, 'proceffect', 'id');
    }

    public function wornEffectSpell(): BelongsTo
    {
        return $this->belongsTo(Spell::class, 'worneffect', 'id')
            ->select('id', 'name', 'new_icon', 'targettype');
    }

    public function focusEffectSpell(): BelongsTo
    {
        return $this->belongsTo(Spell::class, 'focuseffect', 'id');
    }

    public function clickEffectSpell(): BelongsTo
    {
        return $this->belongsTo(Spell::class, 'clickeffect', 'id');
    }

    public function scrollEffectSpell(): BelongsTo
    {
        return $this->belongsTo(Spell::class, 'scrolleffect', 'id');
    }
}
