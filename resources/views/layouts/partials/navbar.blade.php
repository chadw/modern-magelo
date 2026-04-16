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
                    <li><a href="{{ route('bazaar.index') }}" class="uppercase">Bazaar</a></li>
                    <li><a href="{{ route('barter.index') }}" class="uppercase">Barter</a></li>
                    <li><a href="{{ route('ldon.index') }}" class="uppercase">LDONs</a></li>
                    <li><a href="{{ route('char.mover.index') }}" class="uppercase">Char Mover</a></li>
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
            <a href="{{ route('bazaar.index') }}" class="btn btn-ghost uppercase {{ Route::is('bazaar.*') ? 'btn-active' : '' }}">Bazaar</a>
            <a href="{{ route('barter.index') }}" class="btn btn-ghost uppercase {{ Route::is('barter.*') ? 'btn-active' : '' }}">Barter</a>
            <a href="{{ route('ldon.index') }}" class="btn btn-ghost uppercase  {{ Route::is('ldon.*') ? 'btn-active' : '' }}">LDONs</a>
            <a href="{{ route('char.mover.index') }}" class="btn btn-ghost uppercase  {{ Route::is('char.mover.*') ? 'btn-active' : '' }}">Char Mover</a>
        </div>

    </div>
</nav>
