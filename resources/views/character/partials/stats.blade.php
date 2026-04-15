<div class="w-32 xl:w-40 font-mono text-sm shrink-0">
    <div class="flex justify-between">
        <span class="text-base-content/60">HP</span>
        <span class="font-semibold">{{ $character->stats->hp ?? 0 }}</span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">MP</span>
        <span class="font-semibold">{{ $character->stats->mana ?? 0 }}</span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">EN</span>
        <span class="font-semibold">{{ $character->stats->endurance ?? 0 }}</span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">AC</span>
        <span class="font-semibold">{{ $character->stats->ac ?? 0 }}</span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">ATK</span>
        <span class="font-semibold">{{ $character->stats->attack ?? 0 }}</span>
    </div>

    <div class="border-t border-base-content/10 my-2"></div>

    <div class="flex justify-between">
        <span class="text-base-content/60">STR</span>
        <span>
            <span class="text-green-400">{{ $character->stats->strength ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_strength ?? 0 }}</span>
        </span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">STA</span>
        <span>
            <span class="text-green-400">{{ $character->stats->stamina ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_stamina ?? 0 }}</span>
        </span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">AGI</span>
        <span>
            <span class="text-green-400">{{ $character->stats->agility ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_agility ?? 0 }}</span>
        </span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">DEX</span>
        <span>
            <span class="text-green-400">{{ $character->stats->dexterity ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_dexterity ?? 0 }}</span>
        </span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">WIS</span>
        <span>
            <span class="text-green-400">{{ $character->stats->wisdom ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_wisdom ?? 0 }}</span>
        </span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">INT</span>
        <span>
            <span class="text-green-400">{{ $character->stats->intelligence ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_intelligence ?? 0 }}</span>
        </span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">CHA</span>
        <span>
            <span class="text-green-400">{{ $character->stats->charisma ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_charisma ?? 0 }}</span>
        </span>
    </div>

    <div class="border-t border-base-content/10 my-2"></div>

    <div class="flex justify-between">
        <span class="text-base-content/60">MR</span>
        <span>
            <span class="text-green-400">{{ $character->stats->magic_resist ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_magic_resist ?? 0 }}</span>
        </span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">FR</span>
        <span>
            <span class="text-green-400">{{ $character->stats->fire_resist ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_fire_resist ?? 0 }}</span>
        </span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">CR</span>
        <span>
            <span class="text-green-400">{{ $character->stats->cold_resist ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_cold_resist ?? 0 }}</span>
        </span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">PR</span>
        <span>
            <span class="text-green-400">{{ $character->stats->poison_resist ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_poison_resist ?? 0 }}</span>
        </span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">DR</span>
        <span>
            <span class="text-green-400">{{ $character->stats->disease_resist ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_disease_resist ?? 0 }}</span>
        </span>
    </div>
    <div class="flex justify-between">
        <span class="text-base-content/60">CORRUPT</span>
        <span>
            <span class="text-green-400">{{ $character->stats->corruption_resist ?? 0 }}</span>
            <span class="text-heroic-stat">+{{ $character->stats->heroic_corruption_resist ?? 0 }}</span>
        </span>
    </div>
</div>
