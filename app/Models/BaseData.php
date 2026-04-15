<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseData extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'base_data';
}
