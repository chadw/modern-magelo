<div class="relative">
    <div class="grid gap-1 [grid-template-columns:repeat(2,42px)]">
    @for ($bagSlotId = 23; $bagSlotId <= 32; $bagSlotId++)
        @php
            $inv = $items['bags']->firstWhere('slot_id', $bagSlotId);
            $bagSize = $inv->item->bagslots ?? 0;
            $startSlotId = 4010 + ($bagSlotId - 23) * 200;

            $itemsBySlotId = $items['bag_items']
                ->whereBetween('slot_id', [$startSlotId, $startSlotId + 199])
                ->keyBy('slot_id');

            $columns = match (true) {
                $bagSize <= 4 => 2,
                $bagSize <= 10 => 2,
                $bagSize <= 20 => 7,
                $bagSize <= 32 => 8,
                $bagSize <= 40 => 8,
                default => 8,
            };
        @endphp
        <div x-data="draggableBag({ id: {{ $bagSlotId }} })" x-init="$watch('visible', value => { if (value) bringToFront(); })" class="relative">
            @php $ttid = tooltip_uid(); @endphp
            <div class="group aspect-square h-[42px] bg-base-300 border border-base-content/20 cursor-pointer relative select-none"
                data-inv-bag-slot="{{ $bagSlotId }}"
                @if ($character->anon == 0 || $character->anon == 2)
                    @click.prevent="openBag($event.currentTarget); $store.tooltip.unlock('tooltip-{{ $inv->item->id ?? '' }}-{{ $ttid }}'); $store.tooltip.activeTooltipId = null"
                @endif
            >
                @if ($inv && $bagSize > 0 && ($character->anon == 0 || $character->anon == 2))
                    <div class="indicator absolute bottom-0 right-0">
                        <span class="indicator-item badge badge-xs text-[10px] bg-base-200 text-white shadow-md">
                            {{ count($itemsBySlotId) }}/{{ $bagSize }}
                        </span>
                    </div>
                @endif
                @if ($inv && $inv->item && ($character->anon == 0 || $character->anon == 2))
                    <x-item-link
                        :item_id="$inv->item->id"
                        :item_name="$inv->item->Name"
                        :item_icon="$inv->item->icon"
                        item_class="flex"
                        :instance="$ttid"
                        :augs="[$inv->aug1?->id ?? 0, $inv->aug2?->id ?? 0, $inv->aug3?->id ?? 0, $inv->aug4?->id ?? 0, $inv->aug5?->id ?? 0, $inv->aug6?->id ?? 0]"
                    />
                    @if ($inv->charges > 0 && $bagSize <= 0)
                        <div class="indicator absolute bottom-1 right-1 cursor-default">
                            <span class="indicator-item text-[10px] bg-base-200 text-white">
                                {{ $inv->charges }}
                            </span>
                        </div>
                    @endif
                @endif
            </div>
            @if ($bagSize > 0)
                <svg class="pointer-events-none fixed top-0 left-0 w-screen h-screen z-[999]" x-show="visible" x-cloak>
                    <line x-bind:x1="originX" x-bind:y1="originY" x-bind:x2="targetX"
                        x-bind:y2="targetY" stroke="gray" stroke-dasharray="3" stroke-width="1" />
                </svg>
                <div x-ref="bagWindow" x-show="visible" x-cloak @mousedown.prevent="startDrag($event)"
                    @mousemove.window="drag($event)" @mouseup.window="stopDrag()"
                    :style="`top: ${top}px; left: ${left}px; z-index: ${zIndex}`"
                    class="fixed bg-base-100 border border-gray-600 rounded shadow-lg">
                    <div class="flex justify-between items-center bg-neutral text-sm px-3 py-1 rounded-t cursor-move"
                        @mousedown.prevent="startDrag($event)" @click.stop>
                        <span class="mr-2 truncate max-w-[150px]">
                            {{ $inv->item->Name ?? 'Bag' }}
                        </span>
                        <button @click="closeBag()"
                            class="btn btn-xs btn-neutral focus:outline-none m-0">&times;</button>
                    </div>
                    <div class="p-2" @click.stop>
                        <div class="grid gap-1 justify-between items-center"
                            style="grid-template-columns: repeat({{ $columns }}, 42px);">
                            @for ($i = 0; $i < $bagSize; $i++)
                                @php
                                    $slotId = $startSlotId + $i;
                                    $item = $itemsBySlotId[$slotId] ?? null;
                                @endphp
                                <div class="w-[42px] h-[42px] bg-base-200 border border-base-content/20 relative">
                                    @if ($item && $item->item && ($character->anon == 0 || $character->anon == 2))
                                        <x-item-link
                                            :item_id="$item->item->id"
                                            :item_name="$item->item->Name"
                                            :item_icon="$item->item->icon"
                                            item_class="flex"
                                            :augs="[$item->aug1?->id ?? 0, $item->aug2?->id ?? 0, $item->aug3?->id ?? 0, $item->aug4?->id ?? 0, $item->aug5?->id ?? 0, $item->aug6?->id ?? 0]"
                                        />
                                        @if ($item->charges > 0 && $item->charges !== 32767 && $item->item->stackable)
                                            <div class="indicator absolute bottom-1 right-1 cursor-default">
                                                <span class="indicator-item text-[10px] bg-base-200 text-white">
                                                    {{ $item->charges }}
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endfor
    </div>
</div>
