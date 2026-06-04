<form method="GET" action="{{ route('history.index') }}" class="space-y-6 sticky top-24">
    <div>
        <label for="history-seller" class="floating-label">
            <input
                type="text"
                id="history-seller"
                name="seller"
                value="{{ request('seller') }}"
                class="input w-full"
            />
            <span>Seller Name</span>
        </label>
    </div>
    <div x-data="itemSuggest('{{ request('item') }}')" class="relative">
        <label for="history-item" class="floating-label">
            <input
                type="text"
                id="history-item"
                name="item"
                x-model="query"
                class="input w-full pr-10"
                autocomplete="off"
            />
            <span>Item Name</span>
        </label>

        <span class="absolute right-3 top-1/2 -translate-y-1/2" x-show="loading" x-cloak>
            <span class="loading loading-spinner loading-sm"></span>
        </span>

        <div x-show="items.length" x-cloak x-transition class="absolute z-50 left-0 right-0 mt-1 bg-base-100 border border-base-content/10 rounded shadow-lg max-h-60 overflow-y-auto">
            <template x-for="(item, idx) in items" :key="idx">
                <div x-text="item" @mousedown.prevent="select(item)" class="px-3 py-2 hover:bg-base-200 cursor-pointer text-sm"></div>
            </template>
        </div>
    </div>
    <div>
        <label for="history-from" class="floating-label">
            <input
                type="datetime-local"
                name="from"
                value="{{ request('from') }}"
                class="input w-full"
            />
            <span>Date From</span>
        </label>
    </div>
    <div>
        <label for="history-to" class="floating-label">
            <input
                type="datetime-local"
                name="to"
                value="{{ request('to') }}"
                class="input w-full"
            />
            <span>Date To</span>
        </label>
    </div>
    <div class="join w-full">
        <button type="submit" class="join-item btn btn-soft btn-success btn-sm flex-1">Search</button>
        <a class="join-item btn btn-soft btn-sm btn-error flex-1" href="{{ route('history.index') }}">Reset</a>
    </div>
</form>
