@php
    $spellTargetType = $spellTargetType ?? null;

    $template = config('everquest.spell_links');
    $href = $template ? str_replace('{spell_id}', $spellId, $template) : '#';
    $hasHref = $href && $href !== '#';

    $size = $size ?? 'md';
    $iconSizeClass = $size === 'sm' ? 'item-icon-sm' : '';
@endphp

<div x-data class="{{ $spellClass }}" data-target-type="{{ $spellTargetType ?? '' }}">
    <a @if(!$hasHref) href="#" @click.prevent @else href="{{ $href }}" target="_blank" rel="noopener" @endif
        @mouseenter="$store.tooltipz.loadTooltip('{{ route('spells.popup', $spellId) }}', $el, $event)"
        @mouseleave="$store.tooltipz.hideTooltip()"
        class="link-info link-hover flex items-center gap-1"
        title="{{ $spellName }}"
        data-effects-only="{{ $effectsOnly ? '1' : '0' }}"
        >
        @if ($spellIcon)
            <span class="spell-icon spell-{{ $spellIcon }} {{ $iconSizeClass }} rounded-lg {{ config('everquest.spell_target_colors.' . $spellTargetType, '') }}"></span>
        @endif
        <span class="whitespace-nowrap">
            {{ $spellName }}
        </span>
        <template x-if="$store.tooltipz.loadingUrl === '{{ route('spells.popup', $spellId) }}'">
            <span class="loading loading-spinner loading-xs text-gray-400"></span>
        </template>
    </a>
</div>
