@if ($character->anon == 0)
    <div x-data x-init="$store.invSearch.load({{ Js::from($invIndex) }})">
@else
    <div x-data>
@endif

    @if ($character->anon == 0)
        <div class="mb-4 flex items-center gap-3">
            <div class="w-90 relative">
                <input type="text"
                    x-model.debounce.200ms="$store.invSearch.query"
                    placeholder="Search inventory by item id or name"
                    class="input w-full pr-8 text-sm" />
                <button x-show="$store.invSearch.query.length > 0"
                    x-cloak
                    @click="$store.invSearch.clear()"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-base-content/40 hover:text-red-500 text-sm font-bold cursor-pointer">&times;</button>
            </div>
            <div x-show="$store.invSearch.isActive() && $store.invSearch.matchedIds.size > 0" x-cloak class="text-xs text-base-content/50">
                <span x-text="$store.invSearch.matchedIds.size"></span> item(s) found
            </div>
            <div x-show="$store.invSearch.isActive() && $store.invSearch.matchedIds.size === 0" x-cloak class="text-xs text-warning">
                No items found
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-[auto_1fr] gap-6 items-start">
        <div class="space-y-3">
            <div class="bg-base-300 shadow-md border border-base-content/10 rounded-lg overflow-visible">
                <div class="p-4">
                    <div class="flex items-start gap-4">
                        @include('character.partials.stats')
                        {{-- worn items --}}
                        <div class="border-l border-base-content/10 pl-4">
                            <div class="relative bg-no-repeat w-[174px] h-[350px]"
                                style="background-image: url('{{ asset('img/inventory-slots.png') }}');">
                                @foreach ($items['gear'] as $inv)
                                    @if ($inv->item)
                                            <span class="absolute invslot slot{{ $inv->slot_id }} select-none font-sans">
                                                <x-item-link
                                                    :item_id="$inv->item->id"
                                                    :item_name="$inv->item->Name"
                                                    :item_icon="$inv->item->icon"
                                                    item_class="flex"
                                                    :augs="[$inv->aug1?->id ?? 0, $inv->aug2?->id ?? 0, $inv->aug3?->id ?? 0, $inv->aug4?->id ?? 0, $inv->aug5?->id ?? 0, $inv->aug6?->id ?? 0]"
                                                />
                                            </span>
                                        @endif
                                @endforeach
                            </div>
                        </div>
                        <div>
                            @include('character.partials.inventory.player-inline')
                        </div>
                    </div>
                </div>
            </div>

            <div x-data="{ open: false }" class="bg-base-300 shadow-md border border-base-content/10 rounded-lg overflow-visible">
                <button @click="open = !open" class="flex items-center justify-between w-full text-sm font-bold px-4 py-3 cursor-pointer">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 13a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -6" /><path d="M9 9a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -10" /><path d="M15 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -14" /><path d="M4 20h14" />
                        </svg>
                        Additional Stats
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-cloak
                    x-transition:enter="transition-all ease-out duration-200"
                    x-transition:enter-start="opacity-0 max-h-0"
                    x-transition:enter-end="opacity-100 max-h-[2000px]"
                    x-transition:leave="transition-all ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="px-4 pb-4">
                    <div class="font-mono text-sm">
                        @include('character.partials.additional-stats')
                    </div>
                </div>
            </div>

            @if ($character->anon === 1)
                <div class="bg-base-300 shadow-md border border-base-content/10 rounded-lg p-4">
                    <div class="flex items-center mb-3 gap-2">
                        <h3 class="text-sm font-bold">Tribute</h3>
                    </div>
                    <x-ui.alert-info>
                        This character is set to Anonymous, so tribute is hidden.
                    </x-ui.alert-info>
                </div>
            @else
                @if ($character->tribute && $character->tribute->count())
                    <div class="bg-base-300 shadow-md border border-base-content/10 rounded-lg p-4">
                        <div class="flex items-center mb-3 gap-2">
                            <h3 class="text-sm font-bold">Tribute</h3>
                            <span class="badge badge-sm badge-soft badge-accent">{{ $character->tribute->count() }}</span>
                        </div>
                        @foreach ($character->tribute as $tribute)
                            <div class="flex items-center gap-3 mt-2 p-2 rounded odd:bg-base-100 even:bg-base-200/50">
                                <div class="text-sm font-bold">
                                    {{ $tribute->_tribute?->name ?? 'Unknown' }}
                                </div>
                                <div class="flex-1 border-b border-dotted border-base-content/20"></div>
                                <div class="font-medium text-xs font-mono">
                                    {{ (int) ($tribute->tier ?? 0) + 1 }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mt-2">No tribute on record.</p>
                @endif
            @endif

            <div class="bg-base-300 shadow-md border border-base-content/10 rounded-lg p-4">
                <div class="mb-3">
                    <h3 class="text-sm font-bold">Character Mover</h3>
                    <p class="text-xs text-base-content/50">Enter account login and select destination zone</p>
                </div>
                <form method="POST" action="{{ route('character.move', $character) }}">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 items-end">
                        <div>
                            <label for="login" class="floating-label">
                                <span>Login</span>
                                <input name="login" id="login" type="text" placeholder="Login" value="{{ old('login') }}" class="input w-full" required />
                            </label>
                        </div>
                        <div>
                            <label for="zone" class="floating-label">
                                <span>Zone</span>
                                <select name="zone_id" id="zone" class="select w-full">
                                    @forelse (config('everquest.char_mover_zones') as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @empty
                                        <option value="152">Nexus</option>
                                        <option value="202">Plane of Knowledge</option>
                                    @endforelse
                                </select>
                            </label>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-soft btn-accent">Move</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-4 min-w-0">
            <div x-data="{ open: true }" class="bg-base-300 shadow-md border border-base-content/10 rounded-lg overflow-visible">
                <button @click="open = !open" class="flex items-center justify-between w-full text-sm font-bold px-4 py-3 cursor-pointer">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 21l18 0" /><path d="M3 10l18 0" /><path d="M5 6l7 -3l7 3" /><path d="M4 10l0 11" /><path d="M20 10l0 11" /><path d="M8 14l0 3" /><path d="M12 14l0 3" /><path d="M16 14l0 3" />
                        </svg>
                        Bank
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open"
                    x-transition:enter="transition-all ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-all ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="overflow-visible">
                    <div class="px-4 pb-4">

                        @include('character.partials.inventory.bank')

                        <div class="border-t border-base-content/10 mt-4 pt-3">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Shared Bank</span>
                                <div class="flex items-center gap-2 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="w-4 h-4 text-slate-200">
                                        <path d="M8 7c3.314 0 6-1.343 6-3s-2.686-3-6-3-6 1.343-6 3 2.686 3 6 3Z" />
                                        <path d="M8 8.5c1.84 0 3.579-.37 4.914-1.037A6.33 6.33 0 0 0 14 6.78V8c0 1.657-2.686 3-6 3S2 9.657 2 8V6.78c.346.273.72.5 1.087.683C4.42 8.131 6.16 8.5 8 8.5Z" />
                                        <path d="M8 12.5c1.84 0 3.579-.37 4.914-1.037.366-.183.74-.41 1.086-.684V12c0 1.657-2.686 3-6 3s-6-1.343-6-3v-1.22c.346.273.72.5 1.087.683C4.42 12.131 6.16 12.5 8 12.5Z" />
                                    </svg>
                                    <span>{{ number_format($character->account->sharedplat, 0) }}</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                @include('character.partials.inventory.sharedbank')
                            </div>
                        </div>
                        <div class="border-t border-base-content/10 mt-4 pt-3">
                            <div class="flex flex-wrap justify-start gap-x-4 gap-y-2 text-sm">
                                @include('character.partials.currency', [
                                    'coins' => [
                                        'platinum' => $character->currency->platinum_bank,
                                        'gold' => $character->currency->gold_bank,
                                        'silver' => $character->currency->silver_bank,
                                        'copper' => $character->currency->copper_bank,
                                    ],
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $augCount = 0;
                foreach ($items['gear'] as $inv) {
                    if (!$inv->item) continue;
                    for ($i = 1; $i <= 6; $i++) {
                        $aug = $inv->{'aug' . $i} ?? null;
                        $type = $inv->item->{'augslot' . $i . 'type'} ?? 0;
                        if ($aug && $type > 0) $augCount++;
                    }
                }
            @endphp

            <div x-data="{ open: false }" class="bg-base-300 shadow-md border border-base-content/10 rounded-lg overflow-visible">
                <button @click="open = !open" class="flex items-center justify-between w-full text-sm font-bold px-4 py-3 cursor-pointer">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873l-6.158 -3.245" />
                        </svg>
                        Augs
                        <span class="badge badge-sm badge-soft badge-accent">{{ $augCount }}</span>
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-cloak
                    x-transition:enter="transition-all ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-all ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="overflow-visible">
                    <div class="px-4 pb-4">
                        @include('character.partials.augs')
                    </div>
                </div>
            </div>

            @if ($character->keys && $character->keys->count())
            <div x-data="{ open: false }" class="bg-base-300 shadow-md border border-base-content/10 rounded-lg overflow-visible">
                <button @click="open = !open" class="flex items-center justify-between w-full text-sm font-bold px-4 py-3 cursor-pointer">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0" /><path d="M15 9h.01" />
                        </svg>
                        Keys
                        <span class="badge badge-sm badge-soft badge-accent">{{ $character->keys->count() }}</span>
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-cloak
                    x-transition:enter="transition-all ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-all ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="overflow-visible">
                    <div class="px-4 pb-4">
                        @include('character.partials.keys')
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
