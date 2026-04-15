@if ($sellerCharacter && $sellerItems)
<div class="mt-6">
    <h4>{{ $sellerCharacter->name }}'s Inventory</h4>
    <div class="border border-base-content/10 p-4 max-h-96 overflow-y-auto">
        <div class="grid grid-cols-3 gap-x-2">
        @foreach ($sellerItems as $sellerItem)
            <div class="col-span-2 flex items-center">
                <x-item-link-normal
                    :item_id="$sellerItem->item->id"
                    :item_name="$sellerItem->item->Name"
                    :item_icon="$sellerItem->item->icon"
                    item_class="flex-inline"
                />
            </div>
            <span class="text-right">{{ $sellerItem->charges }}</span>
        @endforeach
        </div>
    </div>
</div>
@endif
