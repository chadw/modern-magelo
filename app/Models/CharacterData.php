<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CharacterData extends Model
{
    protected $connection = 'eqemu';
    protected $table = 'character_data';
    public $timestamps = false;

    protected $fillable = [
        'zone_id',
        'zone_instance',
        'x',
        'y',
        'z',
        'heading',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'zoneidnumber')
            ->select('zoneidnumber', 'short_name');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(CharacterSkill::class, 'id');
    }

    public function currency(): HasOne
    {
        return $this->hasOne(CharacterCurrency::class, 'id');
    }

    public function languages(): HasMany
    {
        return $this->hasMany(CharacterLanguage::class, 'id');
    }

    public function inventory(): HasMany
    {
        return $this->hasMany(CharacterInventory::class, 'character_id');
    }

    public function sharedbank(): HasMany
    {
        return $this->hasMany(Sharedbank::class, 'account_id', 'account_id');
    }

    public function aa(): HasMany
    {
        return $this->hasMany(CharacterAa::class, 'id');
    }

    public function stats(): HasOne
    {
        return $this->hasOne(CharacterStatsRecord::class, 'character_id');
    }

    public function faction(): HasMany
    {
        return $this->hasMany(FactionValue::class, 'char_id');
    }

    public function questGlobals(): HasMany
    {
        return $this->hasMany(QuestGlobal::class, 'charid');
    }

    public function zoneFlags(): HasMany
    {
        return $this->hasMany(ZoneFlag::class, 'charID');
    }

    public function keys(): HasMany
    {
        return $this->hasMany(KeyRing::class, 'char_id');
    }

    public function corpses(): HasMany
    {
        return $this->hasMany(CharacterCorpse::class, 'charid');
    }

    public function dataBuckets(): HasMany
    {
        return $this->hasMany(DataBucket::class, 'character_id');
    }

    public function account(): HasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_id')
            ->select('id', 'sharedplat');
    }

    public function traders(): HasMany
    {
        return $this->hasMany(Trader::class, 'char_id');
    }

    public function altCurrency(): HasMany
    {
        return $this->hasMany(CharacterAltCurrency::class, 'char_id');
    }

    public function adventureStats()
    {
        return $this->hasOne(AdventureStat::class, 'player_id', 'id');
    }

    public function tribute(): HasMany
    {
        return $this->hasMany(CharacterTribute::class, 'character_id');
    }

    public function getDataBucketsByKey()
    {
        $char_id = $this->id;

        return DataBucket::where(function ($query) use ($char_id) {
            $query->where('key', 'like', $char_id . '-%')
                ->orWhere('key', 'like', '%-' . $char_id);
            });
    }

    public function hasQuestGlobal(string $name)
    {
        return $this->questGlobals->first(fn($q) => $q->name === $name);
    }
}
