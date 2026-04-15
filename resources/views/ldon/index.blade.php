@extends('layouts.default')
@section('title', 'LDoN Stats')

@section('content')

<div class="flex gap-6">
    <div class="w-1/5 min-w-[300px]">
        @include('ldon.partials.search')
    </div>
    <div class="w-4/5">
        <div class="border border-base-content/5 overflow-x-auto mb-6">
            <table class="table table-sm md:table-md table-auto table-zebra md:table-fixed w-full">
                <thead class="text-xs uppercase bg-base-300">
                    <tr>
                        <th scope="col" width="40%">{!! sortLink('name', 'Name') !!}</th>
                        <th scope="col" width="10%">{!! sortLink('rank', 'Rank') !!}</th>
                        <th scope="col" width="20%">{!! sortLink('success', 'Success') !!}</th>
                        <th scope="col" width="20%">{!! sortLink('failure', 'Fail') !!}</th>
                        <th scope="col" width="30%" class="text-right">{!! sortLink('percent', 'Percent') !!}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ldonPlayers as $ldon)
                        <tr>
                            <td scope="row">
                                <a class="text-base link-info link-hover"
                                    href="{{ route('character.show', strtolower($ldon->name)) }}">
                                    {{ $ldon->name }}
                                </a>
                                @if (!empty($ldon->guild_name))
                                    <span class="text-sm text-base-content/60">
                                        <a href="{{ route('guild.show', strtolower($ldon->guild_name)) }}" class="link-accent link-hover">
                                            &lt;{{ e($ldon->guild_name) }}&gt;
                                        </a>
                                    </span>
                                @endif
                            </td>
                            <td>{{ $ldon->rank }}</td>
                            <td>{{ $ldon->success }}</td>
                            <td>{{ $ldon->failure }}</td>
                            <td class="text-right">{{ $ldon->percent }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                No results found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $ldonPlayers->onEachSide(2)->links() }}
    </div>
</div>
@endsection
