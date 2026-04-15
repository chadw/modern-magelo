<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Models\Item;
use App\Models\Spell;

class CharacterMain
{
    /**
     * groupedEffects
     *
     * @param  mixed $gear
     * @return Collection
     */
    public function groupedEffects(Collection $gear): Collection
    {
        $groupBy = [
            'Cleave',
            'Ferocity',
            'Dodge',
            'Parry / Block',
            'Other',
        ];

        $focusItems = $gear->flatMap(function ($gear) {
            $entries = collect();
            $slotName = config('everquest.slots_inv.' . $gear->slot_id) ?? 'Unknown';

            if (!empty($gear->item?->worneffect) && $gear->item->worneffect > 0 && $gear->item->wornEffectSpell) {
                $entries->push([
                    'slot_label' => $slotName,
                    'name'       => $gear->item->Name,
                    'focus'      => $gear->item->wornEffectSpell,
                ]);
            }

            foreach (range(1, 6) as $i) {
                $aug = $gear->{'aug' . $i} ?? null;
                $type = $gear->item->{'augslot' . $i . 'type'} ?? 0;

                if (!empty($aug?->worneffect) && $aug->worneffect > 0 && $aug->wornEffectSpell) {
                    $entries->push([
                        'slot_label' => $slotName . ' (Aug Type ' . $type . ')',
                        'name'       => $aug->Name,
                        'focus'      => $aug->wornEffectSpell,
                    ]);
                }
            }

            return $entries;
        })
        ->map(function ($item) {
            $item['group'] = $this->effects($item['focus']);
            return $item;
        })
        ->sortBy(fn ($item) => $item['focus']->name ?? '')
        ->values()
        ->groupBy('group');

        return collect($groupBy)->mapWithKeys(function ($group) use ($focusItems) {
            return [$group => $focusItems->get($group, collect())];
        });
    }

    /**
     * effects
     *
     * @param  mixed $spell
     * @return string
     */
    protected function effects($spell): string
    {
        $name = $spell->name ?? '';

        return match (true) {
            Str::contains($name, ['Cleave', 'Cleaving'])    => 'Cleave',
            Str::contains($name, ['Dodge'])                 => 'Dodge',
            Str::contains($name, ['Parry', 'Block'])        => 'Parry / Block',
            Str::contains($name, ['Ferocity'])              => 'Ferocity',
            default                                         => 'Other',
        };
    }

    /**
     * prepareInventory
     *
     * @param  mixed $char
     * @return Collection
     */
    public function prepareInventory($char): Collection
    {
        if (!$char->inventory) return collect();

        $items = collect([
            'gear'              => $char->inventory->whereBetween('slot_id', [
                config('everquest.slot_equipment_start'),
                config('everquest.slot_equipment_end')
            ]),
            'shared_bank'       => $char->sharedbank->filter(fn ($inv) =>
                $inv->slot_id >= config('everquest.slot_sharedbank_start') &&
                $inv->slot_id <= config('everquest.slot_sharedbank_end')
            ),
            'shared_bank_items' => $char->sharedbank->filter(fn ($inv) =>
                $inv->slot_id >= config('everquest.slot_sharedbank_bag_start') &&
                $inv->slot_id <= config('everquest.slot_sharedbank_bag_end')
            ),
            'bags'              => $char->inventory->filter(fn ($inv) =>
                $inv->slot_id >= config('everquest.slot_inventory_start') &&
                $inv->slot_id <= config('everquest.slot_inventory_end')
            ),
            'bag_items'         => $char->inventory->filter(fn ($inv) =>
                $inv->slot_id >= config('everquest.slot_inventory_bags_start') &&
                $inv->slot_id <= config('everquest.slot_inventory_bags_end')
            ),
            'bank'              => $char->inventory->filter(fn ($inv) =>
                $inv->slot_id >= config('everquest.slot_bank_start') &&
                $inv->slot_id <= config('everquest.slot_bank_end')
            ),
            'bank_items'        => $char->inventory->filter(fn ($inv) =>
                $inv->slot_id >= config('everquest.slot_bank_bags_start') &&
                $inv->slot_id <= config('everquest.slot_bank_bags_end')
            ),
        ]);

        // bulk fetch items and spells
        $augFieldMap = [
            'augment_one'   => 'aug1',
            'augment_two'   => 'aug2',
            'augment_three' => 'aug3',
            'augment_four'  => 'aug4',
            'augment_five'  => 'aug5',
            'augment_six'   => 'aug6',
        ];

        $allItemIds = [];
        foreach ($items as $group) {
            foreach ($group as $inv) {
                if (!empty($inv->item_id)) $allItemIds[] = (int) $inv->item_id;
                foreach ($augFieldMap as $field => $rel) {
                    if (!empty($inv->$field)) $allItemIds[] = (int) $inv->$field;
                }
            }
        }

        $allItemIds = array_values(array_unique(array_filter($allItemIds)));

        $allItems = !empty($allItemIds)
            ? Item::select(config('everquest.item_select_fields'))->whereIn('id', $allItemIds)->get()->keyBy('id')
            : collect();

        $spellIds = $allItems->pluck('worneffect')->filter()->unique()->values()->all();
        $allSpellsForWorn = !empty($spellIds)
            ? Spell::select('id', 'name', 'new_icon')->whereIn('id', $spellIds)->get()->keyBy('id')
            : collect();

        foreach ($allItems as $item) {
            $item->setRelation('wornEffectSpell', $allSpellsForWorn->get($item->worneffect));
        }

        foreach ($items as $group) {
            foreach ($group as $inv) {
                $inv->setRelation('item', $allItems->get($inv->item_id));
                foreach ($augFieldMap as $field => $rel) {
                    $inv->setRelation($rel, !empty($inv->$field) ? $allItems->get($inv->$field) : null);
                }
            }
        }

        return $items;
    }

    /**
     * Build inventory index array used for inventory filter.
     *
     * @param Collection $items
     * @return array
     */
    public function buildInvIndex(Collection $items): array
    {
        $invIndex = [];
        $augKeys = ['aug1','aug2','aug3','aug4','aug5','aug6'];

        if (!empty($items)) {
            foreach ($items['gear'] as $inv) {
                if ($inv->item) {
                    $invIndex[] = [
                        'id' => $inv->item->id,
                        'name' => $inv->item->Name,
                        'loc' => 'gear',
                        'bagSlot' => null,
                        'parentId' => null
                    ];
                    foreach ($augKeys as $a) {
                        if ($inv->$a) {
                            $invIndex[] = [
                                'id' => $inv->$a->id,
                                'name' => $inv->$a->Name,
                                'loc' => 'gear',
                                'bagSlot' => null,
                                'parentId' => $inv->item->id
                            ];
                        }
                    }
                }
            }

            foreach ($items['bags'] as $inv) {
                if ($inv->item) {
                    $invIndex[] = [
                        'id' => $inv->item->id,
                        'name' => $inv->item->Name,
                        'loc' => 'bag',
                        'bagSlot' => null,
                        'parentId' => null
                    ];
                }
            }

            foreach ($items['bag_items'] as $inv) {
                if ($inv->item) {
                    $parentBag = config('everquest.slot_inventory_start') + intdiv($inv->slot_id - config('everquest.slot_inventory_bags_start'), config('everquest.max_bag_slots'));
                    $invIndex[] = [
                        'id' => $inv->item->id,
                        'name' => $inv->item->Name,
                        'loc' => 'bag',
                        'bagSlot' => $parentBag,
                        'parentId' => null
                    ];
                    foreach ($augKeys as $a) {
                        if ($inv->$a) {
                            $invIndex[] = [
                                'id' => $inv->$a->id,
                                'name' => $inv->$a->Name,
                                'loc' => 'bag',
                                'bagSlot' => $parentBag,
                                'parentId' => $inv->item->id
                            ];
                        }
                    }
                }
            }

            foreach ($items['bank'] as $inv) {
                if ($inv->item) {
                    $invIndex[] = [
                        'id' => $inv->item->id,
                        'name' => $inv->item->Name,
                        'loc' => 'bank',
                        'bagSlot' => null,
                        'parentId' => null
                    ];
                }
            }

            foreach ($items['bank_items'] as $inv) {
                if ($inv->item) {
                    $parentBag = config('everquest.slot_bank_start') + intdiv($inv->slot_id - config('everquest.slot_bank_bags_start'), config('everquest.max_bag_slots'));
                    $invIndex[] = [
                        'id' => $inv->item->id,
                        'name' => $inv->item->Name,
                        'loc' => 'bank',
                        'bagSlot' => $parentBag,
                        'parentId' => null
                    ];
                    foreach ($augKeys as $a) {
                        if ($inv->$a) {
                            $invIndex[] = [
                                'id' => $inv->$a->id,
                                'name' => $inv->$a->Name,
                                'loc' => 'bank',
                                'bagSlot' => $parentBag,
                                'parentId' => $inv->item->id
                            ];
                        }
                    }
                }
            }

            foreach ($items['shared_bank'] as $inv) {
                if ($inv->item) {
                    $invIndex[] = [
                        'id' => $inv->item->id,
                        'name' => $inv->item->Name,
                        'loc' => 'sharedbank',
                        'bagSlot' => null,
                        'parentId' => null
                    ];
                }
            }

            foreach ($items['shared_bank_items'] as $inv) {
                if ($inv->item) {
                    $parentBag = config('everquest.slot_sharedbank_start') + intdiv($inv->slot_id - config('everquest.slot_sharedbank_bag_start'), config('everquest.max_bag_slots'));
                    $invIndex[] = [
                        'id' => $inv->item->id,
                        'name' => $inv->item->Name,
                        'loc' => 'sharedbank',
                        'bagSlot' => $parentBag,
                        'parentId' => null
                    ];
                    foreach ($augKeys as $a) {
                        if ($inv->$a) {
                            $invIndex[] = [
                                'id' => $inv->$a->id,
                                'name' => $inv->$a->Name,
                                'loc' => 'sharedbank',
                                'bagSlot' => $parentBag,
                                'parentId' => $inv->item->id
                            ];
                        }
                    }
                }
            }
        }

        return $invIndex;
    }
}
