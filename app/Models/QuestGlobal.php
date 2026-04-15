<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestGlobal extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'quest_globals';
}
