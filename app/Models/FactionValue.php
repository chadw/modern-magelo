<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class FactionValue extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'faction_values';

    protected function standing(): Attribute
    {
        return Attribute::get(fn() => factionValue($this->current_value));
    }
}
