@php
    $template = config('everquest.item_links');
    $href = $template ? str_replace('{item_id}', $itemId, $template) : '#';
    $hasHref = $href && $href !== '#';
@endphp
<div x-data class="{{ $itemClass }}">
    <a @if(!$hasHref) href="#" @click.prevent @else href="{{ $href }}" target="_blank" rel="noopener" @endif
        @mouseenter="$store.tooltipz.loadTooltip('{{ route('items.popup', $itemId) }}', $el, $event)"
        @mouseleave="$store.tooltipz.hideTooltip()"
        class="text-base link-info link-hover flex items-center gap-2"
        title="{{ $itemName }}">

        @if (isset($itemIcon))
            <span class="item-icon item-{{ $itemIcon }} item-icon-sm" aria-hidden="true"></span>
        @endif

        <span class="whitespace-nowrap">
            {{ $itemName }}
        </span>

        <template x-if="$store.tooltipz.loadingUrl === '{{ route('items.popup', $itemId) }}'">
            <span class="loading loading-spinner loading-xs text-gray-400"></span>
        </template>
    </a>
</div>
