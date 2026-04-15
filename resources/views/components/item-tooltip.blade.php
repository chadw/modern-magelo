@php
    $tooltipId = 'tooltip-' . $item->id . ($instance ? '-' . $instance : '');
@endphp
<div
    x-ref="{{ $tooltipId }}"
    x-data
    x-init="$store.tooltip.register('{{ $tooltipId }}', $el, true)"
    x-show="$store.tooltip.tooltips.get('{{ $tooltipId }}')?.visible"
    x-transition x-cloak
    @mousemove.window.stop="$store.tooltip.drag('{{ $tooltipId }}', $event)"
    @mouseup.window.stop="$store.tooltip.stopDrag('{{ $tooltipId }}')"
    class="fixed z-[998] bg-base-200 rounded shadow-lg text-sm sm:max-w-lg max-w-sm sm:max-h-full max-h-96"
    @pointerdown.stop
    style="top: auto; left: auto; display: none;">
    <div class="relative p-0 cursor-default">
        <div class="absolute top-0 left-0 right-0 h-6 cursor-move z-0"
            @mousedown.stop="$store.tooltip.startDrag('{{ $tooltipId }}', $event); $store.tooltip.bringToFront('{{ $tooltipId }}', $event.currentTarget)"
            @mouseup.stop="$store.tooltip.stopDrag('{{ $tooltipId }}')"
        ></div>
        <button @click.stop="$store.tooltip.unlock('{{ $tooltipId }}')"
            class="absolute top-2 right-2 bg-base-300 text-gray-500 hover:text-red-500
                rounded-full w-6 h-6 flex items-center justify-center shadow-md z-10"
            title="Close">
            ✕
        </button>
        @include('partials.items.item', [
            'item' => $item,
            'augs' => $augs,
        ])
    </div>
</div>
