@php
    $ddActive = Route::is('char.mover.*', 'ldon.*');
@endphp
<div id="navbar-trigger" class="h-0"></div>
<nav class="navbar bg-neutral mb-3 sticky top-0 z-50">
    <div class="container mx-auto px-4 flex items-center justify-between w-full">

        <div class="flex items-center xl:w-1/3 w-auto">
            <a href="/" class="xl:hidden">
                <img src="{{ asset('img/laz.png') }}" class="min-w-[80px] min-h-[29px]">
            </a>

            <div class="dropdown xl:hidden ml-2">
                <label tabindex="0" class="btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </label>
                <ul tabindex="0" class="dropdown-content mt-3 z-[60] menu p-2 shadow bg-base-200 rounded-box w-52">
                    <li><a href="/" class="uppercase">/</a></li>
                    <li><a href="{{ route('bazaar.index') }}" class="uppercase">Bazaar</a></li>
                    <li><a href="{{ route('history.index') }}" class="uppercase">Bazaar History</a></li>
                    <li><a href="{{ route('barter.index') }}" class="uppercase">Barter</a></li>
                    <li><a href="{{ route('ldon.index') }}" class="uppercase">LDONs</a></li>
                    @if (config('everquest.char_mover_enabled'))
                        <li><a href="{{ route('char.mover.index') }}" class="uppercase">Char Mover</a></li>
                    @endif
                    <li class="divider my-1 h-px" role="separator"></li>
                    <li><a href="{{ config('everquest.alla_base_url') }}"
                            title="{{ config('everquest.alla_menu_name') }}">
                            {{ config('everquest.alla_menu_name') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div id="laz-desktop-logo" class="hidden xl:flex justify-center xl:w-1/3 relative">
            <a href="/" class="block absolute -top-9" title="Project Lazarus EQEmu">
                <img src="{{ asset('img/laz.png') }}" class="w-[200px] h-[72px]">
            </a>
        </div>

        <div class="flex items-center justify-end xl:w-1/3 w-full">
            @include('layouts.partials.suggest-search')
        </div>

        <div class="hidden xl:flex space-x-2 absolute left-5 top-1/2 -translate-y-1/2">
            <a href="/" title="{{ config('app.name') }}" class="btn btn-ghost uppercase {{ Route::is('home') ? 'btn-active' : '' }}">/</a>
            <a href="{{ route('bazaar.index') }}" class="btn btn-ghost uppercase {{ Route::is('bazaar.*') ? 'btn-active' : '' }}">Bazaar</a>
            <a href="{{ route('history.index') }}" class="btn btn-ghost uppercase {{ Route::is('history.*') ? 'btn-active' : '' }}">Bazaar History</a>
            <a href="{{ route('barter.index') }}" class="btn btn-ghost uppercase {{ Route::is('barter.*') ? 'btn-active' : '' }}">Barter</a>
            <div class="dropdown dropdown-hover">
                <label tabindex="0"
                    class="btn btn-ghost uppercase flex items-center gap-1 {{ $ddActive ? 'btn-active' : '' }}"
                    title="More">
                    More
                    <svg class="chevron h-4 w-4 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </label>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="{{ route('ldon.index') }}"
                            class="{{ Route::is('ldon.*') ? 'active bg-base-200' : '' }}"
                            title="LDONs">LDONs</a></li>
                    @if (config('everquest.char_mover_enabled'))
                    <li><a href="{{ route('char.mover.index') }}"
                            class="{{ Route::is('char.mover.*') ? 'active bg-base-200' : '' }}"
                            title="Character Mover">Character Mover</a></li>
                    @endif
                    <li class="divider my-1 h-px" role="separator"></li>
                    <li><a href="{{ config('everquest.alla_base_url') }}"
                            title="{{ config('everquest.alla_menu_name') }}">
                            {{ config('everquest.alla_menu_name') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</nav>
