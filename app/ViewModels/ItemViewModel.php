<?php
namespace App\ViewModels;

use App\Models\Item;
use Illuminate\Support\Collection;

class ItemViewModel
{
    public function __construct(public Item $item)
    {
        $relations = [];

        if ($item->proceffect > 0 && $item->proceffect < 65535) {
            $relations[] = 'procEffectSpell';
        }

        if ($item->worneffect > 0 && $item->worneffect < 65535) {
            $relations[] = 'wornEffectSpell';
        }

        if ($item->focuseffect > 0 && $item->focuseffect < 65535) {
            $relations[] = 'focusEffectSpell';
        }

        if ($item->clickeffect > 0 && $item->clickeffect < 65535) {
            $relations[] = 'clickEffectSpell';
        }

        if ($item->scrolleffect > 0 && $item->scrolleffect < 65535) {
            $relations[] = 'scrollEffectSpell';
        }

        if (!empty($relations)) {
            $this->item->load($relations);
        }
    }

    public function withEffects()
    {
        $i = $this->item;

        $i->custom_proceffect = $i->relationLoaded('procEffectSpell') && $i->procEffectSpell
            ? $i->procEffectSpell->name
            : null;

        $i->custom_worneffect = $i->relationLoaded('wornEffectSpell') && $i->wornEffectSpell
            ? $i->wornEffectSpell->name
            : null;

        $i->custom_focuseffect = $i->relationLoaded('focusEffectSpell') && $i->focusEffectSpell
            ? $i->focusEffectSpell->name
            : null;

        $i->custom_clickeffect = $i->relationLoaded('clickEffectSpell') && $i->clickEffectSpell
            ? $i->clickEffectSpell->name
            : null;

        $i->custom_scrolleffect = $i->relationLoaded('scrollEffectSpell') && $i->scrollEffectSpell
            ? $i->scrollEffectSpell->name
            : null;

        return $this;
    }
}
