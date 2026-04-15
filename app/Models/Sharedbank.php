<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sharedbank extends Model
{
    protected $connection = 'eqemu';
    protected $primaryKey = 'slot_id';
    protected $table = 'sharedbank';

    public function character()
    {
        return $this->belongsTo(CharacterData::class, 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id')
            ->select(config('everquest.item_select_fields'));
    }

    public function aug1()
    {
        return $this->belongsTo(Item::class, 'augment_one', 'id')
            ->select(config('everquest.item_select_fields'));
    }

    public function aug2()
    {
        return $this->belongsTo(Item::class, 'augment_two', 'id')
            ->select(config('everquest.item_select_fields'));
    }

    public function aug3()
    {
        return $this->belongsTo(Item::class, 'augment_three', 'id')
            ->select(config('everquest.item_select_fields'));
    }

    public function aug4()
    {
        return $this->belongsTo(Item::class, 'augment_four', 'id')
            ->select(config('everquest.item_select_fields'));
    }

    public function aug5()
    {
        return $this->belongsTo(Item::class, 'augment_five', 'id')
            ->select(config('everquest.item_select_fields'));
    }

    public function aug6()
    {
        return $this->belongsTo(Item::class, 'augment_six', 'id')
            ->select(config('everquest.item_select_fields'));
    }
}
