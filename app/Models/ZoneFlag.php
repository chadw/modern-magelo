<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoneFlag extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'zone_flags';
}
