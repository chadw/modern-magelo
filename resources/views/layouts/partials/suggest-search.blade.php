<form method="GET" action="{{ route('search.results') }}" class="flex items-center space-x-2 w-full justify-end">
    <div x-data="eqsearch()" @click.away="results = []" class="relative w-full max-w-xs">
        <input type="text" name="q" placeholder="Search Characters and Guilds..." x-model="query"
            @input.debounce.600ms="load" @focus="if (query.length > 0) load()"
            class="input w-full focus:outline-none" autocomplete="off" />
        <div x-show="results.length > 0 || loading"
            class="absolute right-0 mt-2 z-50
                    max-h-90 overflow-y-auto scrollbar-thin scrollbar-thumb-accent scrollbar-track-base-300
                    sm:max-h-none sm:overflow-visible sm:scrollbar-none
                    sm:min-w-full sm:w-screen sm:max-w-md lg:max-w-lg xl:max-w-2xl">
            <div class="bg-base-200 border border-sky-900/50 rounded shadow-lg p-2">
                <template x-if="loading">
                    <div class="flex justify-center items-center p-2">
                        <span class="loading loading-ring loading-md"></span>
                    </div>
                </template>
                <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                    <template x-for="result in results" :key="result.id">
                        <li class="hover:bg-base-100 cursor-pointer rounded p-1 px-2 transition">
                            <a :href="result.url" class="flex justify-between items-center space-x-2">
                                <span class="block text-sm text-base-content truncate"
                                    x-text="result.name"></span>
                                <span class="text-xs text-accent whitespace-nowrap"
                                    :class="{
                                        'text-accent': result.type === 'guild',
                                        'text-info': result.type === 'char',
                                    }"
                                    x-text="result.type"></span>
                            </a>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</form>
