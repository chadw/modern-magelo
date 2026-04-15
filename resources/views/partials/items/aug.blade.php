@switch($item->itemtype)
    @case(0)
    @case(2)

    @case(3)
    @case(42)

    @case(1)
    @case(4)

    @case(35)
        @php $itemTypePrefix = 'Skill'; @endphp
    @break

    @default
        @php $itemTypePrefix = 'Item Type'; @endphp
@endswitch

@php
    $tags = [];
    if ($item->itemtype == 54) {
        $tags[] = 'Augment';
    }
    if ($item->magic == 1) {
        $tags[] = 'Magic';
    }
    if ($item->loregroup == -1) {
        $tags[] = 'Lore';
    }
    if ($item->nodrop == 0) {
        $tags[] = 'No Trade';
    }
    if ($item->norent == 0) {
        $tags[] = 'No Rent';
    }
    if ($item->questitemflag == 1) {
        $tags[] = 'Quest';
    }
    if ($item->attuneable == 1) {
        $tags[] = 'Attuneable';
    }

    $itemTypes = config('everquest.item_types');
    $itemTypeName = $itemTypes[$item['itemtype']] ?? null;
    $itemValue = calculate_item_price($item->price);
@endphp
<div class="w-full p-4 bg-base-200 rounded-lg border-1 border-base-content">
    <div class="flex justify-between items-start">
        <h2 class="font-bold">{{ $item->Name }}</h2>
        <img src="{{ asset('img/icons/' . $item->icon . '.png') }}" alt="{{ $item->Name }}" class="w-4 h-auto ml-4" />
    </div>
    <div class="mt-2 space-y-1 text-sm text-gray-300">
        <div>{{ implode(', ', $tags) }}</div>
        @if ($item->classes > 0)
            <div><strong>Class:</strong> {{ get_class_usable_string($item->classes) }}</div>
        @endif
        @if ($item->races > 0)
            <div><strong>Race:</strong> {{ get_race_usable_string($item->races) }}</div>
        @endif
        @if ($item->deity > 0)
            <div><strong>Deity:</strong> {{ get_deity_usable_string($item->deity) }}</div>
        @endif
        @if ($item->slots > 0)
            <div>{{ get_slots_string($item->slots) }}</div>
        @endif
    </div>
</div>
