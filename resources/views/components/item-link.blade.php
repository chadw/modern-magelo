@php
    $tooltipId = 'tooltip-' . $itemId . (isset($instance) && $instance ? '-' . $instance : '');
    $popupUrl = route('items.popup', $itemId);
    if (array_filter($augs)) {
        $popupUrl .= '?' . http_build_query(['augs' => implode(',', $augs)]);
    }
@endphp

<div
    x-data="{ id: '{{ $tooltipId }}' }"
    x-init="$store.tooltip.register(id)"
    class="{{ $itemClass }} relative"
    data-inv-item-id="{{ $itemId }}"
    data-inv-item-name="{{ $itemName }}"
>
    <a href="#"
        @mouseenter="$store.tooltip.show(id, '{{ $popupUrl }}', $el, $event)"
        @mouseleave="$store.tooltip.hide(id)"
        @click.prevent="$store.tooltip.toggleLock(id)"
        class="link-info link-hover flex items-center gap-1"
        title="{{ $itemName }}">

        @if (isset($itemIcon))
            <img draggable="false" src="{{ asset('img/icons/' . $itemIcon . '.png') }}" alt="{{ $itemName }}" />
        @endif
    </a>
</div>
