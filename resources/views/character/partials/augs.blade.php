@php
    $augSlots = config('everquest.slots_inv');
    $augTypeDescs = config('everquest.aug_type_descriptions');

    $gearWithAugs = $items['gear']->filter(function ($inv) {
        if (!$inv->item) return false;
        return $inv->aug1 || $inv->aug2 || $inv->aug3 || $inv->aug4 || $inv->aug5 || $inv->aug6;
    });
@endphp

@if ($gearWithAugs->isNotEmpty())
    <div class="space-y-3 text-sm">
        @foreach ($gearWithAugs as $inv)
            @php
                $augEntries = [];
                for ($i = 1; $i <= 6; $i++) {
                    $aug = $inv->{'aug' . $i};
                    $type = $inv->item->{'augslot' . $i . 'type'} ?? 0;
                    if ($aug && $type > 0) {
                        $desc = $augTypeDescs[$type] ?? '';
                        $augEntries[] = [
                            'slot' => $i,
                            'aug' => $aug,
                            'type' => $type,
                            'desc' => $desc,
                        ];
                    }
                }
            @endphp
            @if (count($augEntries))
            <div>
                <div class="font-bold text-base-content mb-1 divider divider-start">{{ $augSlots[$inv->slot_id] ?? 'Slot ' . $inv->slot_id }}</div>
                <div class="flex flex-col gap-1 text-base-content/80">
                    @foreach ($augEntries as $k => $entry)
                        @php $augTtid = tooltip_uid(); @endphp
                        <span class="flex items-center gap-1">
                            <strong>Slot {{ $entry['slot'] }}:</strong>
                            <x-item-link-normal
                                :item_id="$entry['aug']->id"
                                :item_name="$entry['aug']->Name"
                                :item_icon="$entry['aug']->icon"
                                item_class="inline-flex items-center"
                                :instance="$augTtid"
                            />
                            <span class="md:hidden text-base-content/50">Type {{ $entry['type'] }}</span>
                            <span class="hidden md:inline text-base-content/50">Type {{ $entry['type'] }}{{ $entry['desc'] ? " ({$entry['desc']})" : '' }}</span>
                        </span>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
    </div>
@else
    <p class="text-sm text-base-content/50">No augments found on worn equipment.</p>
@endif
