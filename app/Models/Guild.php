<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guild extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'guilds';

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function members(): HasMany
    {
        return $this->hasMany(GuildMember::class, 'guild_id');
    }

    public function ranks(): HasMany
    {
        return $this->hasMany(GuildRank::class, 'guild_id');
    }

    public function leaderCharacter(): BelongsTo
    {
        return $this->belongsTo(CharacterData::class, 'leader', 'id')
            ->select(['id', 'name']);
    }
}
