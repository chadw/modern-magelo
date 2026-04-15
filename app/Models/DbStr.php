<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DbStr extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'db_str';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    public function getSpellDescription(Spell $spell): string
    {
        // #1 Base for effect id 1
        // $1 Limit for effect id 1
        // @1 Max for effect id 1
        // %z (# ticks)
        $desc = $this->value ?? '';

        $desc = str_replace('%z', '(' . $spell->buffduration . ' ticks)', $desc);

        $desc = preg_replace_callback('/#(\d+)/', function ($matches) use ($spell) {
            return abs($spell->{'effect_base_value' . $matches[1]}) ?? '';
        }, $desc);

        $desc = preg_replace_callback('/\$(\d+)/', function ($matches) use ($spell) {
            return abs($spell->{'effect_limit_value' . $matches[1]}) ?? '';
        }, $desc);

        $desc = preg_replace_callback('/@(\d+)/', function ($matches) use ($spell) {
            return abs($spell->{'max' . $matches[1]}) ?? '';
        }, $desc);

        return $desc;
    }
}
