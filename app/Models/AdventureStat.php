<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdventureStat extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'adventure_stats';
}
