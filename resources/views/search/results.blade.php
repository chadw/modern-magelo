@extends('layouts.default')
@section('title', 'Search Results for ' . $query)

@section('content')
    <div class="space-y-6">
        @if ($results->count())
            <ul class="grid sm:grid-cols-2 md:grid-cols-4 gap-2">
                @foreach ($results as $result)
                    <li class="flex justify-between items-center gap-2 border border-base-content/10 p-2 rounded">
                        <a href="{{ $result['url'] }}" class="
                            @if ($result['type'] === 'guild') link-accent
                            @elseif ($result['type'] === 'char') link-info
                            @endif
                            link-hover">
                            {{ $result['name'] }}
                        </a>
                        <span class="text-xs uppercase text-right
                            @if ($result['type'] === 'guild') text-accent
                            @elseif ($result['type'] === 'char') text-info
                            @endif"
                        >
                            {{ $result['type'] }}
                        </span>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                {{ $results->links() }}
            </div>
        @endif
    </div>
@endsection
