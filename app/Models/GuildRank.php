<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuildRank extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'guild_ranks';

    public function guild()
    {
        return $this->belongsTo(Guild::class, 'guild_id');
    }
}
