<div class="border border-base-content/5 bg-base-300 rounded p-3 flex flex-col h-full overflow-hidden">
    <div class="flex items-start gap-3">
        <div class="shrink-0">
            <x-item-link-normal
                :item_id="$disc->item_id"
                :item_name="optional($disc->item)->Name"
                :item_icon="optional($disc->item)->icon"
                item_class="inline-flex items-center truncate"
                :instance="$instance"
            />
        </div>
    </div>

    <div class="mt-1 text-xs text-base-content/60">
        Discovered on {{ $disc->discovered_at?->format('Y-m-d H:i') }}
    </div>
</div>
