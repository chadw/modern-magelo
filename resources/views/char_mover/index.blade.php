@extends('layouts.default')
@section('title', 'Character Mover')

@section('content')
    <form method="POST" action="{{ route('char.mover.store') }}" x-data="charMover()" class="max-w-2xl mx-auto">
        @csrf
        <div class="flex gap-2 mb-4 justify-end">
            <button type="button" x-on:click="addRow()" class="btn btn-sm btn-soft">Add Row</button>
        </div>
        <template x-for="(row, idx) in rows" :key="idx">
            <div class="flex gap-2 items-end mb-2">
                <div class="flex-1">
                    <label :for="`login${idx}`" class="floating-label">
                        <span>Login</span>
                        <input type="text" :name="`rows[${idx}][login]`" :id="`login${idx}`" x-model="row.login"
                            class="input w-full" required />
                    </label>
                </div>
                <div class="flex-1">
                    <label :for="`char${idx}`" class="floating-label">
                        <span>Character</span>
                        <input type="text" :name="`rows[${idx}][character]`" :id="`char${idx}`" x-model="row.character"
                            class="input w-full" required />
                    </label>
                </div>
                <div>
                    <label :for="`zone${idx}`" class="floating-label">
                        <span>Zone</span>
                        <select :name="`rows[${idx}][zone_id]`" :id="`zone${idx}`" x-model="row.zone_id"
                            class="select w-full">
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
                    <button type="button" x-on:click="removeRow(idx)" class="btn btn-soft btn-error">Remove</button>
                </div>
            </div>
        </template>

        <div class="flex gap-2 mt-4">
            <button type="submit" class="btn btn-soft btn-success">Submit</button>
        </div>
    </form>

    @if(session('move_results'))
        <div class="mt-4">
            <h3 class="font-semibold">Results</h3>
            <ul class="list-disc pl-6">
                @foreach(session('move_results') as $r)
                    <li class="text-sm {{ $r['status'] === 'ok' ? 'text-success' : 'text-error' }}">
                        {{ $r['message'] }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection
