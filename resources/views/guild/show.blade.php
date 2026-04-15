@extends('layouts.default')
@section('title', 'Guild Details - ' . $guild->name)

@section('content')
    <div class="flex w-full flex-col">
        <div class="stats shadow space-y-6">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                        <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                        <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                    </svg>
                </div>
                <div class="stat-title">Members</div>
                <div class="stat-value">{{ $guild->members->count() }}</div>
            </div>

            <div class="stat">
                <div class="stat-figure text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 6l4 6l5 -4l-2 10h-14l-2 -10l5 4z" />
                    </svg>
                </div>
                <div class="stat-title">Leader</div>
                <div class="stat-value">
                    <a class="link-accent link-hover"
                        href="{{ route('character.show', strtolower($guild->leaderCharacter->name)) }}">
                        {{ $guild->leaderCharacter->name }}
                    </a>
                </div>
            </div>

            <div class="stat">
                <div class="stat-figure text-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 21v-14" />
                        <path d="M9 15l3 -3l3 3" />
                        <path d="M15 10l3 -3l3 3" />
                        <path d="M3 21l18 0" />
                        <path d="M12 21l0 -9" />
                        <path d="M3 6l3 -3l3 3" />
                        <path d="M6 21v-18" />
                    </svg>
                </div>
                <div class="stat-title">Avg Level</div>
                <div class="stat-value">{{ $avgLevel }}</div>
            </div>
        </div>
    </div>

    <div class="border border-base-content/5 overflow-x-auto mb-6">
        <table class="table table-sm md:table-md table-auto table-zebra md:table-fixed w-full">
            <thead class="text-xs uppercase bg-base-300">
                <tr>
                    <th scope="col" width="30%">{!! sortLink('name', 'Name') !!}</th>
                    <th scope="col" width="20%">Rank</th>
                    <th scope="col" width="25%" class="hidden md:table-cell">Class</th>
                    <th scope="col" width="15%" class="hidden md:table-cell">Race</th>
                    <th scope="col" width="10%" class="text-right">{!! sortLink('level', 'Level') !!}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td scope="row">
                            <a class="text-base link-info link-hover"
                                href="{{ route('character.show', strtolower($member->character->name)) }}">
                                {{ $member->character->name }}
                            </a>
                        </td>
                        <td>{{ $member->guildRank?->title }}</td>
                        <td class="hidden md:table-cell">
                            {{ config('everquest.classes.' . $member->character->class) ?? null }}</td>
                        <td class="hidden md:table-cell">{{ config('everquest.races.' . $member->character->race) ?? null }}
                        </td>
                        <td class="text-right">{{ $member->character->level }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $members->onEachSide(2)->links() }}
@endsection
