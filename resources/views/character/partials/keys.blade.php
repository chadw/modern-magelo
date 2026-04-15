<div class="grid gap-1 justify-start [grid-template-columns:repeat(auto-fill,42px)]">
    @foreach ($character->keys as $key)
        <div class="group aspect-square h-[42px] bg-base-300 border border-base-content/20 cursor-pointer relative select-none">
            <x-item-link
                :item_id="$key->item->id"
                :item_name="$key->item->Name"
                :item_icon="$key->item->icon"
                item_class="flex"
            />
        </div>
    @endforeach
</div>
