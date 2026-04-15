@php
    $anonFlag = $character->anon ?? 0;
@endphp

@if ($anonFlag >= 1)
    <span class="text-sm text-base-content/50">Hidden</span>
@else
    <span>{{ number_format($value, 0) }}</span>
@endif
