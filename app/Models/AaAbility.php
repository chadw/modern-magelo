<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AaAbility extends Model
{
    use HasFactory;

    protected $connection = 'eqemu';
    protected $table = 'aa_ability';

    public function scopeClassBit($query, $classBit)
    {
        return $query->whereRaw('classes & ? != 0', [$classBit]);
    }
}
