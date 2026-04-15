<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuildMember extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'guild_members';
    protected $primaryKey = 'char_id';

    public function guild(): BelongsTo
    {
        return $this->belongsTo(Guild::class, 'guild_id');
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(CharacterData::class, 'char_id', 'id');
    }

    public function guildRank(): BelongsTo
    {
        return $this->belongsTo(GuildRank::class, 'rank', 'rank');
    }
}
