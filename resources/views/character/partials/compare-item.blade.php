@if (empty($inv) || empty($inv->item))
    <span class="text-sm text-base-content/50">-</span>
@else
    <div class="min-w-0">
        <x-item-link-normal
            :item_id="$inv->item->id"
            :item_name="$inv->item->Name"
            :item_icon="$inv->item->icon"
            item_class="flex truncate"
        />
    </div>
@endif
