<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'quest_globals';
}
