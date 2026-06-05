<div x-data="discoveredList('{{ $character->name }}')" class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="text-sm">Total discovered items: <span class="font-bold" x-text="total"></span></div>
        <div class="text-sm text-base-content/60">Showing <span x-text="items.length"></span> per page</div>
    </div>

    <div class="rounded p-2">
        <template x-if="loading">
            <div class="p-4 text-center">Loading...</div>
        </template>

        <template x-if="!loading && items.length === 0">
            <div class="p-4 text-center text-base-content/50">No discovered items found.</div>
        </template>

        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <template x-for="itm in items" :key="itm.item_id">
                <div x-html="itm.html"></div>
            </template>
        </div>

        <div class="flex items-center justify-between mt-3">
            <div>
                <button @click.prevent="prev()" class="btn btn-sm btn-soft" :disabled="current_page <= 1">Prev</button>
                <button @click.prevent="next()" class="btn btn-sm btn-soft ml-2" :disabled="current_page >= last_page">Next</button>
            </div>
            <div class="text-sm text-base-content/60">Page <span x-text="current_page"></span> of <span x-text="last_page"></span></div>
        </div>
    </div>
</div>
