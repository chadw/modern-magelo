<?php

namespace App\Http\Controllers;

use App\Models\BaseData;
use App\Models\CharacterData;
use App\Models\FactionAssociation;
use App\Models\GuildMember;
use App\Models\Spell;
use App\Models\Zone;
use App\Services\CharacterAa;
use App\Services\CharacterFlags;
use App\Services\StatCalculation;
use App\Services\CharacterMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CharacterController extends Controller
{
    public $allAARanks = [];
    protected $allSpells;
    protected $allZones;

    public function __construct()
    {
        $this->allSpells = Cache::rememberForever('all_spells', function () {
            return Spell::pluck('name', 'id');
        });

        $this->allZones = Cache::rememberForever('all_zones', function () {
            return Zone::select('id', 'short_name', 'long_name')->get()->keyBy('short_name');
        });

        view()->share('allSpells', $this->allSpells);
        view()->share('allZones', $this->allZones);
    }

    public function show(CharacterData $character, CharacterAa $aa)
    {
        if (!preg_match('/^[a-zA-Z]{4,15}$/', $character->name)) {
            abort(404);
        }

        // get character and related data
        $char = CharacterData::where('name', $character->name)
            ->where ('gm', 0)
            ->with([
                'skills',
                'currency',
                'languages',
                'aa',
                'stats',
                'faction',
                'questGlobals',
                'zoneFlags',
                'keys.item',
                'corpses.zone',
                'corpses.corpseItems',
                'sharedbank',
                'account',
                'inventory',
            ])
            ->firstOrFail();

        $char->data_buckets_by_key = $char->getDataBucketsByKey()->get()->keyBy('key');
        $flags = new CharacterFlags($char);

        // get character guild
        $guild = GuildMember::where('char_id', $char->id)
            ->join('guilds', 'guild_members.guild_id', '=', 'guilds.id')
            ->select('guilds.name', 'guild_members.rank')
            ->first();

        // aas
        $aaAbilities = $aa->getAbilities($char);

        // skills
        $skills = $char->skills->pluck('value', 'skill_id')->toArray();

        // inventory
        $characterMain = new CharacterMain();
        $items = $characterMain->prepareInventory($char);
        $invIndex = $characterMain->buildInvIndex($items);

        // focus effects (from service)
        //$focusItems = $main->groupedEffects($items['gear']);

        // base stats
        $baseStats = BaseData::where('level', $char->level)
            ->where('class', $char->class)
            ->first();

        $stats = StatCalculation::calculate(collect($items['gear']));

        $factions = FactionAssociation::with([
            'factionList',
            'factionList.classMod' => fn ($q) => $q->where('mod_name', 'c' . $char->class),
            'factionList.raceMod' => fn ($q) => $q->where('mod_name', 'r' . $char->race),
            'factionList.deityMod' => fn ($q) => $q->where('mod_name', 'd' . $char->deity),
        ])
        ->get()
        ->sortBy(fn ($faction) => $faction->factionList->name ?? '')
        ->values()
        ->each(function ($faction) use ($char) {
            $v = $char->faction->firstWhere('faction_id', $faction->id);
            $faction->cmod = $faction->factionList->classMod->mod ?? 0;
            $faction->rmod = $faction->factionList->raceMod->mod ?? 0;
            $faction->dmod = $faction->factionList->deityMod->mod ?? 0;
            $faction->char_value = $v->current_value ?? 0;
            $faction->total = ($faction->factionList->base + $faction->cmod + $faction->rmod + $faction->dmod);
        });

        return view('character.show', [
            'character' => $char,
            'stats' => $stats,
            'items' => $items ?? [],
            'invIndex' => $invIndex ?? [],
            'focusItems' => $focusItems ?? [],
            'skills' => $skills,
            'aas' => collect($aaAbilities)->groupBy('TYPE'),
            'guild' => $guild,
            'factions' => $factions,
            'flags' => $flags,
        ]);
    }
}
