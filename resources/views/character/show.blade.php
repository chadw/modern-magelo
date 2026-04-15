@extends('layouts.default')

@section('content')
    <div class="relative mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4 pb-4">
            <div class="flex items-center gap-4 min-w-0">
                <div class="shrink-0 w-14 h-14 overflow-hidden flex items-center justify-center shadow-md">
                    <div class="eqcls-sprite rounded-lg w-full h-full bg-cover bg-center {{ strtolower(Str::remove(' ', config('everquest.classes')[$character->class])) }}"></div>
                </div>
                <div class="min-w-0">
                    <h1 class="font-black text-xl xl:text-3xl truncate justify-center leading-tight">
                        {{ $character->name }}
                        @if ($character->anon === 1)
                            <span class="text-sm text-base-content/50">(Anonymous)</span>
                        @elseif ($character->anon === 2)
                            <span class="text-sm text-base-content/50">(Roleplay)</span>
                        @endif
                    </h1>
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-base-content/70">
                        <span>
                            Level <span class="font-bold text-base-content">{{ $character->level }}</span>
                            {{ config('everquest.races.' . $character->race) ?? '' }}
                            {{ config('everquest.classes.' . $character->class) ?? '' }}
                        </span>
                        <span class="text-base-content/30">|</span>
                        <span>{{ config('everquest.deity.' . $character->deity) ?? '' }}</span>
                        @if ($guild && $guild->name)
                            <span class="text-base-content/30">|</span>
                            <a href="{{ route('guild.show', strtolower($guild->name)) }}"
                                class="link-accent link-hover font-medium">
                                &lt;{{ htmlspecialchars($guild->name) }}&gt;
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="sm:ml-auto flex flex-wrap items-center gap-3 text-sm">
                @include('character.partials.currency', [
                    'coins' => [
                        'platinum' => $character->currency->platinum,
                        'gold' => $character->currency->gold,
                        'silver' => $character->currency->silver,
                        'copper' => $character->currency->copper,
                    ]
                ])
                @if ($character->anon === 0)
                    <div class="relative bg-base-100 overflow-visible">
                        <div class="dropdown dropdown-end">
                            <div tabindex="0"
                                class="ml-2 inline-flex items-center gap-2 btn btn-sm btn-soft">
                                Alt Currency
                                <span class="badge badge-sm badge-soft badge-accent">{{ $character->altCurrency->count() }}</span>
                            </div>
                            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-sm max-h-80 overflow-y-auto overflow-x-hidden flex-nowrap">
                                @if ($character->altCurrency->isNotEmpty())
                                    @foreach ($character->altCurrency as $alt)
                                        <li class="px-0">
                                            <div class="flex items-center gap-3 py-1 px-2">
                                                <div class="text-sm">
                                                    @if (optional($alt->altCurrency)->item)
                                                        <x-item-link-normal
                                                            :item_id="optional($alt->altCurrency->item)->id"
                                                            :item_name="optional($alt->altCurrency->item)->Name"
                                                            :item_icon="optional($alt->altCurrency->item)->icon"
                                                            item_class="flex items-center"
                                                        />
                                                    @else
                                                        <span class="text-sm">{{ $alt->alternate_currency_id }}</span>
                                                    @endif
                                                </div>
                                                <div class="flex-1 border-b border-dotted border-base-content/20"></div>
                                                <div class="font-medium">{{ $alt->amount ?? 0 }}</div>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="px-2 text-sm text-base-content/50">No alt currency</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="ml-2 inline-flex items-center gap-2 btn btn-sm btn-soft">
                        Alt Currency <span class="text-xs font-normal text-base-content/50">(Hidden)</span>
                    </div>
                @endif
            </div>
        </div>
        <div class="border-b border-base-content/10"></div>
    </div>

    <div class="tabs tabs-lift">
        <input type="radio" name="character_tabs" class="tab" aria-label="Main" checked="checked" />
        <div class="tab-content bg-base-100 border-base-300 p-4 sm:p-6">
            @include('character.partials.main')
        </div>
        <input type="radio" name="character_tabs" class="tab" aria-label="Skills" />
        <div class="tab-content bg-base-100 border-base-300 p-4 sm:p-6">
            @if ($character->anon === 1)
                <x-ui.alert-info>
                    This character is set to Anonymous, so skills are hidden.
                </x-ui.alert-info>
            @else
                @include('character.partials.skills')
            @endif
        </div>
        <input type="radio" name="character_tabs" class="tab" aria-label="AAs" />
        <div class="tab-content bg-base-100 border-base-300 p-4 sm:p-6">
            @if ($character->anon === 1)
                <x-ui.alert-info>
                    This character is set to Anonymous, so aa's are hidden.
                </x-ui.alert-info>
            @else
                @include('character.partials.aa')
            @endif
        </div>
        <input type="radio" name="character_tabs" class="tab" aria-label="Flags" />
        <div class="tab-content bg-base-100 border-base-300 p-4 sm:p-6">
            @if ($character->anon === 1)
                <x-ui.alert-info>
                    This character is set to Anonymous, so flags are hidden.
                </x-ui.alert-info>
            @else
                @include('character.partials.flags')
            @endif
        </div>
        <input type="radio" name="character_tabs" class="tab" aria-label="Faction" />
        <div class="tab-content bg-base-100 border-base-300 p-4 sm:p-6">
            @if ($character->anon === 1)
                <x-ui.alert-info>
                    This character is set to Anonymous, so factions are hidden.
                </x-ui.alert-info>
            @else
                @include('character.partials.faction')
            @endif
        </div>
        <input type="radio" name="character_tabs" class="tab" aria-label="Corpses" />
        <div class="tab-content bg-base-100 border-base-300 p-4 sm:p-6">
            @if ($character->anon === 1)
                <x-ui.alert-info>
                    This character is set to Anonymous, so corpses are hidden.
                </x-ui.alert-info>
            @else
                @include('character.partials.corpses')
            @endif
        </div>
    </div>
@endsection
