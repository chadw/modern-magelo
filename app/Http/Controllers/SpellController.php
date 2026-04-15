<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Spell;
use Illuminate\Support\Facades\Cache;

class SpellController extends Controller
{
    public function popup(Spell $spell)
    {
        $effectsOnly = request()->boolean('effects-only');

        $spell = Spell::where('id', $spell->id)->firstOrFail();

        $allSpells = Cache::remember('all_spells', now()->addWeek(), function () {
            return Spell::pluck('name', 'id');
        });

        $allZones = Cache::remember('all_zones', now()->addMonth(), function () {
            return Zone::select('id', 'short_name', 'long_name')->get()->keyBy('short_name');
        });

        return response()->json([
            'html' => view('partials.spells.popup', [
                'spell' => $spell,
                'allSpells' => $allSpells,
                'allZones' => $allZones,
                'effectsOnly' => $effectsOnly,
            ])->render()
        ]);
    }
}
